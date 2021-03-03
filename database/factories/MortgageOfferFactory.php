<?php

namespace Database\Factories;

use App\Models\MortgageOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

class MortgageOfferFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MortgageOffer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'cost_min' => random_int(300, 500) * 1000,
            'cost_step' => random_int(30, 50) * 1000,
            'cost_max' => random_int(3000, 5000) * 1000,
            'init_loan_min' => random_int(100, 300) * 1000,
            'init_loan_step' => random_int(10, 30) * 1000,
            'term_min' => random_int(5, 15),
            'term_max' => random_int(25, 50),
        ];
    }

}
