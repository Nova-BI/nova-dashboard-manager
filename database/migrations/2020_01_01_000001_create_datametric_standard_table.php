<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;


class CreateDatametricStandardTable extends Migration {

	public function up()
	{
		Schema::create($this->tableName(), function(Blueprint $table) {
			$table->increments('id');
            $table->integer('visualable_id');
            $table->string('visualable_type');
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
        return Str::singular(config('nova-dashboard-manager.tables.metrics')) . '_standard';
    }
}
