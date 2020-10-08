<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDatawidgetsTable extends Migration
{

    public function up()
    {
        Schema::create(config('nova-dashboard-manager.tables.widgets'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('metricable_id');
            $table->string('metricable_type');
            $table->schemalessAttributes('extra_attributes');
            $table->integer('sort_order')->default('0');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('nova-dashboard-manager.tables.widgets'));
    }

}
