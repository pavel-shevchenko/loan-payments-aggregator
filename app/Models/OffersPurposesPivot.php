<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OffersPurposesPivot extends Pivot
{

    protected $table = 'mortgage_offer_loan_purpose';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'base_rate' => 'float',
    ];

}
