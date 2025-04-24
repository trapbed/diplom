@extends('header')

@section('title', 'Курсы')
@section('content')
<?php
    // dump($count_courses);
?>
<div class="w100 h3"></div>
<div class="df fdr_r ali_c jc_spa g2 paa_1 br_1 bg_lp_a40">
    <form action="{{route('courses')}}" method="GET" class="df fdr_r ali_c jc_spa g2">
        <input value="{{$old_search}}" type="text" name="search" class="w26 fsz_1 ff_mr ou_n paa_0_5 h1 brc_lp br_1 bg_w br_1" placeholder="Поиск">
        <select name="category" class=" ff_mr fsz_1 c_dp w15 paa_0_5 h1 brc_lp bg_w br_1 ou_n">
            <option value="">Категория</option>
            @foreach ($categories as $category)
                <option {{$category->id == $old_cat ? "selected" : ""}} value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
        <select name="order" class="fsz_1 ff_mr c_dp w15 h1 paa_0_5 brc_lp bg_w br_1">
            <option {{$old_order == "access DESC" ? "selected" : ""}} value="access DESC">Сначала популярные</option>
            <option {{$old_order == "courses.created_at DESC" ? "selected" : ""}} value="courses.created_at DESC">Сначала новые</option>
            <option {{$old_order == "courses.created_at ASC" ? "selected" : ""}} value="courses.created_at ASC">Сначала старые</option>
            <option {{$old_order == "title ASC" ? "selected" : ""}} value="title ASC">А-Я</option>
            <option {{$old_order == "title DESC" ? "selected" : ""}} value="title DESC">Я-А</option>
        </select>
        <input class="ff_m fsz_1 c_dp w7 h1 paa_0_5 brc_lp  br_1 search_course" type="submit" value="Искать">
    </form>
</div>

<div class="df fdr_r jc_spb  paa_0_5">
    <span class="fsz_1_4 ff_m c_dp h3 lh_3">{{$header}}</span>
    <span class="ff_ml fsz_1">Результатов: {{$count_courses}}</span>
</div>


<div class="df fdr_c g3 w100 ">
    @if($count_courses == 0)
        <span class="fsz_1_2 ff_mr c_gr">Нет результатов</span>
    @else
        <?php
            $count = 1;
        ?>
        @foreach ($courses as $course)
            <?php
                $image = 'img/courses/';
                if($course->image){
                    $image.=$course->image;
                }
                else{
                    $image.= 'default.png';
                }
            ?>
            @if($count == 1)
                <div class="df fdr_r g3">
            @endif
            <div class=" df fdr_c ptb_1 pos_r">
                <img class="h5 t0 l0 als_c pos_a t_m_1_5" src="{{asset($image)}}" alt="">

                <div class="w20 pdng_course  df fdr_c g1  br_1 brc_lp  ">
                    
                    <h6 class="fsz_1 ff_mr c_dp">{{$course->title}}</h6>
                    <div class="df dfr_r jc_spb">
                        <span class="paa_0_3 ff_ml c_w fsz_0_8 bg_dp br_03  ">{{$course->category}}</span>
                        <span class="fsz_0_8 ff_mr c_dp als_e">Автор: {{$course->author}}</span>
                    </div>
                    <span class="h4 fsz_0_8 ff_mr c_dp">{{$course->description}}</span>
                    <a class="paa_0_5 brc_lp fsz_1 ff_mr w_a br_1 btn_purple td_n c_dp" href="{{route('one_course_main', $course->id)}}">Подробнее</a>
                    {{--{{$course->title}}
                    {{$course->description}}
                    {{$course->category}}
                    {{$course->title}}
                    {{$course->title}} --}}
                </div>
            </div>
            @if($count%3 == 0)
            </div>
            <?php $count = 0; ?>
            @endif
                
                <?php $count++;?>
        @endforeach
    @endif
</div>

<div class="w100 h1"></div>
@endsection