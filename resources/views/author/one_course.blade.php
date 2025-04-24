@extends('author.header')

@section('title', "Подробнее '".$course->title."'")
@section('content')

<?php
        $image = 'img/courses/';
        if($course->image){
            $image.=$course->image;
        }
        else{
            $image.= 'default.png';
        }
    ?>

    <div class=" w74 h4"></div>
    <div class="w74 df fdr_r jc_spb ">
        <div class="df fdr_c  g1_5">
            <h2 class="fsz_2_3 ff_ml c_dp">{{$course->title}}</h2>
            <span class="paa_0_5 bg_lp w_au br_03 ff_mr c_w fsz_0_8">{{$course->category}}</span>
            <span class="fsz_1 ff_mr c_dp">{{$course->description}}</span>
            <span class="fsz_1 ff_mr c_dp">Учащихся: {{$course->student_count}}</span>
        </div>
        <div class="w18">
            <img class="paa_1 w14" src="{{asset($image)}}" alt="">
        </div>
    </div>
    
    <div class="df fdr_c g1">
        <span class="fsz_1_7 ff_m c_dp">Уроки</span>
        <a class="ff_mr fsz_1 btn_dp_lp w_au paa_0_5 br_03 td_n" href="{{route('create_lesson_show', $course->id)}}">Добавить урок</a>

        @if ($count_lessons == 0)
            <span class="fsz_1 ff_mr">Нет уроков</span>
        @else
        <ul class="df fdr_c g0_5 ff_mr fsz_1">
            @foreach ($lessons as $lesson)
                <li class="df fdr_r jc_spb w48">
                    <span>{{$lesson->title}}</span> <div class="df fdr_r g1"><a class="paa_0_5 fs_1 ff_mr btn_lp_dp td_n br_03" href="{{route('one_lesson', $lesson->id)}}">Смотреть</a> <a class="paa_0_5 fs_1 ff_mr btn_lp_dp td_n br_03" href="{{route('remove_lesson', ['id_less'=>$lesson->id, 'id_course'=>$course->id])}}">Удалить</a></div>
                </li>
            @endforeach
        </ul>
        @endif
    </div>

    
@endsection