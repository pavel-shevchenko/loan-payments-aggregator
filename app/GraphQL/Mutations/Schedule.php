<?php

namespace App\GraphQL\Mutations;

use GraphQL\Error\Error;

class Schedule
{

    /**
     * Get schedule of loan payments
     *
     * @param null $_
     * @param array<string, mixed> $args
     * @return array
     * @throws Error
     */
    public function __invoke($_, array $args)
    {
        $validator = \Validator::make($args, [
            'type' => 'required|string|in:annuity,differentiated',
            'interestRate' => 'required|numeric',
            'loanAmount' => 'required|integer',
            'loanTerm' => 'required|integer',
        ]);
        if ($validator->fails()) {
            throw new Error('Need for the required parameters!');
        }

        $calcNamedArguments = [
            'loanTermInMonths' => $args['loanTerm'],
            'dateForFirstMonth' => new \Datetime(),
            'loanAmount' => $args['loanAmount'],
            'interestRate' => $args['interestRate']
        ];
        $calculator = match ($args['type']) {
            'annuity' => \Annuity::getCalculator(...$calcNamedArguments),
            'differentiated' => \Differentiated::getCalculator(...$calcNamedArguments),
        };

        $monthNumber = 0;
        $loanPayments = [];
        while ($monthNumber++ < $args['loanTerm'] * 12) {
            $loanPayments[] = [
                'monthlyPayment' => $calculator->monthlyPayment($monthNumber),
                'interestDebtPay' => $calculator->interestDebtPayment($monthNumber),
                'principalDebtPay' => $calculator->principalDebtPayment($monthNumber),
                'monthlyLoanAmount' => $calculator->monthlyLoanAmount($monthNumber),
            ];
        }

        return $loanPayments;
    }

}
