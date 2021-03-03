<?php

namespace Database\Seeders;

use App\Models\MortgageOffer;
use Illuminate\Database\Seeder;
use App\Models\Bank;
use App\Models\RateDiscount;
use App\Models\LoanPurpose;

class MortgageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($banksCount = 2)
    {
        $banks = Bank::factory($banksCount)->create();
        $discountBankCard = RateDiscount::firstOrCreate(['title' => 'Have bank card']);
        $discountEarningsProof = RateDiscount::firstOrCreate(['title' => 'Have proof of earnings']);
        $purposeFinishedHome = LoanPurpose::firstOrCreate(['title' => 'Finished home']);
        $purposeNewBuilding = LoanPurpose::firstOrCreate(['title' => 'New building']);
        $purposeUnderConstruct = LoanPurpose::firstOrCreate(['title' => 'House under construction']);

        // create two mortgage offers for each of the banks
        for ($index = 0; $index < $banksCount * 2; $index++) {
            MortgageOffer::factory()
                // establish a relationship with each of the banks twice in a row
                ->for($banks->get($index / 2 % $banksCount))
                ->hasAttached(
                    $discountBankCard,
                    ['reduction_value' => 0.3]
                )
                ->hasAttached(
                    $discountEarningsProof,
                    ['reduction_value' => 0.2]
                )
                ->hasAttached(
                    $purposeFinishedHome,
                    ['base_rate' => 8.5]
                )
                ->hasAttached(
                    collect([$purposeNewBuilding, $purposeUnderConstruct])->random(),
                    ['base_rate' => 7]
                )
                // apply one of two types of loan payments in turn
                ->create(['type' => config('app.loan_payment_types')[$index % 2]]);
        }
    }

}
