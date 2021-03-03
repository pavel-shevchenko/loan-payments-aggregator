<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LoanPurpose extends Model
{

    use HasFactory;

    /**
     * Mortgage offers for loan purpose
     *
     * @return BelongsToMany
     */
    public function mortgageOffers(): BelongsToMany
    {
        return $this->belongsToMany(
            MortgageOffer::class,
            'mortgage_offer_loan_purpose',
            'loan_purpose_id',
            'mortgage_offer_id');
    }

}
