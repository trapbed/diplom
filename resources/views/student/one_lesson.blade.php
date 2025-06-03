@extends('header')

@section('title', $lesson->title)
@section('content')
<script src="https://cdn.jsdelivr.net/npm/fuse.js@7.1.0"></script>


<div class=" w80 h6"></div>
<div id="content_tests" class="df fdr_c als_c g3 ptb_2 ali_c">
    <div id="end_timer_bg">
        <div class="paa_2 bg_lp brc_dp br_03 df fdr_c g3 ali_c">
            <span class="fsz_2_3">Время вышло!</span>
            <span class="fsz_1_5">Вы не прошли тестирование!</span>
            <div class="df fdr_r g2">
                <a href="{{route('one_course_main', $lesson->course_id)}}" class="paa_0_5 btn_wh_dp br_03 td_n">Вернутся в содержание курса</a>
                <a href="{{route('one_lesson_student', ['id'=>$lesson->id, 'course'=>$lesson->course_id])}}" class="paa_0_5 btn_wh_dp br_03 td_n">Начать сначала</a>
            </div>
        </div>        
    </div>
    <div class="df fdr_c ff_mr g1_5 w90">
        <a href="{{ route('one_course_main', $lesson->course_id) }}" class="fsz_1_5 c_dp">Курс: {{$lesson->course}}</a>
        <span class="fsz_1_2 c_dp">Урок: {{$lesson->title}}</span>
    </div>
    

    @if ($lesson->type == 'lesson')
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
                    <a href="{{route('complete_course', ['id_course'=>$lesson->course_id])}}" onclick="end_test_student(event)" class="paa_0_5 td_n btn_dp_lp ff_mr fsz_1 br_03 ">Завершить</a>
                @endif
            @endif
        </div>
    @else


    <!-- <div id="countdown">00:00:00</div>
    <div id="pauseBtn">Стоп</div> -->

    

    <?php
        $timer_to_str = '00:00:00';
        if((int)$timer != 'OFF'){
            if((int)$timer < 60){
                // dd($timer);
                
                if (strlen($timer) == 1){
                    $min = '0'.$timer;
                }
                else{
                    $min = $timer;
                }
                
                $timer_to_str = '00:'.$min.':00';
                // dd($timer_to_str);
            }
            else{
                
                $hour_num = round((int)$timer/60);
                if(strlen($hour_num) == 1){
                    $hour = '0'.$hour_num;
                }
                else{
                    $hour = $hour_num;
                }

                $min_num = $timer - $hour_num*60;
                if(strlen($min_num) == 1){
                    $min = '0'.$min_num;
                }else{
                    $min = $min_num;
                }
                $timer_to_str = $hour.':'.$min.':00';


            }
        }
        
    ?>
    <div id="timer_n_progress_one_test_student">
        <div class="df fdr_r g0_5">
            <div id="timer_test_student">
                <img src="{{ asset('img/icons/stopwatch.png') }}" alt="">
                <div id="timer_count">
                    {{$timer_to_str}}
                </div>
            
            </div>
            <div id="timer_pause" onclick="pause_timer()">
                ||
            </div>
        </div>
        <!-- <span id="is_paused"></span> -->
        <form id="form_answers_test_student" action="{{ route('check_test_student') }}" method="POST">
            @csrf
            <div id="one_test_progress_student">
                <input type="hidden" name="next_id" id="" value="{{ $next_id }}">
                <input type="hidden" name="id_test" id="" value="{{ $lesson->id }}">
                @foreach ($content as $key=>$val)
                    {{-- dd($key, $val, $content) --}}
                    @foreach ($val as $key2=>$val2)
                        
                        <div onclick="see_test_block({{ $key}})" id="checker_{{$key}}" class="one_point_progress">
                            <input disabled type="checkbox" class="is_done" name="is_done_{{ $key2 }}_{{ $key }}" id="is_done_{{ $key2 }}_{{ $key }}">
                        </div>

                        @if($key2 == 'one_answer')
                            <input type="hidden" id="hidden_one_answer_{{ $key }}" value="" name="one_answer[{{ $key }}]">
                        @elseif($key2 == 'subsequence')
                            <input type="hidden" id="hidden_subsequence_{{ $key }}" value="" name="subsequence[{{ $key }}]">                        
                        @elseif($key2 == 'word')
                            <input type="hidden" id="hidden_word_{{ $key }}" value="" name="word[{{ $key }}]">
                        @elseif($key2 == 'some_answer')
                            <input type="hidden" id="hidden_some_answer_{{ $key }}_00" class="hidden_some_answer_{{ $key }}" value="" name="some_answer[{{ $key }}][]">                        
                        @endif
                    @endforeach
                @endforeach
            
            </div>

        </form>
        <button onclick="end_test_student(event)" class="paa_0_5 ff_mr fsz_1 btn_dp_lp ou_n br_30">Завершить</button>

    </div>
    <script>
        let count_tasks = {{ count($content) }};
        let width_progress = 50;
        let width_one_point = (width_progress/count_tasks)-3;
        $('.one_point_progress').css('width', width_one_point+'vmax');
        // console.log(width_one_point);
    </script>

    @foreach ($content as $key=>$val)
        <? $count_task = count($content) ?>
        @foreach ($val as $key2=>$val2)

        <?php
            $next_task_num = $key+1;
            if($next_task_num>$count_task){
                $button ='<button onclick="end_test_student(event)" class="next_task_student">Завершить</button> ';
            }
            else{
                $button ='<button onclick="see_test_block('.$next_task_num.')" class="next_task_student">Далее</button> ';
            }
        ?>
                  
            @if($key2 == 'one_answer')
                <?php
                    $answers_one_answer = $val2->answers;
                    $shuffled_answers = shuffle($answers_one_answer);
                    $array_one_answer = array_slice($answers_one_answer, 0,3);
                    $check_exist_current_o_a = in_array($val2->current, $array_one_answer);
                    if($check_exist_current_o_a == false){
                        $array_one_answer = array_slice($array_one_answer, 0, 2);
                        array_push($array_one_answer, $val2->current);
                        shuffle($array_one_answer);
                    }
                ?>
                <div id={{ "task_".$key }} class="one_block_with_test" <?= $key == 1 ? 'style="display: flex;"': ''?>>
                    <div class="df fdr_c g1">
                        <span class="ff_mr fsz_1_2">Задание {{ $key }}</span>
                        <span class="ff_mr fsz_1_2">Вопрос: {{ $val2->question }}</span>
                    </div>
                    <div id="test_various_student">
                            <span class="ff_mr fsz_0_8 lh_2 d_lp">Выберите правильный ответ</span>
                            @foreach ($array_one_answer as $a)
                                <div class="df fdr_r g2 ff_mr fsz_1">
                                    <input onchange="change_one_answer({{ $key }}, '{{ $a }}')" type="radio" name="one_anser_{{ $key }}" value="{{ $a }}">{{ $a }}
                                </div>
                            @endforeach
                        
                    </div>

                    {!! $button !!}                    
                </div>  
                
            
            @elseif($key2 == 'word')
                <div id="task_{{ $key }}" class="one_block_with_test" <?= $key == 1 ? 'style="display: flex;"': ''?>>
                    <div class="df fdr_c g1">
                        <span class="ff_mr fsz_1_2">Задание {{ $key }}</span>
                        <span class="ff_mr fsz_1_2">Вопрос: {{ $val2->question }}</span>
                    </div>
                    <div id="test_various_student">
                        <label class="ff_mr fsz_1" for="word_{{ $key }}">Ответ</label>
                        <input  class="paa_1 brc_lp ff_mr fsz_0_8 br_03 ou_n" id="word_view_{{ $key }}" oninput="change_word({{ $key }})" type="text" name="word_{{ $key }}" value="">
                    </div>
                    {!! $button !!}                    

                </div>  
                   
            @elseif($key2 == 'subsequence')
                <?php
                    $old_array_sub = $val2->answers;
                    $array_keys_sub = array_keys($old_array_sub);
                    shuffle($array_keys_sub);
                    foreach($array_keys_sub as $arr_key){
                        $array_sub[$arr_key] = $old_array_sub[$arr_key];
                    }
                ?>
                    <div id={{ "task_".$key }} class="one_block_with_test"  <?= $key == 1 ? 'style="display: flex;"': ''?>>
                        <div class="df fdr_c g1">
                            <span class="ff_mr fsz_1_2">Задание {{ $key }}</span>
                            <span class="ff_mr fsz_1_2">{{ $val2->question }}</span>
                        </div>
                        <span class="ff_mr fsz_0_8 lh_2 d_lp">Поставьте в правильном порядке</span>
                        <div id="test_various_student">
                            @foreach($array_sub as $a=>$b)
                                <div  class="one_point ff_ml fsz_1" id="list_point_{{ $key }}_{{ $a }}" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondrop="drop(event)" ondragend="dragEnd(event)">
                                    {{ $b }}
                                </div>
                            @endforeach
                        </div>
                        
                    {!! $button !!}                    

                    </div>
              
            @elseif($key2 == 'some_answer')
                <?php
                    $array_some_answer = [];
                    foreach($val2->correct as $point){
                        array_push($array_some_answer, $point);
                    }
                    foreach($val2->incorrect as $point){
                        array_push($array_some_answer, $point);

                    }
                ?>
                <div id="task_{{ $key }}" class="one_block_with_test" <?= $key == 1 ? 'style="display: flex;"': ''?>>
                    <div class="df fdr_c g1">
                        <span class="ff_mr fsz_1_2">Задание {{ $key }}</span>
                        <span class="ff_mr fsz_1_2">Вопрос: {{ $val2->question }}</span>
                    </div>
                    <div id="test_various_student">
                        <span class="ff_mr fsz_0_8 lh_2 d_lp">Выберите правильные ответы</span>
                        
                        @foreach ($array_some_answer as $a=>$b)
                            <div class="df fdr_r g2 ff_mr fsz_1">
                                <input id="some_answer_view_{{ $key }}_{{ $a }}" onchange="change_some_answer({{ $key }}, '{{ $b }}', 'add', {{ $a }})" type="checkbox" name="some_answer[{{ $key }}][]" value="{{ $b }}">{{ $b }}
                            </div>
                        @endforeach
                        
                    </div>

                    {!! $button !!}                    
                </div>   
                
            
            @endif
        @endforeach
    @endforeach

    @endif
