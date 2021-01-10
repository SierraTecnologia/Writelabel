<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWriteLabelEventsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'writelabel_events', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('event', 255)->nullable();
                $table->integer('user_id')->nullable();
                $table->integer('position')->nullable();
                $table->integer('value')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('writelabel_events');
    }
}
