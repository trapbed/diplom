@extends('header')

@section('title', $title)
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
    <div class="df fdr_c g2">
        <div class="w74 df fdr_r jc_spb ">
            <div class="df fdr_c  g1_5">
                <h2 class="fsz_2_3 ff_ml c_dp">{{$course->title}}</h2>
                <span class="paa_0_3 ff_ml c_w fsz_0_8 bg_dp br_03 w_au">{{$course->category}}</span>
                <span class="fsz_1 ff_mr c_dp">{{$course->description}}</span>
                <span class="fsz_1 ff_mr c_dp">Учащихся: {{$course->student_count}}</span>
                @if($complete != false)
                    <div class="ff_mr fsz_0_8 bg_lg w_au paa_0_5 c_dg br_03">Завершен</div>
                @endif
                @if($has == false)
                    <a class="ff_mr btn_purple w8_5 td_n brc_lp fsz_1 c_dp" href="{{route('start_study', ['id_course'=>$course->id])}}">Начать изучать</a>
                @endif
            </div>
            <div class="w18">
                <img class="paa_1 w18" src="{{asset($image)}}" alt="">
            </div>
        </div>

        <div class="df fdr_c g3 ff_mr fsz_1 c_dp ptb_2">
            @if($lessons)
                <span class="ff_m fsz_2">Уроки</span>
                <div class="df fdr_c g1">
                    @foreach ($lessons as $lesson)
                        {{--$lesson->id--}}
                        <a href="{{route('one_lesson_student', ['id'=>$lesson->id, 'course'=>$course->id])}}" class="td_n btn_w_lp w69 paa_1 h1 fsz_1 br_03 brc_lp">{{$lesson->title}}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    
@endsection