@extends('admin.header')

@section('title', 'Заявки')
@section('content')
<div class="df fdr_r g2 pos_f bg_w"><a class="lh_3 fsz_1_5 td_n" href="{{route('courses_admin')}}">Курсы</a><a class="lh_3 fsz_1_5 td_n" href="{{route('course_applications')}}">Заявки</a></div>
<div class="w100 h4"></div>
<span class="c_gr f_mr fsz_1">Заявок: {{$count}}</span>
@if (count($appls)>0)
    <table class="table mt_4">
        <thead>
            <tr class="fsz_1 h3">
                <td>Название курса</td>
                <td>Заявка на:</td>
                <td>Дата отправки</td>
                <td>Действия</td>
                <!-- <td>Действия</td> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($appls as $appl)
            <?php
                $for = $appl->wish_access == '1' ? 'Вывод' : 'Сокрытие';
                $name_act = $appl->wish_access == '1' ? 'Выводить' : 'Скрыть';
                $btn_c = $appl->wish_access == '1' ? 'btn_green' : 'btn_red';
            ?>
            <tr class="h3 ff_mr fsz_1">
                <td>{{$appl->course}}</td>
                <td>{{$for}}</td>
                <td>{{$appl->created_at}}</td>
                <td class="df fdr_r g1">
                    <a class="td_n paa_0_3 br_03 {{$btn_c}}" href="{{route('set_access', ['id_course'=>$appl->id_course, 'id_appl'=>$appl->id, 'wish'=>$appl->wish_access, 'act'=>'Принята'])}}">{{$name_act}}</a>
                    <a class="td_n paa_0_3 br_03 bg_lgr c_b" href="{{route('set_access', ['id_course'=>$appl->id_course, 'id_appl'=>$appl->id, 'wish'=>$appl->wish_access, 'act'=>'Отклонена'])}}">Отклонить</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    
    <div class="fsz_1">Пока нет ни одной заявки.</div>
    
@endif
@endsection