</div>
<script> 
    $(document).ready(function() {
        // Установите время обратного отсчета в секундах (например, 1 час = 3600 секунд)
        // let timeLeft = 3600; // 1 час
        let timeLeft = {{ $timer }}*60;
        const countdownElement = $('#timer_count');
        
        // Функция для форматирования времени
        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            return [
                hours.toString().padStart(2, '0'),
                minutes.toString().padStart(2, '0'),
                seconds.toString().padStart(2, '0')
            ].join(':');
        }
        
        // Обновляем обратный отсчет каждую секунду
        const countdownInterval = setInterval(function() {
            
            
            // Если время вышло
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownElement.text("00:00:00");
                
                $('#end_timer_bg').css('display', 'flex');
            }
            else if(isPaused == true){
                timeLeft = timeLeft;
            }
            else if(isPaused == false){
                timeLeft--;
                countdownElement.text(formatTime(timeLeft));
            }
        }, 1000);
        
        // Остановить таймер при необходимости
        $(window).on('beforeunload', function() {
            clearInterval(countdownInterval);
        });
    });

    let isPaused = false;

    function pause_timer(){
        isPaused = true;
        $('#timer_pause').html('&#9654;');
        $('#timer_pause').attr('onclick', 'continue_timer()');
    }
    function continue_timer(){
        isPaused = false;
        $('#timer_pause').html('||');
        $('#timer_pause').attr('onclick', 'pause_timer()');
    }
    // $('#timer_pause').on('click', function() {
    //     isPaused = true;
    //     console.log('dscd');
    //     $('#is_paused').text(isPaused ? "Продолжить" : "Пауза");
    // });

    // В setInterval добавить проверку:
    if (isPaused != false) {
        timeLeft--;
        // остальное обновление...
    }
