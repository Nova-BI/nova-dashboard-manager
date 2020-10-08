<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;


class CreateDatafilterStandardTable extends Migration {

	public function up()
	{
		Schema::create($this->tableName(), function(Blueprint $table) {
			$table->increments('id');
            $table->schemalessAttributes('extra_attributes');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop($this->tableName());
	}

    public function tableName()
    {
        return Str::singular(config('nova-dashboard-manager.tables.filters')) . '_standard';
    }
}
