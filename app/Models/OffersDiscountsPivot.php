<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OffersDiscountsPivot extends Pivot
{

    protected $table = 'mortgage_offer_rate_discount';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reduction_value' => 'float',
    ];

}
