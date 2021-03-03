<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgageOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgage_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('banks');
            $table->set('type', config('app.loan_payment_types'));
            $table->integer('cost_min');
            $table->integer('cost_step');
            $table->integer('cost_max');
            $table->integer('init_loan_min');
            $table->integer('init_loan_step');
            $table->integer('term_min');
            $table->integer('term_step')->nullable();
            $table->integer('term_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mortgage_offers');
    }
}