</script>

<script>
    function see_test_block(num){
        $('#task_'+num).css('display', 'flex');
        $('.one_point_progress').css('background', '#d0c4df');
        $('#checker_'+num).css('background', '#54339e');
        $('.one_block_with_test').css('display', 'none');
        $('#task_'+num).css('display', 'flex');
        // console.log(num, name);
    }

    function change_one_answer(num_task, text){
        // console.log(num_task, text);
        $('#is_done_one_answer_'+num_task).attr('checked', true);
        $("#hidden_one_answer_"+num_task).val(text);
    }
        // #hidden_subsequence_
    function change_word(num_task){
        let word_value = $('#word_view_'+num_task).val().trim();
        
        if(word_value.length <= 0){
            $('#is_done_word_'+num_task).attr('checked', false);
        }
        else{
            $('#is_done_word_'+num_task).attr('checked', true);
        }
        $("#hidden_word_"+num_task).val(word_value);
        // console.log(num_task, $('#word_view_'+num_task).val().trim());
    }

    function change_some_answer(num_task, text, act, point){
        if(act == 'add'){
            let some_answer = document.createElement('input');
            some_answer.setAttribute('id', 'hidden_some_answer_'+num_task+'_'+point);
            some_answer.setAttribute('class', 'hidden_some_answer_'+num_task);
            some_answer.setAttribute('type', 'hidden');
            some_answer.setAttribute('name', 'some_answer['+num_task+'][]');
            some_answer.setAttribute('value', text);

            $('#one_test_progress_student').append(some_answer);
        
            $('#some_answer_view_'+num_task+'_'+point).attr('onchange', 'change_some_answer('+num_task+', "'+text+'", "del", '+point+')');


        }else{
            $('#hidden_some_answer_'+num_task+'_'+point).remove();
            $('#some_answer_view_'+num_task+'_'+point).attr('onchange', 'change_some_answer('+num_task+', "'+text+'", "add", '+point+')');
        }

        let count_s_a = $('.hidden_some_answer_'+num_task).length-1;
        // console.log(count_s_a);
        if(count_s_a <= 0){
            $('#is_done_some_answer_'+num_task).attr('checked', false);
        }
        else{
            $('#is_done_some_answer_'+num_task).attr('checked', true);
        }
    }




    let draggedItem = null;
    function dragStart(e) {
            draggedItem = e.target;
            e.target.style.opacity = '0.7';
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', e.target.innerHTML);
        }
    function dragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            // Определяем, куда будет вставлен элемент
            const targetItem = e.target.closest('.one_point');
            if (targetItem && targetItem !== draggedItem) {
                const rect = targetItem.getBoundingClientRect();
                const midpoint = rect.top + rect.height / 2;
                
                if (e.clientY < midpoint) {
                // Вставка перед элементом
                targetItem.parentNode.insertBefore(draggedItem, targetItem);
                } else {
                // Вставка после элемента
                    if (targetItem.nextSibling) {
                        targetItem.parentNode.insertBefore(draggedItem, targetItem.nextSibling);
                    } else {
                        targetItem.parentNode.appendChild(draggedItem);
                    }
                }
            }
        }
    function drop(e) {
        e.preventDefault();
        // Обновляем порядок в списке (можно добавить логику сохранения порядка)
        updateOrder();
    }
    function dragEnd(e) {
            e.target.style.opacity = '1';
            // Обновляем порядок в списке
            updateOrder();
        }
    function updateOrder() {
        const items = document.querySelectorAll('.one_point');
        const order = Array.from(items).map(item => item.id);
        let task_id = order[0].split('_')[2];
        let array_sub = [];
        order.forEach(element => {
            array_sub.push($('#'+element).text().trim());
        });

        $('#is_done_subsequence_'+task_id).attr('checked', true);

        // console.log(task_id, order[0].split('_'));
        $('#hidden_subsequence_'+task_id).val(array_sub);
        // console.log("Новый порядок:", array_sub);
    
    }


    function end_test_student(event){
        event.preventDefault();
        if($('.is_done').length === $('.is_done:checked').length){
            // console.log('sd');
            $('#form_answers_test_student').submit();

        }else{
            alert('Выполните все задания!');
        }
    }
</script>
@endsection