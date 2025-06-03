@extends('author/header')

@section('title','Мои курсы')
@section('content')
    <div class="pb_1 df fdr_r ali_c jc_spb g2  br_1 bg_w w87_5 pos_f mtm_1">
        <div class="df fdr_r g4 ali_c">
            <h4 class="fsz_1_5 ff_ml c_dp">Автор/ Мои курсы</h4>
            <a href="{{route('create_course_show')}}" class="td_n df ali_c jc_c br_03 w2_5 h2_5 btn_dp_lp w_a ff_m fsz_2 ">+</a>
        </div>
        
        <form action="{{route('main_author')}}" method="GET" class="df fdr_r ali_c jc_spa g2">
            <input value="{{$old_search}}" type="text" name="search" class="w20 fsz_1 ff_mr ou_n paa_0_5 h1 brc_lp br_1 bg_w br_1" placeholder="Поиск">
            <select name="category" class=" ff_mr fsz_1 c_dp w12 paa_0_5 h1 brc_lp bg_w br_1 ou_n">
                <option value="">Категория</option>
                @foreach ($categories as $category)
                    <option {{$category->id == $old_cat ? "selected" : ""}} value="{{$category->id}}">{{$category->title}}</option>
                @endforeach
            </select>
            <select name="order" class="fsz_1 ff_mr c_dp w15 h1 paa_0_5 brc_lp bg_w br_1">
                <option {{$old_order == "access DESC" ? "selected" : ""}} value="access DESC">Сначала популярные</option>
                <option {{$old_order == "courses.created_at ASC" ? "selected" : ""}} value="courses.created_at ASC">Сначала новые</option>
                <option {{$old_order == "courses.created_at DESC" ? "selected" : ""}} value="courses.created_at DESC ">Сначала старые</option>
                <option {{$old_order == "title ASC" ? "selected" : ""}} value="title ASC">А-Я</option>
                <option {{$old_order == "title DESC" ? "selected" : ""}} value="title DESC">Я-А</option>
            </select>
            <input class="ff_m fsz_1 c_dp w7 h1 paa_0_5 brc_lp  br_1 search_course" type="submit" value="Искать">
        </form>

    </div>
    <div class="df fdr_c w80 mt_4 g2 bg_w">
        @if($count_courses > 0)
        <!-- <table class="table w87_5 "> -->
            <div class="w87">
                <div class="df fdr_r fsz_1 pos_f bg_w ff_m w87 mtm_1_7 h2_2">
                    <div class="w27 ">Название</div><!--w25-->
                    <div class="w12 ">Категория</div><!--w10-->
                    <div class="w5 ">Уроков</div><!--w7-->
                    <div class="w6 ">Студенты</div><!--w7-->
                    <div class="w5 ">Доступ</div><!--w5-->
                    <div class="w10 ">Подробнее</div><!--w5-->
                    <div class="w20">Действия</div><!--w14-->
                </div>
            </div>
            <div>

                @foreach ($courses as $course)
                <div class="df fdr_r fsz_1 ff_mr h3 w87">
                    <div class="w27 ">{{$course->title}}</div>
                    <div class="w12 ">{{$course->category}}</div>
                    <a href="{{ route('students_course', ['id_course'=>$course->id]) }}" class="w6 ">{{$course->lesson_count}}</a>
                    <div class="w5 ">{{$course->student_count}}</div>
                    <?php
                        $test = $course->test != null ? "&#10003;" : "-";
                        $access = $course->access == '1' ? "&#10003;" : "-";
                        $act1 = $course->access == "1" ? "Скрыть" : "Показать";
                        $act12 = $course->access == '1' ? '0' : '1';
                        $color_btn = $course->access == '1'? 'btn_red': ' btn_green';
                        $color = $course->access == '1'? 'bg_lg': 'bg_lr';

                        if($course->appl == 1){
                            $act1 = "В обработке";
                            $color_btn = 'bg_lgr';
                        }
                    ?>
                    <div class="w5"><div class="df w2 h2 ali_c jc_c br_1 {{$color}}">{{html_entity_decode($access)}}</div></div>
                    <div class="w10 "><a class="ff_mr fsz_1 c_dp" href="{{route('author_more_info_course', $course->id)}}">Контент</a></div>
                    <div class="df fdr_r g1 w20 h2_5 ali_c">
                        @if ($course->student_count == 0 && $course->lesson_count != 0)
                            <span onclick="ask_send_appl('{{ $course->title }}',{{ $course->id }}, {{ $course->lesson_count }}, {{ $act12 }})" class=" df ali_c jc_c ff_m fsz_0_8 h1 w7 paa_0_5 c_b  br_1 {{$color_btn}} td_n" >{{$act1}}</span>
                            <a class="ff_m fsz_0_8 c_dp w7 paa_0_5 brc_lp  br_1 search_course td_n" href="{{route('update_course_show', $course->id)}}">Редактировать</a>
                            <div onclick="ask_delete('{{ $course->title }}',{{ $course->id }}, {{ $course->lesson_count }})"><img class="w1_5" src="{{ asset('img/icons/del.webp') }}" alt=""></div>
                        @elseif($course->student_count == 0 && $course->lesson_count == 0)
                            <span class=" df ali_c jc_c ff_m fsz_0_8 h1 w7 paa_0_5 c_b  br_1 td_n ta_c brc_lp c_dp" >Заполните курс</span>
                            <a class="ff_m fsz_0_8 c_dp w7 paa_0_5 brc_lp  br_1 search_course td_n" href="{{route('update_course_show', $course->id)}}">Редактировать</a>
                            <div onclick="ask_delete('{{ $course->title }}',{{ $course->id }}, {{ $course->lesson_count }})"><img class="w1_5" src="{{ asset('img/icons/del.webp') }}" alt=""></div>
                        @else
                            <span class=" df ali_c jc_c ff_m fsz_0_8 h1 w7 paa_0_5 c_b  br_1 td_n ta_c brc_lg c_dg" >В доступе</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <span class="fsz_1_2 ff_mr c_dp">Нет курсов</span>
        @endif
    </div>
    <script>
        function ask_delete(course, course_id, count_lesson){
            let ask_course_appl = confirm('Вы уверенны, что хотите удалить курс: "'+course+'", содержащий '+count_lesson+' уроков и тестирований?');
            if(ask_course_appl){
                window.location.href = "../del_course/"+course_id;
            }else{
                alert('Курс все еще существует!');
            }
        }

        function ask_send_appl(course, course_id, count_lesson, wish_access){
            let ask_course_appl = confirm('Вы уверенны, что хотите выложить курс: "'+course+'", содержащий '+count_lesson+' уроков и тестирований?');
            if(ask_course_appl){
                window.location.href = "../send_access/"+course_id+'/'+wish_access;
            }else{
                alert('Курс все еще скрыт!');
            }
        }
    </script>
@endsection

{{-- href="{{$course->appl == 1 ? "" :route('send_access', ['course_id'=>$course->id, 'wish_access'=>$act12])}}" --}}