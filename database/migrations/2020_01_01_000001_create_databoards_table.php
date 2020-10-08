<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

// todo: rename databoards to dashboards
class CreateDataboardsTable extends Migration {

	public function up()
	{

		Schema::create(config('nova-dashboard-manager.tables.dashboards'), function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->integer('dashboardable_id');
			$table->string('dashboardable_type');
            $table->schemalessAttributes('extra_attributes');
			$table->integer('sort_order')->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop(config('nova-dashboard-manager.tables.dashboards'));
	}
}
