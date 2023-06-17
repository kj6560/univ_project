<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->float('height');
            $table->date('date_of_birth');
            $table->float('age');
            $table->string('photo');
            $table->longText('bio');
            $table->string('sports_interested_in');
            $table->string('academy_experience');
            $table->string('address');
            $table->string('contact');
            $table->string('certificate');
            $table->float('weight');
            $table->float('bmi');
            $table->string('video');
            $table->string('user_id');
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
        Schema::dropIfExists('profiles');
    }
}
