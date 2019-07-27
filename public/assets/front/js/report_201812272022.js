$(function(){

    //****************************お知らせ****************************
    var note = '';
    note = note + ' 【お知らせ】\n\n';
    note = note + '　スタッフに「ことみ」と「ロキ」\n';
    note = note + '　が追加されました';
    //alert(note);
    // var dates = '<?php $dates ?>';
    var dates = 'jafhda';
    alert(dates);

    //****************************共通関数****************************

    //スクリーン幅の表示
    // $('body').append('<p id=value>ブラウザの横幅</p>');
    // $('#value').css({
    //                 position:'fixed',
    //                 right:'20px',
    //                 bottom:'20px',
    //                 fontSize: '150%',
    //             });
    // var windowWidth = $(window).width();
    // $('#value').text(windowWidth);

    // $(window).resize(function(){
    //     var windowWidth = $(window).width();
    //     $('#value').text(windowWidth);
    // });

    //カウントアップアニメーション
    // function countUpAnimation(class_name, max_cnt, rate){
    //     if(max_cnt <= 0){
    //         class_name.text(0);
    //         return;
    //     }
    //     var start_cnt = max_cnt * rate;
    //     countTimer = setInterval(function(){
    //         var next_cnt = start_cnt++;
    //         class_name.text(next_cnt);
    //         if(next_cnt == max_cnt){
    //             clearInterval(countTimer);
    //         }
    //     },1);
    // }

    //金額変更時のハイライトアニメーション
    function flashAnimation(target_class){
        // var original_color = $(target_class).css('background-color');
        $(target_class).animate({
            'backgroundColor': 'yellow'
        }, 50);
        $(target_class).animate({
            // 'backgroundColor': original_color
            'backgroundColor': '#eee'
        }, 1000);

    }

    //フォームサブミット時の確認ダイアログ
    $('form').submit(function(){
        var sales = $('input[name=total_sales]').val(),
            credit = $('input[name=credit_sales]').val(),
            remained = $('input[name=remained_cash]').val(),
            expense_val = 0,
            expense = 0;
        $('.expense_pay').each(function(){
            expense_val = !$(this).val() ? 0 : parseInt($(this).val());
            expense = expense + expense_val;
        });
            msg = '-------------------------\n';
        msg = msg + '以下の内容で送信します。\nよろしいですか？\n';
        msg = msg + '-------------------------\n';
        msg = msg + '売上げ： ￥' + sales + '\n';
        if(credit != 0){msg = msg + 'クレジット： - ￥' + credit + '\n'};
        $('.total_pay').each(function(){
            var ids = $(this).attr('id'),
                num = ids.substr(0,2),
                name = num +'_staff';
                staff = $('[name=' + name + ']').val(),
                target = num + '_total_pay',
                pay = $('input[name=' + target + ']').val();
            msg = msg + '[' + staff + ']' + ' 給料： - ￥' + pay + '\n';
        });
        if(expense != 0){msg = msg + '経費： - ￥' + expense + '\n';}
        msg = msg + '-------------------------\n';
        msg = msg + '残金： ￥' + remained + ' 在中';
        if(!confirm(msg)){return false;}
    });

    //数字入力制御
    $(document).on('change focusout', 'input[type=number]', function(){
        if(!$.isNumeric($(this).val())){$(this).val('');}
    });


    //****************************トップ固定****************************

    //********関数********

    //残金の計算
    function calcRemainedCash(){
        var sum = 0;
        var val = 0;
        $('.plus').each(function(){
            val = !$(this).val() ? 0 : parseInt($(this).val());
            sum = sum + val;
        });
        $('.minus').each(function(){
            val = !$(this).val() ? 0 : parseInt($(this).val());
            sum = sum - val;
        });
        $('.remained_cash').text(sum);
        $('input[name=remained_cash]').val(sum);
        flashAnimation('.remained_cash');
        // countUpAnimation($('.remained_cash'), sum, 0.995);
    }

    //********処理********

    //残金計算対象要素変更イベント
    $(document).on('change', '.count', function(){
        calcRemainedCash();
        $(this).blur();
    });

    //日付入力欄、幅の調整
    $('.resize').each(function(){
        var name = $(this).attr('id');
        $("#width_tmp_option").html($('#' + name + ' option:selected').text());
        $(this).width($("#width_tmp_select").width());
    });
    $('.resize').change(function(){
        var name = $(this).attr('id');
        $("#width_tmp_option").html($('#' + name + ' option:selected').text());
        $(this).width($("#width_tmp_select").width());
    });

    //****************************売上げ****************************

    //********処理********

    //今日の売上げ計算
    $(document).on('change', '.sales', function(){
        var sum = 0,
            val = '';
        $('.sales').each(function(){
            val = !$(this).val() ? 0 : parseInt($(this).val());
            sum = sum + val;
        });
        $('input[name=total_sales]').val(sum);
        $('.total_sales').text(sum);
        flashAnimation('.total_sales');
        $(this).blur();
    });



    //****************************スタッフ給与****************************

    //********関数********

    //総給与額計算
    function calcStaffTotalPay(num, calc_remain){
        var cnt_class = '.' + num + '_staff_cnt',
            chng_class = 'input[name=' + num + '_total_pay]',
            chng_id = '#' + num + '_total_pay',
            sum = 0,
            val ='';
        $(cnt_class).each(function(){
            if($(this).hasClass('val_form')){
                val = !$(this).val() ? 0 : parseInt($(this).val());
            }else{
                val = !$(this).text() ? 0 : parseInt($(this).text());
            }
            sum = sum + val;
        });
        $(chng_class).val(sum);
        $(chng_id).text(sum);
        flashAnimation(chng_id);
        // var send_value = $(chng_class).val();
        // alert(send_value);
        if(calc_remain){calcRemainedCash();}
    }

    //********処理********

    //ノーゲストフラグ
    $(document).on('change', 'input[name=no_guest_flg]', function(){
        var state = $('input[name=no_guest_flg]').prop('checked'),
            target_class = '.reg_hours_rate',
            rate = state ? 900 : 1200,
            value = state ? 1 : 0,
            val = 0,
            sum = 0;
        $(this).val(value);
        $(target_class).text(rate);
        flashAnimation(target_class);
        $('.reg_hours').each(function(){
            var name = $(this).attr('name'),
                num = name.substr(0,2),
                hours = !$(this).val() ? 0 : parseInt($(this).val()),
                target = '#' + num + '_reg_hours_pay',
                pay = hours * rate;
            $(target).text(pay);
            flashAnimation(target);
            calcStaffTotalPay(num, false);
        });
        $('.plus').each(function(){
            val = !$(this).val() ? 0 : parseInt($(this).val());
            sum = sum + val;
        });
        $('.minus').each(function(){
            val = !$(this).val() ? 0 : parseInt($(this).val());
            sum = sum - val;
        });
        $('.remained_cash').text(sum);
        flashAnimation('.remained_cash');
        // countUpAnimation($('.remained_cash'), sum, 0.995);
    });
    //通常勤務時間
    $(document).on('change', '.reg_hours', function(){
        var name = $(this).attr('name'),
            cat = name.substr(3,3),
            num = name.substr(0,2),
            hours = $(this).val(),
            rate = $('.reg_hours_rate:first').text(),
            target = '#' + num + '_reg_hours_pay',
            pay = hours * rate;
        $(target).text(pay);
        flashAnimation(target);
        calcStaffTotalPay(num, true);
        $(this).blur();
    });
    //同伴勤務時間
    $(document).on('change', '.accom_hours', function(){
        var name = $(this).attr('name'),
            cat = name.substr(3,3),
            num = name.substr(0,2),
            hours = $(this).val(),
            rate = $('.accom_hours_rate:first').text(),
            target = '#' + num + '_accom_hours_pay',
            pay = hours * rate;
        $(target).text(pay);
        flashAnimation(target);
        calcStaffTotalPay(num, true);
        $(this).blur();
    });
    //ドリンクバック
    $(document).on('change', '.drink_no', function(){
        var name = $(this).attr('name'),
            cat = name.substr(3,3),
            num = name.substr(0,2),
            hours = $(this).val(),
            rate = $('.drink_rate:first').text(),
            target = '#' + num + '_drink_pay',
            pay = hours * rate;
        $(target).text(pay);
        flashAnimation(target);
        calcStaffTotalPay(num, true);
        $(this).blur();
    });
    //ボトルバック
    $(document).on('change', '.bottle_pay', function(){
        var name = $(this).attr('name'),
            cat = name.substr(3,3),
            num = name.substr(0,2),
            pay = parseInt($(this).val());
        calcStaffTotalPay(num, true);
        $(this).blur();
    });
    //ボーナス
    $(document).on('change', '.bonus_pay', function(){
        var name = $(this).attr('name'),
            cat = name.substr(3,3),
            num = name.substr(0,2),
            pay = parseInt($(this).val());
        calcStaffTotalPay(num, true);
        $(this).blur();
    });
    //「スタッフを追加」ボタン
    $('#add_staff').click(function(){
        var cnt = $('.staff').length,
            next_cnt = parseInt(cnt) + 1,
            num = '0' + next_cnt, //10人以上というケースはないため考慮しない
            contents = '',
            target_section = '.' + num + '_staff_section',
            reg_hours_rate = $('.reg_hours_rate:first').text(),
        contents = contents + '<div class="md_sec_title staff"><p class="float left">スタッフ_' + num + '</p>';
        contents = contents + '<p class="float right"><select class="select_height" name="' + num + '_staff">';
        contents = contents + '<option>美咲</option><option>イリヤ</option><option>カナ</option><option>柘榴</option><option>カーマ</option><option>ののか</option><option>ことみ</option><option>ヒメ</option><option>弓月</option><option>ロキ</option>';
        contents = contents + '</select></p></div>';
        contents = contents + '<p class="sm_sec_title">総給与額</p>';
        contents = contents + '<p class="form_input">';
        contents = contents + '<span id="' + num + '_total_pay" class="total_pay">0</span>&nbsp円';
        contents = contents + '<input type="hidden" name="' + num + '_total_pay" class="count minus" value="0">';
        contents = contents + '</p>';
        contents = contents + '<p class="sm_sec_title">通常勤務時間</p>';
        contents = contents + '<p class="form_input"><input type="number" class="time reg_hours" name="' + num + '_reg_hours" step="0.5" value="">&nbsp時間';
        contents = contents + 'x <span class="reg_hours_rate">' + reg_hours_rate + '</span>円/時間 = <span id="' + num + '_reg_hours_pay" class="' + num + '_staff_cnt subtotal">0</span>&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">同伴勤務時間</p>';
        contents = contents + '<p class="form_input"><input type="number" class="time accom_hours" name="' + num + '_accom_hours" step="0.5" value="">&nbsp時間';
        contents = contents + 'x <span class="accom_hours_rate">1600</span>円/時間 = <span id="' + num + '_accom_hours_pay" class="' + num + '_staff_cnt subtotal">0</span>&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">ドリンクバック</p>';
        contents = contents + '<p class="form_input"><input type="number" class="time drink_no" name="' + num + '_drink_no" step="1" value="">&nbsp杯';
        contents = contents + 'x <span class="drink_rate">500</span>円/杯 = <span id="' + num + '_drink_pay" class="' + num + '_staff_cnt subtotal">0</span>&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">ボトルバック</p>';
        contents = contents + '<p class="form_input"><input type="number" id="' + num + '_bottle_pay" class="money ' + num + '_staff_cnt bottle_pay val_form" name="' + num + '_bottle_pay" step="10" value="">&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">ボーナス</p>';
        contents = contents + '<p class="form_input"><input type="number" id="' + num + '_bonus_pay" class="money ' + num + '_staff_cnt bonus_pay val_form" name="' + num + '_bonus_pay" step="10" value="">&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">メモ</p>';
        contents = contents + '<p class="form_input"><textarea name="' + num + '_memo"></textarea></p>';
        $(target_section).html(contents);
        $(target_section).show();
        if(num == '09'){$(this).hide();}
    });

    //****************************経費****************************

    //********処理********

    //「経費を追加」ボタン
    $('#add_expense').click(function(){
        var cnt = $('.expense').length,
            next_cnt = parseInt(cnt) + 1,
            num = '0' + next_cnt, //10人以上というケースはないため考慮しない
            contents = '',
            target_section = '.' + num + '_expense_section',
        contents = contents + '<div class="md_sec_title expense"><p class="float left">経費_' + num + '</p>';
        contents = contents + '<p class="float right"><select class="select_height" name="' + num + '_expense">';
        contents = contents + '<option>酒屋</option><option>おしぼり</option><option>NAC</option><option>代引き</option><option>雑費</option>';
        contents = contents + '</select></p></div>';
        contents = contents + '<p class="sm_sec_title">支払い額</p>';
        contents = contents + '<p class="form_input"><input type="number" name="' + num + '_expense_pay" class="money count minus expense_pay" value="">&nbsp円</p>';
        contents = contents + '<p class="sm_sec_title">詳細･メモ</p>';
        contents = contents + '<p class="form_input"><textarea name="' + num + '_expense_memo"></textarea></p>';
        $(target_section).html(contents);
        $(target_section).show();
        if(num == '05'){$(this).hide();}
    });
});
