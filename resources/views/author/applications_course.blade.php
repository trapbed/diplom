@extends('author.header')

@section('title', 'Заявки')
@section('content')
<h4 class="ff_ml fsz_1_5 c_dp h3">Автор/ Мои заявки</h4>
<div class="df fdr_c g3 w78 c_dp">
        <div class="df fdr_r g4 ff_m fsz_1">
            <div class="w12">Название курса</div>
            <div class="w8">Запрос на:</div>
            <div class="w10">Дата отправки</div>
            <div class="w12">Дата обработки</div>
            <div class="w12">Статус</div>
        </div>
        <div class="df fdr_c g1">
            @foreach ($appls as $appl)
                <div class="df fdr_r g4 ff_mr fsz_1">
                    <?php
                        $wish_btn = $appl->wish_access == '1' ? 'Вывод' : 'Сокрытие';
                        $updated_at = $appl->updated_at == null || $appl->status == 'Отправлена' ? '-' : $appl->updated_at;
                        
                    ?>
                    <div class="w12">{{$appl->course_title}}</div>
                    <div class="w8">{{$wish_btn}}</div>
                    <div class="w10">{{$appl->created_at}}</div>
                    <div class="w12">{{$updated_at}}</div>
                    <?php
                        switch($appl->status){
                            case 'Отправлена':
                                $bg_color = 'bg_lgr';
                                $color = 'c_b';
                                break;
                            case 'Принята':
                                $bg_color = 'bg_lg';
                                $color = 'c_dg';
                                break;
                            case 'Отклонена':
                                $bg_color = 'bg_lr';
                                $color = 'c_red';
                                break;
                        }
                    ?>
                    <div class=" paa_0_3 br_03 fsz_0_8 df fdr_r ali_c jc_c {{ $bg_color }} {{ $color }}">{{$appl->status}}</div>
                </div>
            @endforeach
        </div>
</div>
@endsection