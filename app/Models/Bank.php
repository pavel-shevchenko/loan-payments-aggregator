<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{

    use HasFactory;

    /**
     * Bank offers for mortgages
     *
     * @return HasMany
     */
    public function mortgageOffers(): HasMany
    {
        return $this->hasMany(MortgageOffer::class, 'bank_id', 'id');
    }

}
