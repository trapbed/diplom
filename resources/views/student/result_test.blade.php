@extends('header')

@section('title', '')
@section('content')
<!-- <div class="w98_8 h6"></div> -->
<div id="result_test">
    <div class="h10 w98_8"></div>
    <div class="df fdr_c g_1 ali_c">
        <span class="ff_m fsz_2 c_dp">Ваша оценка: {{ $grade }}</span>
        <span class="ff_ml fsz_1_2 c_dp">Результат: <span class="ff_m">{{ $percent }}%</span></span>
    </div>
     <div class="w4 h6 fsz_4">
        @switch($grade)

        @case(5)
            &#129321;
            @break
        @case(4)
            &#128521;
            @break
        @case(3)
            &#129303;
            @break
        @case(2)
            &#128532;
            @break
        @endswitch
    </div>
    <span class="ff_m fsz_1_2 c_dp">
        @switch($grade)
            @case(5)
                Умничка! Так держать!
                @break
            @case(4)
                Хорошая работа!
                @break
            @case(3)
                Неплохо, постарайся еще!
                @break
            @case(2)
                Что-то плохо, попробуй еще раз!
                @break
        @endswitch
    </span>
    <div class="h3 w98_8"></div>
    <div class="df fdr_r w84  jc_spb">
        <div class="df fdr_r g0_5 ali_c js_s als_s">
            <a class="paa_0_5  td_n btn_lp_dp ff_mr fsz_1 br_03 " href="{{route('one_lesson_student', ['id'=>$before_id, 'course'=>$course->id])}}">{{$before_title}}</a>
            <span class="ff_mr fsz_0_8 c_lg c_gr">Назад</span>
        </div>

        @if($next_title != null)
            <div>
                <div class="df fdr_r g0_5 ali_c js_e als_e">
                    <span class="ff_mr fsz_0_8 c_lg c_gr">Следующий</span>
                    <a class=" paa_0_5 td_n btn_lp_dp ff_mr fsz_1 br_03 " href="{{route('one_lesson_student', ['id'=>$next_id, 'course'=>$course->id])}}">{{$next_title}}</a>
                </div>
            </div>
        @else
            @if ($completed)
                <div class="paa_0_5 td_n bg_lgr ff_mr fsz_1 br_03 ">Завершен</div>
            @else
                <a href="{{route('complete_course', ['id_course'=>$course->id])}}" onclick="end_test_student(event)" class="paa_0_5 td_n btn_dp_lp ff_mr fsz_1 br_03 ">Завершить</a>
            @endif
            <!-- <a href="{{route('complete_course', ['id_course'=>$course->id])}}" onclick="end_test_student(event)" class="paa_0_5 td_n btn_dp_lp ff_mr fsz_1 br_03 ">Завершить</a> -->
        @endif
    </div>
    
</div>
{{-- dd($before_id,
$next_id,
$course,
$grade,
$percent) --}}
@endsection