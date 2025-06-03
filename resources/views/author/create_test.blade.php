@extends('author.header')

@section('title', "Создание урока  к курсу : '".$course->title."'")
@section('content')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>


    <!-- <form method="" id="create_test_to_db"></form> -->

    <div id="choose_format_test_bg">
        <div id="choose_format_test">
            <span class="fsz_1_5 c_dp">Выберите формат тестирования:</span>
            <div class="w_60 h3"></div>
            <div id="types_testing">
                <div id="four_types">
                    <div onclick="choosed_type(event, 'one_answer')" class="type_test">
                        <img src="{{ asset('img/icons/faq.png') }}" alt="">
                        <div>
                            <span>Один ответ</span>
                            <!-- <button class="btn_dp_lp td_n paa_0_3 ff_m fsz_1 br_1 ou_n">Выбрать</button> -->
                        </div>
                    </div>
                    <div onclick="choosed_type(event, 'subsequence')" class="type_test">
                        <img src="{{ asset('img/icons/queue.png') }}" alt="">
                        <div>
                            <span>Последовательность</span>
                            <!-- <button class="btn_dp_lp td_n paa_0_3 ff_m fsz_1 br_1 ou_n">Выбрать</button> -->
                        </div>
                    </div>
                    <div onclick="choosed_type(event, 'word')" class="type_test">
                        <img src="{{ asset('img/icons/games.png') }}" alt="">
                        <div>
                            <span>Заполнить пропуск</span>
                            <!-- <button class="btn_dp_lp td_n paa_0_3 ff_m fsz_1 br_1 ou_n">Выбрать</button> -->
                        </div>
                    </div>
                    <div onclick="choosed_type(event, 'some_answer')" class="type_test">
                        <img src="{{ asset('img/icons/test.png') }}" alt="">
                        <div>
                            <span>Несколько вариантов</span>
                            <!-- <button class="btn_dp_lp td_n paa_0_3 ff_m fsz_1 br_1 ou_n">Выбрать</button> -->
                        </div>
                    </div>

                    
                </div>
                
            </div>
        </div>
    </div>

    <span class="ff_mr fsz_2">Создание теста к курсу : '{{$course->title}}'</span>
    <!-- <span class="ff_mr fsz_1_2 c_lr">Выбирайте изображения исключительно из <span class="td_u">'img/lessons'</span>, предварительно загрузив их <a href="">в меню->второй раздел.</a></span> -->
    <span class="ff_mr fsz_1">Уже есть: {{count($test)}}</span>
    <div class="df fdr_r jc_spb pos_f bg_w b_2 w84  br_03">
        <form class="df fdr_r g1 w50 brc_lp br_03 paa_0_5" enctype="multipart/form-data">
            <div onclick="choose_type_show(event)" class="df ali_c jc_c btn_dp_lp ff_mr fsz_1 w2_5 h2_5 ou_n br_03">+</div>
            <div id="timer_block" class="df fdr_r g1">
                <?php
                    $timer = 'OFF';
                    if(old('timer') != null){
                        $timer = old('timer') != 'OFF' ? old('timer') : 'OFF';
                    }
                    // dump($timer);
                ?>
                @if ($timer == 'OFF')

                    <label class="df  ali_s ff_m fsz_0_8" for="">
                            <div id="time_switch_test" class="" onclick="switch_time('on')">
                                <img id="time_switch_img" src="{{ asset('img/icons/stopwatch.png') }}" alt="">
                                <span id="time_switch_text">OFF</span>
                            </div>
                        
                        
                    </label>
                    <label id="timer_on" for="">
                        <input type="number" min="0"  max="120" name="" value="{{ (old('timer')!='OFF')? old('timer'): 0 }}" id="test_timer_minutes" oninput="change_minute_timer(this)" onchange="change_minute_timer(this)" placeholder="Временное ограничение">
                        <span class="fsz_1 c_dp">мин</span>
                    </label>
                @else
                    {!! old('old_timer_html') !!}
                @endif
            </div>
        </form>

        <button onclick="check_test_before_submit(event)"  class="btn_dp_lp br_03 paa_0_5 ou_n w_au ff_mr fsz_1">Создать тест</button>

    </div>
{{-- 
    
                <div id="time_switch_test" class="{{ $timer == 'OFF' ? 'time_switch_on' : 'time_switch_off' }}" onclick="switch_time({{ $timer == 'OFF' ? 'on' : 'off' }})">
                    <img class="{{ $timer == 'OFF' ? 'time_switch_img_on' : 'time_switch_img_off' }}" id="time_switch_img" src="{{ asset('img/icons/stopwatch.png') }}" alt="">
                    <span class="{{ $timer == 'OFF' ? 'time_swith_text_on' : 'time_swith_text_off' }}" id="time_switch_text">{{ $timer == 'OFF' ? 'OFF' : 'ONZ' }}</span>
                </div> --}}

    <div id="preview"  class="sc_w_th oy_s h27 df fdr_c g1 pos_r">
        {{-- @foreach (old() as $key=>$val)
            {{ $key }}
            @if ($key  == 'title_test')
                {{ $val }}
            @endif
        @endforeach--}}

        <script>
            let array_mess = [];
        </script>
         
        {{-- dump(old('title')? old('title') :'') --}}
        <form method="POST" action="{{ route('create_test_db') }}" id="preview_inputs">
            @csrf
            {{--@if (!old('old_html'))--}}
                <input type="hidden"  name="timer" id="preview_timer_minutes" value="{{ old('timer') ?? 'OFF' }}">
                <input type="hidden" name="id_course" value="{{$course->id}}">
                <label class="fsz_1_2 ff_mr c_dp df fdr_c g0_5" for="title">Заголовок тестирования
                    <input required id="title_lesson" class="w48 h1 paa_0_3 ff_mr fsz_1 br_03 brc_lp ou_n" type="text" name="title_test" value="{{ old('title_test') }}">
                </label>
                {{--@error('title_test')
                    <span class="error_form_test">{{ $message }}</span>
                @enderror--}}
            
                <address></address>

            {{--@endif--}}
        {!! old('old_html') !!}
            
        </form>

        @if ($errors->any())
            <div class="errors_absolute_red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
    </div>
    <br><br>

    <script>
        console.log(array_mess);
        preview = document.querySelector("#preview");
        preview_inputs = $("#preview_inputs");
        all_count = 0;

        // ПЕРЕКЛЮЧАТЕЛЬ ТАЙМЕРА
        function switch_time(button){
            if(button === 'on'){
                $('#time_switch_test').css('flex-direction','row-reverse');
                $('#time_switch_test').css('border','0.2vmax solid white');
                $('#time_switch_test').css('background','#54339e');
                $('#time_switch_text').css('color','#d0c4df');
                $('#time_switch_img').css('box-shadow',' 0 0 0.4vmax #d0c4df');
                $('#time_switch_text').text('ON');
                $('#time_switch_test').attr('onclick', "switch_time('off')");
                $('#timer_on').css('display', 'flex');
            }else{
                $('#time_switch_test').css('flex-direction','row');
                $('#time_switch_test').css('border','0.2vmax solid #d0c4df');
                $('#time_switch_test').css('background','none');
                $('#time_switch_text').css('color','#54339e');
                $('#time_switch_img').css('box-shadow','none');
                $('#time_switch_text').text('OFF');
                $('#time_switch_test').attr('onclick', "switch_time('on')");
                $('#timer_on').css('display', 'none');
            }
            
            // $('#time_switch_img').attr('src', "{{ asset('img/icons/stopwatch _lp.png')}}");
        }

        function change_minute_timer(event){
            let timer_minutes = $('#test_timer_minutes').val();
            $('#preview_timer_minutes').val(timer_minutes);
            $('#test_timer_minutes').attr('value', timer_minutes);
        }

        // МОДАЛЬНОЕ ОКНО С ВЫБОРОМ ТИПА ЗАДАНИЯ
        function choose_type_show(event){
            $('#choose_format_test_bg').css('display', 'flex');
        }
        // ЗАКРЫТИЕ ОКНА С ВЫБОРОМ ТИПА ЗАДАНИЯ
        $("#choose_format_test_bg").on('click', function(event){
            if(event.target == event.currentTarget){
                $('#choose_format_test_bg').css('display', 'none');
            }
        });

        // ВЫБОР ОТВЕТА
        function choosed_type(event, type){
            let count_tasks = $('.test_task');
            if(count_tasks){
                count_tasks = $('.test_task').length+1;
            }else{
                count_tasks = 0;
            }
            // console.log(count_tasks);
            switch (type){
                
                case 'one_answer':
                    // alert('d');
                    let cont_1 = document.createElement('div');
                    cont_1.classList.add('test_task', 'df', 'fdr_c', 'g1');
                    cont_1.setAttribute('id', 'one_answer_'+count_tasks);
                    count_one_answer_td = 1;

                    // console.log(document.localStorage);
                    

                    cont_1.innerHTML = `
                        <p class="ff_m fsz_1 c_dp">Задание `+count_tasks+` - с одним вариантом ответа</p>
                        <!-- Задание с одним верным вариантом -->
                        <div class="df fdr_c g0_5">
                            <span class='fsz_0_8 ff_m'>&nbsp; Текст вопроса</span>
                            <input type="hidden" value="one_answer_text" name="type_`+count_tasks+`">
                            
                            <input  
                                onchange="one_answer_change_question(`+count_tasks+`)" 
                                onkeyup="one_answer_change_question(`+count_tasks+`)"
                                onkeydown="one_answer_change_question(`+count_tasks+`)"
                                onkeypress="one_answer_change_question(`+count_tasks+`)"
                                oninput="one_answer_change_question(`+count_tasks+`)"
                                onpaste="one_answer_change_question(`+count_tasks+`)"
                            class="ff_ml fsz_0_8 ou_n paa_0_3 brc_lp wmx_46 br_03" type="text" value="" id="one_answer_question_`+count_tasks+`" name="text_`+count_tasks+`">
                        </div>

                        <div class="df fdr_c g0_5">
                            <span class='ff_m fsz_0_8'>&nbsp; Варианты ответа</span>
                            <div class="df fdr_r g1">
                                <input class="ou_n br_03 brc_lp paa_0_3 ff_ml fsz_0_8 w16" type="text" name="various_`+count_tasks+`" id="various_`+count_tasks+`">
                                <input class="ou_n btn_dp_lp ff_m fsz_0_8 paa_0_3 br_03" type="submit" value="+" onclick="one_answer(event, 'various_`+count_tasks+`', `+count_tasks+`)">
                            </div>
                            <span class="attention_task" id="attention_task_`+count_tasks+`">Минимум три варианта ответа</span>
                            <table id="all_various_`+count_tasks+`" class="w40 border_various">
                                <tr class="border_various count_td_task_`+count_tasks+`" id="one_answer_various_td_`+count_tasks+`_1">
                                    <td class='ff_m fsz_0_8 w40 df fdr_r jc_spb '>
                                        <div>
                                            <input class="one_answer_answers_`+count_tasks+`" id="get_value_one_answer_`+count_tasks+`_1" type="radio" name="input_various_`+count_tasks+`" value="Ответ 1" onclick="one_answer_change_inputs(event, '`+count_tasks+`', '1')"> Ответ 1 
                                        </div> 
                                    <div class="w1_5 h1_5 paa_0_3 btn_dp_lp fsz_0_8 df ali_c jc_c br_03" onclick="del_one_answer_various(`+count_tasks+`,'1', 'one_answer_various_td_`+count_tasks+`_`+count_one_answer_td+`', event)">x</div></td>
                                </tr>
                            </table>
                            <span class="ff_ml fsz_0_8">(отметьте правильный ответ)</span>
                        </div>
                        <div class='del_test_task' onclick="del_test_task('one_answer_`+count_tasks+`')">x</div>`;
                    $('#choose_format_test_bg').css('display', 'none');
                    preview.append(cont_1);
                    let input_one_answer = document.createElement('label');
                    input_one_answer.setAttribute('for', 'one_answer_'+count_tasks);
                    input_one_answer.setAttribute('id', 'one_answer_'+count_tasks+'_hidden');
                    input_one_answer.innerHTML = `
                        <input type="hidden" name="one_answer[`+count_tasks+`][question]" id="one_answer_`+count_tasks+`_question" value="">
                        <select id="one_answer_`+count_tasks+`_answers" multiple="multiple" hidden name="one_answer[`+count_tasks+`][answers][]">
                            <option value='Ответ 1' selected id="input_various_`+count_tasks+`_1">Ответ 1</option>
                        </select>
                        <input type="hidden" id="one_answer_`+count_tasks+`_current" name="one_answer[`+count_tasks+`][current]" value="">
                    `;
                    preview_inputs.append(input_one_answer);
                    break;
                case 'subsequence':
                    let cont_2 = document.createElement('div');
                    cont_2.classList.add('test_task');
                    cont_2.setAttribute('id', 'subsequence_'+count_tasks);
                    // $('#subsequence').css('background', 'red');
                    cont_2.innerHTML = `
                    <p class="ff_m fsz_1 c_dp">Задание `+count_tasks+` - последовательность</p>
                    
                    <div class="df fdr_c g0_5">
                        <span class='ff_m fsz_0_8'>&nbsp; Текст вопроса</span>
                        
                        <input
                            onchange="subsequence_change_question(`+count_tasks+`)" 
                            onkeyup="subsequence_change_question(`+count_tasks+`)"
                            onkeydown="subsequence_change_question(`+count_tasks+`)"
                            onkeypress="subsequence_change_question(`+count_tasks+`)"
                            oninput="subsequence_change_question(`+count_tasks+`)"
                            onpaste="subsequence_change_question(`+count_tasks+`)"
                        class="ff_ml fsz_0_8 ou_n paa_0_3 brc_lp wmx_46 br_03" type="text" id="subsequence_`+count_tasks+`_question_viewed" name="subsequence[`+count_tasks+`][question]" value="">

                    </div>

                    <div class="df fdr_c g0_5">
                        <span class='fsz_0_8'>&nbsp; Варианты ответа</span>
                        <div class="df fdr_r g1">
                            <input class="ou_n br_03 brc_lp paa_0_3 ff_ml fsz_0_8 w16" type="text" name="various_`+count_tasks+`" id="various_`+count_tasks+`">
                            <input class="ou_n btn_dp_lp ff_m fsz_0_8 paa_0_3 br_03 h2 w2" type="submit" value="+" onclick="add_subsequence(event, 'various_`+count_tasks+`', 'list_various_`+count_tasks+`')" form="middle">
                        </div>
                        <span class="ff_ml fsz_0_8">(поставьте в правильном порядке)</span>
                        <div class="df fdr_c g1 points_list" id="list_various_`+count_tasks+`" >
                            <div class="one_point" id="list_point_`+count_tasks+`_1" draggable="true" ondragstart="dragStart(event)" ondragover="dragOver(event)" ondrop="drop(event)" ondragend="dragEnd(event)">
                                <span class="fsz_0_8 ff_m w40 ">Пункт 1</span>
                                <div class="df fdr_c jc_spb h3">
                                    <span class="fsz_1_5 lh_1_5">⥎</span>
                                    <span class="fsz_1_5 lh_1_5">⥐</span>
                                </div>
                                <div onclick="del_subsequence('list_point_`+count_tasks+`_1', `+count_tasks+`, 1)" class="fsz_1 ff_ml btn_dp_lp paa_0_3 df fdr_c ali_c jc_c br_03">
                                    x
                                </div>
                            </div>                            
                        </div>
                    </div>   
                    <div class='del_test_task' onclick="del_test_task('subsequence_`+count_tasks+`')">x</div>
                    `;
                    
                    let label_inputs = document.createElement('label');
                    label_inputs.setAttribute('for', 'subsequence_'+count_tasks);
                    label_inputs.setAttribute('id', 'subsequence_'+count_tasks+'_hidden');
                    label_inputs.innerHTML = `
                        <input type="hidden" id="subsequence_`+count_tasks+`_question_hidden" name="subsequence[`+count_tasks+`][question]" value="">
                        <select multiple="multiple" hidden name="subsequence[`+count_tasks+`][answers][]">
                            <option value="Пункт 1" selected id="subsequence_`+count_tasks+`_1">Пункт 1</option>
                        </select>
                    `;
                    $('#preview_inputs').append(label_inputs);

                    $('#choose_format_test_bg').css('display', 'none');
                    preview.append(cont_2);
                    break;
                case 'word':
                    let cont_3 = document.createElement('div');
                    cont_3.classList.add('test_task');
                    cont_3.setAttribute('id','word_'+count_tasks);
                    cont_3.innerHTML = `
                    <p class="ff_m fsz_1 c_dp">Задание `+count_tasks+` - текстовый ответ</p>
                    <!-- Задание с одним верным вариантом -->
                    <div class="df fdr_c g0_5">
                        <span class="ff_m fsz_0_8">&nbsp; Текст вопроса</span>
                        <input type="hidden" value="word" name="type_`+count_tasks+`">
                        <input
                            onchange="word_change_question(`+count_tasks+`)" 
                            onkeyup="word_change_question(`+count_tasks+`)"
                            onkeydown="word_change_question(`+count_tasks+`)"
                            onkeypress="word_change_question(`+count_tasks+`)"
                            oninput="word_change_question(`+count_tasks+`)"
                            onpaste="word_change_question(`+count_tasks+`)"
                        class="ff_ml fsz_0_8 ou_n paa_0_3 brc_lp wmx_46 br_03" type="text" id="word_`+count_tasks+`_question_viewed" name="word_`+count_tasks+`_question">

                    </div>

                    <div class="df fdr_c g0_5">
                        <span class="ff_m fsz_0_8">&nbsp; Ответ</span>
                        <input
                            onchange="word_change_answer(`+count_tasks+`)" 
                            onkeyup="word_change_answer(`+count_tasks+`)"
                            onkeydown="word_change_answer(`+count_tasks+`)"
                            onkeypress="word_change_answer(`+count_tasks+`)"
                            oninput="word_change_answer(`+count_tasks+`)"
                            onpaste="word_change_answer(`+count_tasks+`)"
                         class="ff_m fsz_0_8 c_dp brc_lp br_03 paa_0_3 ou_n w46" type="text" id="word_answer_`+count_tasks+`" name="word_answer`+count_tasks+`" value="">
                       
                    </div>
                    <div class='del_test_task' onclick="del_test_task('word_`+count_tasks+`')">x</div>
                    `;
                    $('#choose_format_test_bg').css('display', 'none');
                    preview.append(cont_3);

                    let label_word = document.createElement('label');
                    label_word.setAttribute('for', 'word_'+count_tasks);
                    label_word.setAttribute('id', 'word_'+count_tasks+'_hidden');
                    label_word.innerHTML = `
                        <input type="hidden" name="word[`+count_tasks+`][question]" id="word_`+count_tasks+`_question_hidden" value="">
                        <input type="hidden" name="word[`+count_tasks+`][current]" id="word_`+count_tasks+`_answer_hidden" value="">
                    `;
                    $('#preview_inputs').append(label_word);

                    break;
                case 'some_answer':
                    let choosed_type_is_some_answer = document.createElement('div'); 
                    choosed_type_is_some_answer.classList.add('test_task');
                    choosed_type_is_some_answer.setAttribute('id','some_answer_'+count_tasks);
                    choosed_type_is_some_answer.innerHTML = `
                    <p class="ff_m fsz_1 c_dp">Задание `+count_tasks+` - несколько правильных ответов</p>
                    <div class="df fdr_c g0_5 fsz_0_8">
                        <span class="fsz_0_8">&nbsp; Текст вопроса</span>
                        <input type="hidden" value="one_answer" name="type_1">
                        <input
                            onchange="some_answer_change_question(`+count_tasks+`)" 
                            onkeyup="some_answer_change_question(`+count_tasks+`)"
                            onkeydown="some_answer_change_question(`+count_tasks+`)"
                            onkeypress="some_answer_change_question(`+count_tasks+`)"
                            oninput="some_answer_change_question(`+count_tasks+`)"
                            onpaste="some_answer_change_question(`+count_tasks+`)"
                         class="ff_ml fsz_0_8 h1_5 ou_n paa_0_3 brc_lp wmx_46 br_03" type="text" id="some_answer_`+count_tasks+`_question_viewed" name="text_1" value="">

                    </div>

                    <div class="df fdr_c g0_5 fsz_0_8">
                        &nbsp; Варианты ответа
                        <div class="df fdr_r g1">
                            <input required class="h1_5 ou_n br_03 brc_lp paa_0_3 ff_ml fsz_0_8 w16" type="text" name="various_`+count_tasks+`" id="various_`+count_tasks+`">
                            <input class="ou_n btn_dp_lp ff_m fsz_0_8 br_03 h2 w2" type="submit" value="+" onclick="add_some_answer(event, 'various_`+count_tasks+`', `+count_tasks+`)" form="middle">
                        </div>
                        <!-- <span class="ff_ml fsz_0_8">(поставьте в правильном порядке)</span> -->
                        <div class="df fdr_c g1 points_list" id="list_various_`+count_tasks+`" >
                            <div class="one_point_5" id="list_point_`+count_tasks+`_1">
                                <div class="df fdr_r g2">
                                    <input type="checkbox" class="some_answer_answers_`+count_tasks+`" name="" id="some_answer_answers_`+count_tasks+`_1" value=""  onclick="some_answer_to_correct(`+count_tasks+`, 1, 'Ответ 1')"> 
                                    <span class="fsz_0_8 ff_m">Ответ 1</span>
                                </div>
                                
                                <div class="btn_dp_lp paa_0_5 br_03">x</div>
                            </div>                            
                        </div>
                    </div>
                    <div class='del_test_task' onclick="del_test_task('some_answer_`+count_tasks+`')">x</div>
                    `;
                    $('#choose_format_test_bg').css('display', 'none');
                    preview.append(choosed_type_is_some_answer);
                        // 


                    let label_q_sq =document.createElement('label');
                    label_q_sq.setAttribute('for', 'some_answer_'+count_tasks+'_question');
                    label_q_sq.setAttribute('id', 'some_answer_'+count_tasks+'_question');
                    label_q_sq.innerHTML = `
                        <input type="hidden" name="some_answer[`+count_tasks+`][question]" value="" id="some_answer_`+count_tasks+`_question_hidden">
                    `;
                    $('#preview_inputs').append(label_q_sq);
                    let new_label = document.createElement('label');
                    new_label.setAttribute('for', 'some_answer_'+count_tasks+'_incorrect');
                    new_label.setAttribute('id', 'some_answer_'+count_tasks+'_incorrect');
                    new_label.innerHTML = `
                        <input type="hidden" name="some_answer[`+count_tasks+`][incorrect][1]" id="some_answer_`+count_tasks+`_1_incorrect" value="Ответ 1">
                    `;
                    $('#preview_inputs').append(new_label);

                    let new_label_correct = document.createElement('label');
                    new_label_correct.setAttribute('for', 'some_answer_'+count_tasks+'_correct');
                    new_label_correct.setAttribute('id', 'some_answer_'+count_tasks+'_correct');
                    $('#preview_inputs').append(new_label_correct);
                    break;    
            }
        }     
        // УДАЛЕНИЕ ЗАДАЧИ
        function del_test_task(selector){
            // console.log(selector.split('_')[]);
            if(selector.split('_')[0] == 'some'){
                $('#'+selector).remove();
                $('#some_answer_'+selector.split('_')[2]+'_incorrect').remove();
                $('#some_answer_'+selector.split('_')[2]+'_correct').remove();
                $('#some_answer_'+selector.split('_')[2]+'_question').remove();
            }else{
                $('#'+selector).remove();
                $('#'+selector+'_hidden').remove();
            }
           
        }



        // ОДИН ОТВЕТ
        function one_answer(event, input, task){
            
            event.preventDefault();
            let count_tasks = $('.test_task');
            if(count_tasks){
                count_tasks = $('.test_task').length;
            }else{
                count_tasks = 0;
            }
            let count_task_various = $('.count_td_task_'+task).length;
            let now_number = $('.count_td_task_'+task).length+1;
            // count_one_answer_td++;
            count_one_answer_td = now_number;
            console.log(count_tasks, count_one_answer_td);
            // console.log(now_number, count_one_answer_td);
            if(count_one_answer_td<3){
                $('#attention_task_'+task).text('Минимум три варианта ответа');
            }else{
                $('#attention_task_'+task).text('');
            }
            val = $('#'+input).val();
            if(val.length){
                let tr = document.createElement('tr');
                tr.classList.add('border_various', 'count_td_task_'+task);
                tr.setAttribute('id', `one_answer_various_td_`+count_tasks+`_`+count_one_answer_td);
                tr.innerHTML = `
                        <td class='ff_m fsz_0_8 w40 df fdr_r jc_spb '><div><input  class="one_answer_answers_`+count_tasks+`"  id="get_value_one_answer_`+count_tasks+`_`+count_one_answer_td+`" type="radio" name="input_various_`+count_tasks+`" value="`+val+`" onclick="one_answer_change_inputs(event, '`+count_tasks+`', '`+count_one_answer_td+`')">`+val+`</div> <div class="w1_5 h1_5 paa_0_3 btn_dp_lp fsz_0_8 df ali_c jc_c br_03" onclick="del_one_answer_various(`+count_tasks+`, `+count_one_answer_td+`,'one_answer_various_td_`+count_tasks+`_`+count_one_answer_td+`', event)">x</div></td>
                `;
                $('#all_various_'+task).append(tr);
                $('#'+input).val('');

                let new_option = document.createElement('option');
                new_option.setAttribute('selected', true);
                new_option.setAttribute('value', val);
                new_option.setAttribute('id', `input_various_`+count_tasks+`_`+count_one_answer_td);
                new_option.innerHTML = ``+val+``;
                $('#one_answer_'+task+'_answers').append(new_option);
            }else{
                alert('Заполните поле!');
            }
            
        }

        function one_answer_change_inputs(event, task, answer){
            current_val = $('#get_value_one_answer_'+task+'_'+answer).val();
            $('.one_answer_answers_'+task).attr('checked', false);
            $('#get_value_one_answer_'+task+'_'+answer).attr('checked', true);
            hidden_current = $('#one_answer_'+task+'_current').val();
            console.log( hidden_current);
            
            $(`#one_answer_`+task+`_current`).attr('value',current_val);
        }

        function one_answer_change_question(task){
            if( $.trim($('#one_answer_question_'+task).val().replace(/\s+/g, ' ')) !== $('#one_answer_'+task+'_question').val()){
                let preview_question_one_answer = $.trim($('#one_answer_question_'+task).val().replace(/\s+/g, ' '));
                $('#one_answer_'+task+'_question').val(preview_question_one_answer);
                $('#one_answer_question_'+task).attr('value', preview_question_one_answer);
                // _____SET VALUE INPUT
                console.log(preview_question_one_answer);
            }
        }

        function del_one_answer_various(task, answer, td, event){
            current_val = $('#preview_inputs').find('#one_answer_'+task+'_hidden').find('select').find('#input_various_'+task+'_'+answer).val();
            if($(`#one_answer_`+task+`_current`).val() == current_val){
                $(`#one_answer_`+task+`_current`).val('');
            }
            let splits = td.split('_');
            count_one_answer_various = $('#all_various_'+task).find('tbody').find('tr').length-1;
            if(count_one_answer_various < 3){
                $('#attention_task_'+task).text('Минимум три варианта ответа');
            }else{
                $('#attention_task_'+task).text('');
            }
            // console.log(td);
            $('#'+td).remove();
            $('#preview_inputs').find('#one_answer_'+task+'_hidden').find('select').find('#input_various_'+task+'_'+answer).remove();
        }



        // ПОСЛЕДОВАТЕЛЬНОСТЬ
        function add_subsequence(event, task, list_various_count){
            event.preventDefault();
            if($('#'+task).val().length > 0){
                let counter= $('#'+list_various_count).first().length+1;
                let counter_list = $('.one_point').length+1;

                task_split = task.split('_');
                task_num = task_split[1];
                // SLIDE
                let points = document.createElement('div');
                points.classList.add('one_point');
                points.setAttribute('id', 'list_point_'+task_num+'_'+counter_list);
                points.setAttribute('draggable', 'true');
                points.setAttribute('ondragstart', 'dragStart(event)');
                points.setAttribute('ondragover', 'dragOver(event)');
                points.setAttribute('ondrop', 'drop(event)');
                points.setAttribute('ondragend', 'dragEnd(event)');
                points.innerHTML = `
                        <span class="fsz_0_8 ff_m w40 ">`+$('#'+task).val()+`</span>
                        <div class="df fdr_c jc_spb h3">
                            <span class="fsz_1_5 lh_1_5">⥎</span>
                            <span class="fsz_1_5 lh_1_5">⥐</span>
                        </div>
                        <div onclick="del_subsequence('list_point_`+task_num+`_`+counter_list+`', `+task_num+`, `+counter_list+`)" class="fsz_1 ff_ml btn_dp_lp paa_0_3 df fdr_c ali_c jc_c br_03">
                            x
                        </div>`;
                $('#list_'+task).append(points);

                // PREVIEW_INPUTS
                let option_inputs = document.createElement('option');
                option_inputs.setAttribute('value', $('#'+task).val());
                // console.log(task);
                option_inputs.setAttribute('selected', true);
                task_id = task.split('_');
                task_id = task_id[1];
                // console.log(task_id);
                option_inputs.setAttribute('id', `subsequence_`+task_id+`_`+counter_list);
                option_inputs.innerText = $('#'+task).val();
                
                $('#preview_inputs').find('#subsequence_'+task_num+'_hidden').find('select').append(option_inputs);
                // CLEAN INPUT
                $('#'+task).val('');
            }
            else{
                alert('Введите текст');
            }
        }
        
        function del_subsequence(selector, task, answer){
            $('#'+selector).remove();
            $('#preview_inputs').find('#subsequence_'+task+'_hidden').find('select').find('#subsequence_'+task+'_'+answer).remove();
            console.log(selector, task, answer);
        }
        
        function subsequence_change_question(task){
            // `subsequence_`+count_tasks+`_question_viewed`
            // `subsequence_`+count_tasks+`_question_hidden`
            if( $.trim($('#subsequence_'+task+'_question_viewed').val().replace(/\s+/g, ' ')) !== $('#subsequence_'+task+'_question_hidden').val()){
                let preview_question_subsequence = $.trim($('#subsequence_'+task+'_question_viewed').val().replace(/\s+/g, ' '));
                $('#subsequence_'+task+'_question_hidden').val(preview_question_subsequence);
                $('#subsequence_'+task+'_question_viewed').attr('value', preview_question_subsequence);
            }
        }
        //DRAG AND DROP
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
            const items_text = document.querySelectorAll('.one_point');
            const order_id = Array.from(items).map(item => item.id);
            let order_val = Array.from(items).map(items=>items.id);
            let array_of_list = [];

            $.each(order_id, function  (item, id) {
                id_1 = id.charAt(11).toLowerCase();
                array_of_list[id_1] = array_of_list[id_1] || [];
                array_of_list[id_1].push(id);
            });
            $.each(array_of_list, (id_task, array)=>{
                // let new_select = document.createElement('select');
                // new_select.setAttribute('multiple', true);
                // new_select.setAttribute('hidden', true);
                // new_select.setAttribute('name', 'subsequence['+id_task+'][answers]');

                let new_options = '';
                $.each(array, (id_1, selector_id)=>{
                    let text_id = $('#'+selector_id).find('span').text().slice(0, -2);
                    id_answer = selector_id.charAt(13).toLowerCase();
                    new_options +='<option value="'+text_id+'" selected id="subsequence_'+id_task+'_'+id_answer+'">'+text_id+'</option>';
                });
                // new_select.innerHTML = new_options;

                $('#subsequence_'+id_task+'_hidden').find('select').html(new_options);
            });
        }
       


        // ОДИН ПРОПУСК
        function save_word(id_task){
            let answer_text = $('#word_answer_'+id_task).val();
            let question_text = $('#word_'+id_task+'_question').val();
            $('#preview_inputs').find('#word_'+id_task).find('#word_'+id_task+'_answer').val(answer_text);
        }
        
        function word_change_question(task){
            if( $.trim($('#word_'+task+'_question_viewed').val().replace(/\s+/g, ' ')) !== $('#word_'+task+'_question_hidden').val()){
                let preview_question_subsequence = $.trim($('#word_'+task+'_question_viewed').val().replace(/\s+/g, ' '));
                $('#word_'+task+'_question_hidden').val(preview_question_subsequence);
                $('#word_'+task+'_question_viewed').attr('value', preview_question_subsequence);
            }
        }

        function word_change_answer(task){
            if( $.trim($('#word_answer_'+task).val().replace(/\s+/g, ' ')) !== $('#word_'+task+'_answer_hidden').val()){
                let preview_answer_word = $.trim($('#word_answer_'+task).val().replace(/\s+/g, ' '));
                $('#word_'+task+'_answer_hidden').val(preview_answer_word);
                $('#word_answer_'+task).attr('value', preview_answer_word);
            }
        }
        
        // НЕСКОЛЬКО ОТВЕТОВ
        function add_some_answer(event, some_answer, task){
            event.preventDefault();
            // alert(some_answer);
            if($('#'+some_answer).val().length){
                let s_a = $('#'+some_answer).val();
                let con_5 = document.createElement('div');
                con_5.classList.add('one_point_5');
                let count_5 = $('.one_point_5').length+1;
                con_5.setAttribute('id', 'list_point_'+task+'_'+count_5);

                // new_input.setAttribute('onclick', 'some_answer_to_correct('+task+', '+count_5+')');
                con_5.innerHTML = `<div class="df fdr_r g2">
                                        <input type="checkbox" class="some_answer_answers_`+task+`" name="" id="some_answer_answers_`+task+`_`+count_5+`" value=""  onclick="some_answer_to_correct(`+task+`, `+count_5+`, '`+s_a+`')"> 
                                        <span class="fsz_0_8 ff_m">`+s_a+`</span>
                                    </div>
                                    
                                    <div class="btn_dp_lp paa_0_5 br_03">x</div>`;
                $('#list_'+some_answer).append(con_5);


                // let new_label = document.createElement('label');
                // new_label.setAttribute('for', 'some_answer_'+count_tasks+'_incorrect');
                // new_label.setAttribute('id', 'some_answer_'+count_tasks+'_incorrect');
                new_input = document.createElement('input');
                new_input.setAttribute('hidden', true);
                new_input.setAttribute('name', 'some_answer['+task+'][incorrect]['+count_5+']');
                new_input.setAttribute('id', 'some_answer_'+task+'_'+count_5+'_incorrect');
                new_input.setAttribute('value', s_a);
                $('#preview_inputs').find('#some_answer_'+task+'_incorrect').append(new_input);
                // $('#preview_inputs').append(new_label);

                $('#'+some_answer).val('');
            }
            else{
                alert('Заполните поле, после чего создайте новый вариант ответа!');
            }
            
        }
        
        function some_answer_to_correct(task, answer, text){
            $('#preview_inputs').find('#some_answer_'+task+'_incorrect').find('#some_answer_'+task+'_'+answer+'_incorrect').remove();
            
            $('#some_answer_answers_'+task+'_'+answer).attr('onclick', 'some_answer_to_incorrect('+task+','+answer+', "'+text+'")');
            let correct_input = document.createElement('input');
            correct_input.setAttribute('type', 'hidden');
            correct_input.setAttribute('name', 'some_answer['+task+'][correct]['+answer+']');
            correct_input.setAttribute('id', 'some_answer_'+task+'_'+answer+'_correct');
            correct_input.setAttribute('value', text);
            $('#preview_inputs').find('#some_answer_'+task+'_correct').append(correct_input);

            $('#some_answer_answers_'+task+'_'+answer).attr('checked', true);
            // $('').attr('checked', false);

            console.log(task, answer);
        }

        function some_answer_to_incorrect(task, answer, text){
            console.log(task, answer, text);
            $('#some_answer_'+task+'_'+answer+'_correct').remove();


            let incorrect_input = document.createElement('input');
            incorrect_input.setAttribute('type', 'hidden');
            incorrect_input.setAttribute('name', 'some_answer['+task+'][incorrect]['+answer+']');
            incorrect_input.setAttribute('id', 'some_answer_'+task+'_'+answer+'_incorrect');
            incorrect_input.setAttribute('value', text);
            $('#preview_inputs').find('#some_answer_'+task+'_incorrect').append(incorrect_input);

            $('#some_answer_answers_'+task+'_'+answer).attr('onclick', 'some_answer_to_correct('+task+','+answer+', "'+text+'")');
            $('#some_answer_answers_'+task+'_'+answer).attr('checked', false);
        }
        
        function some_answer_change_question(task){
            if( $.trim($('#some_answer_'+task+'_question_viewed').val().replace(/\s+/g, ' ')) !== $('#some_answer_'+task+'_question_hidden').val()){
                let preview_question_some_answer = $.trim($('#some_answer_'+task+'_question_viewed').val().replace(/\s+/g, ' '));
                $('#some_answer_'+task+'_question_hidden').val(preview_question_some_answer);
                $('#some_answer_'+task+'_question_viewed').attr(preview_question_some_answer);
            }
        } 


        // ОТПРАВКА ФОРМЫ
        function check_test_before_submit(event){
            event.preventDefault();
            $('.errors_absolute_red').remove();

            console.log($('#old_html').length);
            console.log($('#old_timer_html').length);

            
            let old_timer = $('#timer_block').html();
            old_timer = old_timer.trim();
            if($('#old_timer_html').length <= 0){
                save_timer = document.createElement('input');
                save_timer.setAttribute('hidden', true);
                save_timer.setAttribute('name', 'old_timer_html');
                save_timer.setAttribute('id', 'old_timer_html');
                save_timer.setAttribute('value', old_timer);
                $('#preview_inputs').append(save_timer);
            }
            else{
                save_timer = $('#old_timer_html');
                save_timer.val(old_timer);
            }
            // save_timer.setAttribute('value', old_timer);
            // $('#preview_inputs').append(save_timer);



            let preview_inputs_html = $('#preview').html();
            preview_inputs_html = preview_inputs_html.split('<address></address>');
            preview_inputs_html = preview_inputs_html[1].trim();
            if($('#old_html').length <= 0){
                input_html = document.createElement('input');
                input_html.setAttribute('name', 'old_html');
                input_html.setAttribute('id', 'old_html');
                input_html.setAttribute('hidden', true);
                input_html.setAttribute('value', preview_inputs_html);
                $('#preview_inputs').append(input_html);
            }
            else{
                input_html = $('#old_html');
                input_html.val(preview_inputs_html);
            }
            

            $('#preview_inputs').submit();
        }

    </script>
@endsection