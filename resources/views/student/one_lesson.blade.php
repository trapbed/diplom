@extends('header')

@section('title', $lesson->title)
@section('content')

<div class=" w80 h2"></div>
<div class="df fdr_c als_c g3 ptb_2 ali_c">
    <div class="df fdr_c ff_mr g1_5 w50">
        <span class="fsz_1_5 c_dp">Курс: {{$lesson->course}}</span>
        <span class="fsz_1_2 c_dp">Урок: {{$lesson->title}}</span>
    </div>
    <div class="w78 df fdr_c g1 ff_ml fsz_1 ali_c">
        @foreach ($content as $key=>$val)
            @foreach ($val as $k=>$v)
                @if($k == 'img')
                    <img class="w50" src="{{asset('img/lessons/'.$v)}}" alt="image_course">
                
                @elseif($k=='txt')
                    <div class="w50 paa_0_5 brc_lp br_03">{{$v}}</div>
                @endif
                <br>
            @endforeach
        @endforeach
        
    </div>
    <div class="df fdr_r jc_spb w52">
        @if ($before_id != null)
        <div class="df fdr_r g0_5 ali_c js_s als_s">
            <a class="paa_0_5  td_n btn_lp_dp ff_mr fsz_1 br_03 " href="{{route('one_lesson_student', ['id'=>$before_id, 'course'=>$lesson->course_id])}}">{{$before_title}}</a>
            <span class="ff_mr fsz_0_8 c_lg c_gr">Назад</span>
        </div>
        @endif
        <div class="w_a"></div>
        @if ($next_id != null)
        <div class="df fdr_r g0_5 ali_c js_e als_e">
            <span class="ff_mr fsz_0_8 c_lg c_gr">Следующий</span>
            <a class=" paa_0_5 td_n btn_lp_dp ff_mr fsz_1 br_03 " href="{{route('one_lesson_student', ['id'=>$next_id, 'course'=>$lesson->course_id])}}">{{$next_title}}</a>
        </div>
        @else
            @if ($completed)
                <div class="paa_0_5 td_n bg_lgr ff_mr fsz_1 br_03 ">Завершен</div>
            @else
                <a href="{{route('complete_course', ['id_course'=>$lesson->course_id])}}" class="paa_0_5 td_n btn_dp_lp ff_mr fsz_1 br_03 ">Завершить</a>
            @endif
        @endif
    </div>
</div>

@endsection