@extends('header')

@section('title', $title)
@section('content')

    <?php
        $done_percent = 0;
        $image = 'img/courses/';
        if($course->image){
            $image.=$course->image;
        }
        else{
            $image.= 'default.png';
        }

        if(Auth::check()){
            $all_lessons = count($lessons);
            $done_lessons = count($completed_lessons);
            if($all_lessons != 0 ){
                $process_lessons = $all_lessons-$done_lessons;
                $done_percent = (count($compl_lessons_on_course)/$all_lessons)*100;
            } 
        }
        
        
    ?>
    <div class=" w74 h8"></div>
    
    
    <div class="df fdr_c g2">
        <div class="w74 df fdr_r jc_spb ">
            <div class="df fdr_c  g1_5">
                <h2 class="fsz_2_3 ff_ml c_dp">{{$course->title}}</h2>
                <span class="paa_0_3 ff_ml c_w fsz_0_8 bg_dp br_03 w_au">{{$course->category}}</span>
                <div class="df fdr_c g0_5">
                    <span class="ff_mr fsz_1_2 c_dp">Описание</span>
                    <span class="fsz_1 ff_mr c_dp">{{$course->description}}</span>
                </div>
                <span class="fsz_1 ff_mr c_dp">Учащихся: {{$course->student_count}}</span>
                @if($complete != false)
                    <div class="df fdr_ r g4">
                        <div class="ff_mr fsz_0_8 bg_lg w_au paa_0_5 c_dg br_03">Завершен</div>
                        <a href="{{ route('certificate', ['id_course'=>$course->id]) }}" class="ou_n td_n" id="get_certificate_on_course_page" >Сертификат </a>
                    </div>
                @endif
                @if($has == false)
                    <a class="ff_mr btn_purple w8_5 td_n brc_lp fsz_1 c_dp" href="{{route('start_study', ['id_course'=>$course->id])}}">Начать изучать</a>
                @endif
            </div>
            <div class="w18">
                <img class="paa_1 w18" src="{{asset($image)}}" alt="">
            </div>
        </div>

        @auth
            <div class="df fdr_r g1 ali_c">
                <div id="progress_line_course">
                    <div id="done_progress_line_course"></div>
                </div>
                <span class="c_dp ff_m fsz_1">
                    {{ round($done_percent) }}%
                </span>
            </div>
        @endauth
        

        <div class="df fdr_c g3 ff_mr fsz_1 c_dp ptb_2">
            @if($lessons)
                <span class="ff_m fsz_2">Уроки</span>
                <div class="df fdr_c g1">
                    @foreach ($lessons as $lesson)
                        @if ($has)
                            <a href="{{route('one_lesson_student', ['id'=>$lesson->id, 'course'=>$course->id])}}" class="df fdr_r g1 ali_c td_n btn_w_lp w69 paa_1 h1 fsz_1 br_03 brc_lp">
                                <div id="{{in_array( $lesson->id, $completed_lessons) == 1 ? 'checkmark_lesson_green': 'checkmark_lesson_none'}}">{!!in_array( $lesson->id, $completed_lessons) == 1 ? '&#10003;': ''!!}</div>
                                <span>{{$lesson->title}}</span>
                            </a>
                             
                        @else
                            <div class="td_n  w69 paa_1 h1 fsz_1 br_03 brc_lp">{{$lesson->title}}</div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <script>
        let width_progress_line = $('#done_progress_line_course').width();
        one_perc_width = width_progress_line/100;
        width_done_progress = one_perc_width*{{ $done_percent }};
        $('#done_progress_line_course').css('width', width_done_progress);
    </script>
@endsection