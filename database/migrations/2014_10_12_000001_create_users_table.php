<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('npk')->unique()->nullable();
            $table->string('name');
            $table->string('foto_karyawan')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->date('tgl_join')->nullable();
            $table->enum('status_nikah',['menikah','jomblo'])->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('lokasi_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('id_role')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
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
