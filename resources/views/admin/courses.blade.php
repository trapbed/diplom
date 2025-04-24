@extends('admin/header')

@section('title', 'Курсы')
@section('content')

<div class="df fdr_r g2 pos_f bg_w"><a class="lh_3 fsz_1_5 td_n" href="{{route('courses_admin')}}">Курсы</a><a class="lh_3 fsz_1_5 td_n" href="{{route('course_applications')}}">Заявки</a></div>


@if (count($courses)>0)
    <table class="table mt_4">
        <thead>
            <tr class="fsz_1">
                <td>Название</td>
                <td>Категория</td>
                <td>Описание</td>
                <td>Автор</td>
                <td>Дата создания</td>
                <td>Доступ</td>
                <!-- <td>Действия</td> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <?php
                // dd($course->test);
                $test = $course->test != null ? "&#10003;" : "";
                $btn_access_title = $course->access == '0' ? 'Выводить' : 'Скрыть';
                $access = $course->access == '0' ? '1' : '0';
                $color_btn = $course->access == '0' ? 'bg_lg' : 'bg_lr';
                $bg_color_btn = $course->access == '0' ? 'c_dg' : 'c_dr';
            ?>
                <tr class=" fsz_1 h3 f_w300 ff_mr">
                  <td>{{$course->course_title}}</td>
                  <td>{{$course->category_title}}</td>
                  <td onclick=""  title="{{$course->description}}">Смотреть</td>
                  <td>{{$course->author}}</td>
                  <td>{{$course->created_at}}</td>
                  <td><a class="fsz_0_8 br_03 ff_mr {{$color_btn}} {{$bg_color_btn}} td_n paa_0_3" href="{{route('change_access_course',['access'=> $access, 'id_course'=>$course->course_id])}}">{{$btn_access_title}}</a></td>
                  <!-- <td class="df fdr_r g1 ali_c b_0 h3 "><button class="fsz_1 ff_mr">Редактировать</button></td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    
    <div class="fsz_1">Пока нет ни одного курса.</div>
    
@endif

@endsection