<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgageOfferLoanPurposePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgage_offer_loan_purpose', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mortgage_offer_id');
            $table->foreign('mortgage_offer_id')
                ->references('id')
                ->on('mortgage_offers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('loan_purpose_id');
            $table->foreign('loan_purpose_id')
                ->references('id')
                ->on('loan_purposes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['mortgage_offer_id', 'loan_purpose_id'], 'unique_index_offer_purpose');
            $table->unsignedDecimal('base_rate', $totalDigits = 5, $decimalDigits = 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mortgage_offer_loan_purpose');
    }
}
