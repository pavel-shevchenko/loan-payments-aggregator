<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MortgageOffer extends Model
{

    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cost_min' => 'integer',
        'cost_step' => 'integer',
        'cost_max' => 'integer',
        'init_loan_min' => 'integer',
        'init_loan_step' => 'integer',
        'term_min' => 'integer',
        'term_max' => 'integer',
        //'rateDiscounts.pivot.reduction_value' => 'float',
        //'loanPurposes.pivot.base_rate' => 'float'
    ];

    /**
     * Mortgage offer's bank
     *
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    /**
     * Rate discounts for mortgage offer
     * @return BelongsToMany
     */
    public function rateDiscounts(): BelongsToMany
    {
        return $this->belongsToMany(
            RateDiscount::class,
            'mortgage_offer_rate_discount',
            'mortgage_offer_id',
            'rate_discount_id'
        )->using(OffersDiscountsPivot::class)
            ->as('discountDetails')
            ->withPivot('reduction_value');
    }

    /**
     * Loan purposes for mortgage offer
     * @return BelongsToMany
     */
    public function loanPurposes(): BelongsToMany
    {
        return $this->belongsToMany(
            LoanPurpose::class,
            'mortgage_offer_loan_purpose',
            'mortgage_offer_id',
            'loan_purpose_id'
        )->using(OffersPurposesPivot::class)
            ->as('purposeDetails')
            ->withPivot('base_rate');
    }

}
