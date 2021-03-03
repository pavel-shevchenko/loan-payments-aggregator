<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgageOfferRateDiscountPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgage_offer_rate_discount', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mortgage_offer_id');
            $table->foreign('mortgage_offer_id')
                ->references('id')
                ->on('mortgage_offers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('rate_discount_id');
            $table->foreign('rate_discount_id')
                ->references('id')
                ->on('rate_discounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['mortgage_offer_id', 'rate_discount_id'], 'unique_index_offer_discount');
            $table->unsignedDecimal('reduction_value', $totalDigits = 5, $decimalDigits = 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mortgage_offer_rate_discount');
    }
}
