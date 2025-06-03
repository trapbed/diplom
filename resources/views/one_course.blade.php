@extends('header')

@section('title', $title)
@section('content')

    <div id="set_rate_user">
        <div id="modal_rate_user">
            <form action="{{ route('send_rate_course') }}" method="post" id="form_rate_user">
                @csrf
                <span class="ff_m fsz_1_5 c_dp">Отзыв к курсу</span>
                <input type="hidden" name="id_course" value="{{ $course->id }}">
                <input type="hidden" name="rate" id="rate_user_value">
                <div class="df fdr_r g0_5">
                    <div id="star_1" onclick="change_rate_star(1)" class="star_rate">&#9734;</div>
                    <div id="star_2" onclick="change_rate_star(2)" class="star_rate">&#9734;</div>
                    <div id="star_3" onclick="change_rate_star(3)" class="star_rate">&#9734;</div>
                    <div id="star_4" onclick="change_rate_star(4)" class="star_rate">&#9734;</div>
                    <div id="star_5" onclick="change_rate_star(5)" class="star_rate">&#9734;</div>
                </div>
                @if ($user_rate_exist != false)
                    <span class="ff_mr fsz_0_8 c_dp">Старая оценка {{ $user_rate[0]->rate }}</span>
                @endif
                <label for="text_rate" class="df fdr_c ff_mr fsz_1 c_dp g0_5">
                    Опишите свои впечатления
                    <textarea name="text_rate" id="" class=" paa_0_3 br_03 brc_dp ou_n w32_ta mn_h_4 mx_h10 ff_mr">
{{ trim($user_rate_exist != false ? $user_rate[0]->text_rate : '' )}}
                    </textarea>
                </label>
                <div class="df fdr_r jc_spb w32">
                    <div onclick="close_set_rate()" class="als_e btn_purple brc_dp ou_n ff_mr fsz_1 br_03 paa_0_5">Закрыть</div>
                    <input class="als_e btn_purple brc_dp ou_n ff_mr fsz_1 br_03 paa_0_5" type="submit" value="Отправить">
                </div>
            </form>
        </div>
    </div>

    

    <?php
    function month($month){
        switch($month){
            case 1:
                $month = 'Января';
                break;
            case 2:
                $month = 'Февраля';
                break;
            case 3:
                $month = 'Марта';
                break;
            case 4:
                $month = 'Апреля';
                break;
            case 5:
                $month = 'Мая';
                break;
            case 6:
                $month = 'Июня';
                break;
            case 7:
                $month = 'Июля';
                break;
            case 8:
                $month = 'Августа';
                break;
            case 9:
                $month = 'Сентября';
                break;
            case 10:
                $month = 'Октября';
                break;
            case 11:
                $month = 'Ноября';
                break;
            case 12:
                $month = 'Декабря';
                break;
        }
        return $month;
    }  


        $done_percent = 0;
        $image = 'img/courses/';
        if($course->image){
            $image.=$course->image;
        }
        else{
            $image.= 'default.png';
        }

        if(Auth::check()){
            if($completed_lessons != null){
                $all_lessons = count($lessons);
                $done_lessons = count($completed_lessons);
                // dd($all_lessons, $done_lessons);
                if($all_lessons != 0 ){
                    $process_lessons = $all_lessons-$done_lessons;
                    $done_percent = (count($compl_lessons_on_course)/$all_lessons)*100;
                } 
            }else{
                $done_percent = 0;
            }
        }

        if($rate == null || count($rate) <= 0){
            $text_rate = 'Нет оценок';
        }
        else{
            $text_rate = array_sum($rate)/count($rate);
        }
        
        
    ?>
    <div class=" w74 h8"></div>
    
    
    <div class="df fdr_c g2">
        <div class=" df fdr_r  g5">
            <div class="df fdr_c w60 g1_5">
                <div class="df fdr_r g1">
                    <h2 class="fsz_2_3 ff_ml c_dp">{{$course->title}}</h2>
                    @if($complete != false)
                        <span class="ff_m fsz_1 bg_lg w_au paa_0_5 c_dg br_1">Завершен</span>
                    @endif
                </div>
                
                <span class="paa_0_3 ff_ml c_w fsz_0_8 bg_dp br_03 w_au">{{$course->category}}</span>
                <div class="df fdr_c g0_5">
                    <span class="ff_m fsz_1_2 c_dp">Описание</span>
                    <span class="fsz_1 ff_mr c_dp">{{$course->description}}</span>
                </div>
                <div class="df fdr_r jc_spb">
                    <div class="df fdr_r g3">
                        <div class="df fdr_c g0_3">
                            <div class="df fdr_r g1 ali_s br_03 paa_1 bg_lp">
                                <img class="w1_5" src="{{ asset('img/icons/student-with-graduation-cap.png') }}" alt="">
                                <span class="ff_m fsz_1 c_dp">{{$course->student_count}}</span>
                            </div>
                            <span class="ff_mr fsz_0_8 c_dp">Студентов</span>
                        </div>
                        <div class="df fdr_c g0_3">
                            
                            @if ($rate == null || count($rate) <= 0)
                                <div class="df fdr_r g1 ali_s br_03 paa_1 bg_lp">
                                    <img class="w1_5" src="{{ asset('img/icons/star.png') }}" alt="">
                                    <span class="ff_m fsz_1 c_dp">0.00</span>
                                </div>
                                <span class="ff_mr fsz_0_8 c_dp">Оценок: 0</span>
                            @else
                                <div class="df fdr_r g1 ali_s br_03 paa_1 bg_lp">
                                    <img class="w1_5" src="{{ asset('img/icons/star.png') }}" alt="">
                                    <span class="ff_m fsz_1 c_dp"> {{ round($text_rate, 2) }}</span>
                                </div>
                                <span class="ff_mr fsz_0_8 c_dp">Оценок: {{ count($rate) }}</span>
                            @endif
                        </div>
                        
                    </div>

                    <div class="df fdr_r jc_spb ali_s">
                        @if($complete != false)
                            <div class="df fdr_ r g2">
                                @if ($user_rate_exist == false)
                                    <button onclick="set_rate()" class="ou_n td_n btn_w_lp paa_1 fsz_1 ff_m br_03 brc_lp">Оценить</button>
                                @else
                                    <!-- <div class="df fdr_c g0_3">
                                        <button onclick="set_rate()" class="ou_n ff_mr fsz_1 lh_3 btn_lp_dp br_03 paa_0_3">Изменить отзыв</button>
                                        <span class="ff_mr fsz_0_8 c_dp">Вы оценили курс на: {{ $rate[0] }}</span>
                                    </div> -->
                                @endif
                                <a href="{{ route('certificate', ['id_course'=>$course->id]) }}" class="ou_n td_n btn_green paa_1 fsz_1 ff_m br_03 h1_5" id="" >Сертификат </a>
                            </div>
                        @endif
                        @if($has == false)
                            <a id="btn_to_start_learning" href="{{route('start_study', ['id_course'=>$course->id])}}">Начать изучать</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="w18">
                <img class="paa_1 w18" src="{{asset($image)}}" alt="">
            </div>
        </div>

        <span class="ff_m fsz_1_2 c_dp">Отзывы ({{ count($text_rates) }})</span>
        <span id="eye_feedback" onclick="see_feedbacks()">Смотреть отзывы ⥐</span>
        <!-- ⥐⥎ -->
        <div id="block_feedback">
            @if(count($text_rates) >0)
                @foreach ($text_rates as $one_rate)
                    <?php
                        $date_feedback = $one_rate->created_at; 
                        $one_rate_date_1 = $one_rate->created_at;

                        $now = new DateTime();
                        $targetDate = new DateTime($date_feedback);
                        $interval = $now->diff($targetDate);

                        if ($interval->y > 0) {
                                $rate_date =  $interval->format('%d').' '.month(substr($date_feedback, 5, 2)).' '.substr($one_rate_date_1, 0, 4);
                        }elseif ($interval->m > 0) {
                                $rate_date =  $interval->format('%m мес. назад');
                        }elseif($interval->d == 0) {
                                $rate_date =  'сегодня';
                        }elseif($interval->d == 1) {
                                $rate_date =  'вчера';
                        }elseif($interval->d == 2) {
                                $rate_date =  'позавчера';
                        }else{
                                $rate_date =  $interval->format('%a дн.');
                        }

                        

                        
                    ?>
                    <div class="one_feedback">
                        <div class="df fdr_r jc_spb pos_r">
                            <div class="df ali_c g1">
                                <span class="ff_m fsz_1 c_dp">{{ $one_rate->email }}</span>
                                <span class="ff_mr fsz_0_8 c_lp">{{$rate_date}}</span>
                            </div>
                            @if (Auth::check() && Auth::user()->id == $one_rate->id_user)
                                <img id="more_feedback_{{ $one_rate->id }}" onmouseover="dark_more({{ $one_rate->id }})" onmouseout="light_more({{ $one_rate->id }})" class="rate_more" src="{{ asset('img/icons/more_light.png') }}" alt="">
                                <div id="rate_actions_{{ $one_rate->id }}" class="rate_actions" onmouseover="see_more({{ $one_rate->id }})" onmouseout="hide_more({{ $one_rate->id }})">
                                    <span onclick="update_feedback({{ $one_rate->id }})" id="one_action_rate_top" class="one_action_rate">Изменить</span>
                                    <hr class="hr_rate">
                                    <span onclick="del_feedback({{ $one_rate->id }})" id="one_action_rate_bottom" class="one_action_rate">Удалить</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="feedback_rate">
                            @for($i=1;$i<=5;$i++)
                                <span class="star_rate_feedback">
                                    @if($i<=$one_rate->rate)
                                        &#9733
                                    @else
                                        &#9734
                                    @endif
                                </span>
                            @endfor
                        </div>
                        
                        <span class="ff_mr fsz_1 c_dp">
                            {{ $one_rate->text_rate }}
                        </span>
                        @if($one_rate->created_at != $one_rate->updated_at)
                            <span class="ff_mr fsz_0_8 c_lp">Обновлён {{ substr($one_rate->updated_at, 8, 2) }} {{ month(substr($one_rate->updated_at, 5, 2)) }} {{ substr($one_rate->updated_at, 0, 4) }}</span>
                        @endif
                    </div>
                @endforeach
            @else
                @if($complete != false)
                    <span class="ff_mr fsz_1 c_lp">Оставьте первый отзыв</span>
                @else
                    <span class="ff_mr fsz_1 c_lp">Еще нет отзывов</span>
                @endif
            @endif
        </div>

        @if($course->any_blocks != null)
            <div id="any_blocks_course">
                @foreach (json_decode($course->any_blocks, true) as $key=>$block)
                    @switch(key($block))
                         @case('text_img')
                            <div class="type_l_text_r_img">
                                <div class="in_type_l_text_r_img">
                                        <div class="title_content_l_text_r_img">
                                            <p class="title_type_course">{{ $block['text_img']['title'] }}</p>
                                            <span class="content_type_text_img">{{ $block['text_img']['desc'] }}</span>
                                        </div>
                                        <img class="w17" src="{{ asset('img/desc_courses/img.png' ) }}" alt="">
                                </div>
                            </div>
                            @break
                        @case('list')
                        
                            <div class="type_list_block">
                                <p class="title_type_course">{{ $block['list']['title'] }}</p>
                                <span class="desc_text_d_mr_1_2">Описание списка</span>
                                <div class="type_list_list">
                                    @foreach($block['list'] as $id=>$cont)
                                        @if($id == 'points')
                                            @foreach($cont as $id_c=>$val_c)
                                                <div class="type_list_point">
                                                    <div class="type_list_num">&#9733;</div>
                                                    <span>{{ $val_c }}</span>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                    @endforeach
                                    
                                </div>
                            </div>
                            @break
                        @case('four_blocks')
                            <div class="type_four_blocks">
                                <p class="title_type_course">{{ $block['four_blocks']['title'] }}</p>
                                <div class="type_four_blocks_wrap">
                                    @foreach($block['four_blocks'] as $id=>$cont)
                                        @if(is_numeric($id))
                                            <div class="one_of_four_blocks">
                                                <img class="h6" src="{{asset('img/desc_courses/'.$cont['img'])}}" alt="img">
                                                <span class="text_center_reg_dp_1">{{ $cont['text'] }}</span>
                                            </div>
                                        @endif
                                        
                                    @endforeach
                                    
                                </div>
                            </div>
                            @break
                        @case('three_blocks')
                            <div class="type_three_blocks">
                                    <p class="title_type_course">{{ $block['three_blocks']['title'] }}</p>
                                    <div class="in_row_block">
                                        @foreach($block['three_blocks'] as $id=>$cont)
                                            @if(is_numeric($id))
                                                <div class="row_course_blocks">
                                                    
                                                    <img class="w8 h8" src="{{ asset('img/desc_courses/'.$cont['img']) }}" alt="">
                                                    <p class="p_text_m_1 ta_c">{{$cont['title']}}</p>
                                                    <span class="text_center_reg_dp_1">{{ $cont['text'] }}</span>
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    </div>
                                
                            </div>

                            @break
                        
                    @endswitch
                @endforeach
            </div>
        @endif

        <div class="df fdr_c g3 ff_mr fsz_1 c_dp ptb_2">
            @if($lessons)
                <span class="ff_m fsz_2">Уроки</span>
                @auth
                    @if($has == true)
                        <div class="df fdr_r g1 ali_c">
                            <div id="progress_line_course">
                                <div id="done_progress_line_course"></div>
                            </div>
                            <span class="c_dp ff_m fsz_1">
                                {{ round($done_percent) }}%
                            </span>
                        </div>
                    @endif
                @endauth
                <div class="df fdr_c g1">
                    @foreach ($lessons as $less_key=>$lesson)
                        @if ($has)
                            <?php
                                $image_lesson = 'lesson.webp';
                                if($lesson->type == 'test'){
                                    $image_lesson = 'testa.png';
                                }
                            ?>
                            <div class="df fdr_r g1 ali_c">
                                <img class="w2 h2" src="{{ asset('img/icons/'.$image_lesson) }}" alt="">
                                <a href="{{route('one_lesson_student', ['id'=>$lesson->id, 'course'=>$course->id])}}" class="df fdr_r g1 ali_c td_n btn_w_lp w65 paa_1 h1 fsz_1 br_03 brc_lp">
                                    <div id="{{$completed_lessons != null && in_array( $lesson->id, $completed_lessons) == 1 ? 'checkmark_lesson_green': 'checkmark_lesson_none'}}">{!!$completed_lessons!= null && in_array( $lesson->id, $completed_lessons) == 1 ? '&#10003;': ''!!}</div>
                                    <span class="w54">{{$lesson->title}}</span>
                                    
                                        @foreach($user_grades as $grade)
                                            @if($grade->id_lesson == $lesson->id)
                                                <?php
                                                    $c = 'c_dg';
                                                    $bg = 'bg_lg';
                                                    if($grade->grade == 3){
                                                        $c = 'c_dor';
                                                        $bg = 'bg_lor';
                                                    }elseif($grade->grade <= 2){
                                                        $c = 'c_dr';
                                                        $bg = 'bg_lr';
                                                    }
                                                ?>
                                                <div class="df fdr_r g1 paa_0_3 br_03 {{ $c }} {{ $bg }}">
                                                    {{ $grade->coef*100 }}%
                                                    (оц.{{ $grade->grade }})
                                                </div>
                                            @endif
                                        @endforeach
                                    
                                </a>

                            </div>
                            
                        @else
                            <div class="td_n  w69 paa_1 h1 fsz_1 br_03 brc_lp">{{$lesson->title}}</div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    @if ($user_rate_exist != false)
        <script>
                for(let i=1;i<=5;i++){
                    if(i<={{$user_rate[0]->rate}}){
                        $('#star_'+i).html('&#9733;');
                    }else{
                        $('#star_'+i).html('&#9734;');
                    }
                }
                $('#rate_user_value').attr('value', {{$user_rate[0]->rate}});
        </script>
    @endif

    <script>
        let width_progress_line = $('#done_progress_line_course').width();
        one_perc_width = width_progress_line/100;
        width_done_progress = one_perc_width*{{ $done_percent }};
        $('#done_progress_line_course').css('width', width_done_progress);

        let timeout_rate;
        function see_feedbacks(){
            $('#block_feedback').css('display', 'flex');
            $('#eye_feedback').attr('onclick', 'hide_feedbacks()');
            $('#eye_feedback').text('Скрыть отзывы ⥎');
        }

        function hide_feedbacks(){
            $('#block_feedback').css('display', 'none');
            $('#eye_feedback').attr('onclick', 'see_feedbacks()');
            $('#eye_feedback').text('Смотреть отзывы ⥐');
        }

        function light_more(id){
            timeout_rate = setTimeout(() => {
                $('#rate_actions_'+id).css('display', 'none');
                $('#more_feedback_'+id).attr('src', '../img/icons/more_light.png');
            }, 1000);
        }        
        function dark_more(id){
            $('#rate_actions_'+id).css('display', 'flex');
            $('#more_feedback_'+id).attr('src', '../img/icons/more_dark.png');   
        }
        function see_more(id){
            if(timeout_rate) {clearTimeout(timeout_rate)};
            $('#rate_actions_'+id).css('display', 'flex');
            $('#more_feedback_'+id).attr('src', '../img/icons/more_dark.png');
            $('#more_feedback_'+id).css('background-color', '#d0c4df');
        }
        function hide_more(id){
            $('#rate_actions_'+id).css('transition', 'ease-out 1s');
            $('#rate_actions_'+id).css('display', 'none');
            $('#more_feedback_'+id).attr('src', '../img/icons/more_light.png');
            $('#more_feedback_'+id).css('background-color', 'transparent');
        }
        function update_feedback(id){
            $('#set_rate_user').css('display', 'flex');
        }
        function del_feedback(id){

        }

        

        function set_rate(){
            $('#set_rate_user').css('display', 'flex');
        }

        function close_set_rate(){
            $('#set_rate_user').css('display', 'none');
        }

        function change_rate_star(rate){
            console.log(rate);
            for(let i=1;i<=5;i++){
                if(i<=rate){
                    $('#star_'+i).html('&#9733;');
                }else{
                    $('#star_'+i).html('&#9734;');
                }
            }
            $('#rate_user_value').attr('value', rate);
        }

        
    </script>
@endsection