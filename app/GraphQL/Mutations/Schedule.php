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
            'loanTermInMonths' => $args['loanTerm'] * 12,
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
                'monthlyPayment' => round($calculator->monthlyPayment($monthNumber), 2),
                'interestDebtPay' => round($calculator->interestDebtPayment($monthNumber), 2),
                'principalDebtPay' => round($calculator->principalDebtPayment($monthNumber), 2),
                'monthlyLoanAmount' => round($calculator->monthlyLoanAmount($monthNumber), 2),
            ];
        }

        return $loanPayments;
    }

}
