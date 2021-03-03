<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RateDiscount extends Model
{

    use HasFactory;

    /**
     * Mortgage offers for rate discount
     *
     * @return BelongsToMany
     */
    public function mortgageOffers(): BelongsToMany
    {
        return $this->belongsToMany(
            MortgageOffer::class,
            'mortgage_offer_rate_discount',
            'rate_discount_id',
            'mortgage_offer_id');
    }

}
