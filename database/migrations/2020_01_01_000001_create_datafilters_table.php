<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDatafiltersTable extends Migration
{
    public function up()
    {
        Schema::create(config('nova-dashboard-manager.tables.filters'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('filterable_id');
            $table->string('filterable_type');
            $table->schemalessAttributes('extra_attributes');
            $table->integer('sort_order')->default('0');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('nova-dashboard-manager.tables.filters'));
    }
}
