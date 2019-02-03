<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->date('date')->comment('日付');
            $table->integer('total_sales')->comment('総売上げ')->nullable();
            $table->integer('net_sales')->comment('純利益')->nullable();
            $table->integer('remained_cash')->comment('残現金')->nullable();
            $table->integer('cash_sales')->comment('現金売上げ')->nullable();
            $table->integer('credit_sales')->comment('クレジット売上げ')->nullable();
            $table->integer('net_credit_sales')->comment('クレジット純売上げ(手数料差引分)')->nullable();
            $table->boolean('no_guest_flg')->comment('ノーゲストフラグ')->default(0);
            $table->string('01_staff', 255)->comment('スタッフ_01');
            $table->integer('01_total_pay')->comment('スタッフ_01 | 総支払額')->nullable();
            $table->float('01_reg_hours')->comment('スタッフ_01 | 通常時給時間')->nullable();
            $table->float('01_accom_hours')->comment('スタッフ_01 | 同伴時給時間')->nullable();
            $table->integer('01_drink_no')->comment('スタッフ_01 | ドリンクバック数')->nullable();
            $table->integer('01_bottle_pay')->comment('スタッフ_01 | ボトルバック給')->nullable();
            $table->integer('01_bonus_pay')->comment('スタッフ_01 | ボーナス給')->nullable();
            $table->string('01_memo', 255)->comment('スタッフ_01 | 連絡事項')->nullable();
            $table->string('02_staff', 255)->comment('スタッフ_02')->nullable();
            $table->integer('02_total_pay')->comment('スタッフ_02 | 総支払額')->nullable();
            $table->float('02_reg_hours')->comment('スタッフ_02 | 通常時給時間')->nullable();
            $table->float('02_accom_hours')->comment('スタッフ_02 | 同伴時給時間')->nullable();
            $table->integer('02_drink_no')->comment('スタッフ_02 | ドリンクバック数')->nullable();
            $table->integer('02_bottle_pay')->comment('スタッフ_02 | ボトルバック給')->nullable();
            $table->integer('02_bonus_pay')->comment('スタッフ_02 | ボーナス給')->nullable();
            $table->string('02_memo', 255)->comment('スタッフ_02 | 連絡事項')->nullable();
            $table->string('03_staff', 255)->comment('スタッフ_03')->nullable();
            $table->integer('03_total_pay')->comment('スタッフ_03 | 総支払額')->nullable();
            $table->float('03_reg_hours')->comment('スタッフ_03 | 通常時給時間')->nullable();
            $table->float('03_accom_hours')->comment('スタッフ_03 | 同伴時給時間')->nullable();
            $table->integer('03_drink_no')->comment('スタッフ_03 | ドリンクバック数')->nullable();
            $table->integer('03_bottle_pay')->comment('スタッフ_03 | ボトルバック給')->nullable();
            $table->integer('03_bonus_pay')->comment('スタッフ_03 | ボーナス給')->nullable();
            $table->string('03_memo', 255)->comment('スタッフ_03 | 連絡事項')->nullable();
            $table->string('04_staff', 255)->comment('スタッフ_04')->nullable();
            $table->integer('04_total_pay')->comment('スタッフ_04 | 総支払額')->nullable();
            $table->float('04_reg_hours')->comment('スタッフ_04 | 通常時給時間')->nullable();
            $table->float('04_accom_hours')->comment('スタッフ_04 | 同伴時給時間')->nullable();
            $table->integer('04_drink_no')->comment('スタッフ_04 | ドリンクバック数')->nullable();
            $table->integer('04_bottle_pay')->comment('スタッフ_04 | ボトルバック給')->nullable();
            $table->integer('04_bonus_pay')->comment('スタッフ_04 | ボーナス給')->nullable();
            $table->string('04_memo', 255)->comment('スタッフ_04 | 連絡事項')->nullable();
            $table->string('05_staff', 255)->comment('スタッフ_05')->nullable();
            $table->integer('05_total_pay')->comment('スタッフ_05 | 総支払額')->nullable();
            $table->float('05_reg_hours')->comment('スタッフ_05 | 通常時給時間')->nullable();
            $table->float('05_accom_hours')->comment('スタッフ_05 | 同伴時給時間')->nullable();
            $table->integer('05_drink_no')->comment('スタッフ_05 | ドリンクバック数')->nullable();
            $table->integer('05_bottle_pay')->comment('スタッフ_05 | ボトルバック給')->nullable();
            $table->integer('05_bonus_pay')->comment('スタッフ_05 | ボーナス給')->nullable();
            $table->string('05_memo', 255)->comment('スタッフ_05 | 連絡事項')->nullable();
            $table->string('01_expense', 255)->comment('経費_01 | 経費項目')->nullable();
            $table->integer('01_expense_pay')->comment('経費_01 | 支払額')->nullable();
            $table->string('01_expense_memo', 255)->comment('経費_01 | 連絡事項')->nullable();
            $table->string('02_expense', 255)->comment('経費_02 | 経費項目')->nullable();
            $table->integer('02_expense_pay')->comment('経費_02 | 支払額')->nullable();
            $table->string('02_expense_memo', 255)->comment('経費_02 | 連絡事項')->nullable();
            $table->string('03_expense', 255)->comment('経費_03 | 経費項目')->nullable();
            $table->integer('03_expense_pay')->comment('経費_03 | 支払額')->nullable();
            $table->string('03_expense_memo', 255)->comment('経費_03 | 連絡事項')->nullable();
            $table->string('04_expense', 255)->comment('経費_04 | 経費項目')->nullable();
            $table->integer('04_expense_pay')->comment('経費_04 | 支払額')->nullable();
            $table->string('04_expense_memo', 255)->comment('経費_04 | 連絡事項')->nullable();
            $table->string('05_expense', 255)->comment('経費_05 | 経費項目')->nullable();
            $table->integer('05_expense_pay')->comment('経費_05 | 支払額')->nullable();
            $table->string('05_expense_memo', 255)->comment('経費_05 | 連絡事項')->nullable();
            $table->boolean('delete_flg')->comment('削除フラグ')->default(0);
            $table->timestamp('created_at')->comment('登録日時')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->comment('更新日時')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->comment('削除日時')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
