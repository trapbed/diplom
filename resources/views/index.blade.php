@extends('header')

@section('title', 'Главная')
@section('content')
<!-- hello block -->
    <div class="df frd_r jc_spb ali_e h37 g3">
        <img class="w18" src="{{asset('img/student.png')}}" alt="syudent">
        <div class="df fdr_c g3 w69 h28">
            <h1 class="c_dp ff_mr fsz_2_3">Учись вместе с нами</h1>
            <div class="df fdr_r jc_spb w60">
                <div class="df fdr_c g1 w16 br_03 brc_lp paa_1 ali_c">
                    <h2 class="ff_mr c_dp fsz_1">Из любой точки мира</h2>
                    <img class="w7  " src="{{asset('img/map.png')}}" alt="">
                    <span class="ff_mr fsz_1 ta_c c_dp lh_1_5">Ваше местоположение больше не является ограничением. Достаточно иметь доступ в интернет и желание учитсься.</span>
                </div>
                <div class="df fdr_c g1 w16 br_03 brc_lp paa_1 ali_c">
                    <h2 class="ff_mr c_dp fsz_1">В любое удобное вам время</h2>
                    <img class="w7 " src="{{asset('img/calendar.png')}}" alt="">
                    <span class="ff_mr fsz_1 ta_c c_dp lh_1_5">Ваш график больше не помеха обучению. Вы сами выбираете, когда учиться: рано утром, в обеденный перерыв, вечером или даже в выходные.</span>
                </div>
                <div class="df fdr_c g1 w16 br_03 brc_lp paa_1 ali_c">
                    <h2 class="ff_mr c_dp fsz_1">Можете начать сначала</h2>
                    <img class="w7" src="{{asset('img/remember.png')}}" alt="">
                    <span class="ff_mr fsz_1 ta_c c_dp lh_1_5">Забыли какую-то информацию- не проблема! Вернитесь в нужный блок курса и восстановите знания.</span>
                </div>
            </div>
        </div>
    </div>
<!-- popular courses-->
 <br>
 <br>
    <div class="df fdr_c ali_c w94_9 g6  h28 pos_r">
        <h3 class="fsz_1_5 ff_mr c_dp">Популярные курсы</h3>
        <div id="popular_courses_index">
            @foreach ($courses as $course)
            <div class="pos_r">
                <a href="{{ route('one_course_main', ['id_course'=>$course->id]) }}" class="one_course_index">
                    <div class="w16 h2 df jc_c">
                        <img class="one_course_index_img" src="{{ asset('img/courses/'.$course->image) }}" alt="">
                    </div>
                    <h4 class="one_course_index_title">{{$course->title}}</h4>
                    <span class="one_course_index_cat">{{$course->category}}</span>
                    <div class="df fdr_r g0_3 h2 ali_c" title="{{round($course->one_rate, 2) }}">
                        @for($i=1;$i<=5;$i++)
                            <span class="star_rate_feedback">
                                @if($i<=$course->one_rate)
                                    &#9733
                                @else
                                    &#9734
                                @endif
                            </span>
                        @endfor
                    </div>
                    <span class="ff_mr fsz_0_8 c_dp">{{mb_substr($course->description, 0,80)}}...</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>

<!-- Start Education -->
    <div class="w72 h40 als_c df fdr_r ali_c g6 pos_r">
        <img class="pos_a  image1" src="{{asset('img/i1.png')}}" alt="">
        <img class="pos_a  image2" src="{{asset('img/i2.png')}}" alt="">
        <img class="pos_a  image3" src="{{asset('img/i3.png')}}" alt="">
        <img class="pos_a w7 image4" src="{{asset('img/i4.png')}}" alt="">
        <img class="pos_a w7 image5" src="{{asset('img/i5.png')}}" alt="">
        <img class="w16" src="{{asset('img/honor_student.png')}}" alt="">
        <div class="df fdr_c g2">
        @guest
                <h2 class="fsz_2_3 ff_m c_dp">Начните учится с нами!</h2>
                <span class="fsz_1 c_dp ff_mr">Вы сами в ответе за свое будущее.</span>
                <a class="brc_lp btn_purple td_n ff_m w_a c_dp fsz_1_5 paa_2" href="{{'signup'}}">Зарегистрироваться</a>
            
        @endguest
        @auth
            <h2 class="fsz_2_3 ff_m c_dp">Начните изучать что-то новое!</h2>
            <span class="fsz_1 c_dp ff_mr">Вы сами в ответе за свое будущее.</span>
            <a class="brc_lp btn_purple td_n ff_m w12 c_dp fsz_1_5 paa_2" href="{{'courses'}}">К каталогу</a>
            {{--<a href="{{route('catalog')}}"></a>--}}
        @endauth
        </div>
    </div>
    <div class="h2"></div>
@endsection