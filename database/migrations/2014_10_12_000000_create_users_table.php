<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100)
                ->nullable(false);

            $table->string('login', 30)
                ->nullable(false);

            $table->string('email', 40)
                ->unique()
                ->nullable(false);

            $table->timestamp('email_verified_at')
                ->nullable();

            $table->string('password')
                ->nullable(false);

            $table->boolean('subscriber')
                ->default(0);
                
            $table->float('cash', 8, 2);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
