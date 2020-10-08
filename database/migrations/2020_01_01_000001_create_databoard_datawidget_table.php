<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;


class CreateDataboardDatawidgetTable extends Migration {

	public function up()
	{
		Schema::create($this->tableName(), function(Blueprint $table) {
			$table->increments('id');
			$table->integer('dashboard_id')->unsigned();
			$table->integer('datawidget_id')->unsigned();
			$table->integer('sort_order')->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop($this->tableName());
	}

    public function tableName()
    {
        return Str::singular(config('nova-dashboard-manager.tables.dashboards')) . '_' . Str::singular(config('nova-dashboard-manager.tables.widgets'));
    }
}
