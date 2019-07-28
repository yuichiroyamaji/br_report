<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->comment('日付');
            $table->string('01_staff', 20)->comment('スタッフ_01')->nullable();
            $table->string('02_staff', 20)->comment('スタッフ_02')->nullable();
            $table->string('03_staff', 20)->comment('スタッフ_03')->nullable();
            $table->string('04_staff', 20)->comment('スタッフ_04')->nullable();
            $table->string('05_staff', 20)->comment('スタッフ_05')->nullable();
            $table->string('event', 255)->comment('イベント')->nullable();
            $table->boolean('dayoff_flg')->comment('休みフラグ')->default(0);
            $table->boolean('delete_flg')->comment('削除フラグ')->default(0);
            $table->timestamp('deleted_at')->comment('削除日時')->nullable();
            // timestamps()でcreated_atとupdated_atが作成される
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
        Schema::dropIfExists('shifts');
    }
}
