@extends('author.header')

@section('title', 'Создание курса')
@section('content')


<div id="bg_modal_desc">

</div>

<div id="bg_modal">
    <div id="choose_type_content_course">
        <div id="scroll_types">
            
            <span class="ff_mr c_dp fsz_1_5 bg_lp paa_0_5 pos_f w74">Выберите тип блока</span>
            <div onclick="close_choose_types()" class="close_christ">
                Х
            </div>

            <div class="type_list_block mt_4">
                <p class="title_type_course">Название блока</p>
                <span class="desc_text_d_mr_1_2">Описание списка</span>
                <div class="type_list_list">
                    <div class="type_list_point">
                        <div class="type_list_num">&#9733;</div>
                        <span>Пункт №1</span>
                    </div>
                    <div class="type_list_point">
                        <div class="type_list_num">&#9733;</div>
                        <span>Пункт №2</span>
                    </div>
                    <div class="type_list_point">
                        <div class="type_list_num">&#9733;</div>
                        <span>Пункт №3</span>
                    </div>
                </div>

                <div class="bg_add_button_blocK_course">
                    <div onclick="choose_type_course('list')" class="add_button_blocK_course">Добавить</div>
                </div>
            </div>
            <span class="note_type_course">
                Количество пунктов может меняться.
            </span>


            <div class="type_l_text_r_img">
                <div class="in_type_l_text_r_img">
                    <div class="title_content_l_text_r_img">
                        <p class="title_type_course">Название блока</p>
                        <span class="content_type_text_img">Здесь должен быть текст соответствующий блоку текст, справа от теста должна содержаться картинка которая отображает содержащийся здесь текст. Но текста должно быть больше, учтите это... Текста должно быть больше... Текста больше... Больше текста.. Должно быть... Текста... Больше</span>
                    </div>
                    <img class="w17" src="{{ asset('img/icons/img.png') }}" alt="">
                </div>
                
                <div class="bg_add_button_blocK_course">
                    <div onclick="choose_type_course('text_img')"  class="add_button_blocK_course">Добавить</div>
                </div>
            </div>
            <span class="note_type_course">
                    Текст и изображение можно поменять местами.
            </span>


            <div class="type_four_blocks">
                <p class="title_type_course">Название блока</p>
                <div class="type_four_blocks_wrap">
                    <div class="one_of_four_blocks">
                        <img class="h6" src="{{ asset('img/icons/img.png') }}" alt="img">
                        <span class="text_center_reg_dp_1">Здесь должен быть текст соответствующий изображению</span>
                    </div>
                    <div class="one_of_four_blocks">
                        <img class="h6" src="{{ asset('img/icons/img.png') }}" alt="img">
                        <span class="text_center_reg_dp_1">Здесь должен быть текст соответствующий изображению</span>
                    </div>
                </div>

                <div class="bg_add_button_blocK_course">
                    <div onclick="choose_type_course('four_blocks')"  class="add_button_blocK_course">Добавить</div>
                </div>
            </div>
            <span class="note_type_course">
                * Количество блоков может быть от 2 до 6 с шагом 2.
            </span>
            
            
            

            <div class="type_three_blocks">
                <p class="title_type_course">Здесь должно быть название для содержимого в три блока</p>
                <div class="in_row_block">
                    <div class="row_course_blocks">
                        <img class="w8" src="{{ asset('img/icons/img.png') }}" alt="">
                        <p class="p_text_m_1">Название подзаголовка #1</p>
                        <span class="text_center_reg_dp_1">Распишите что содержит в себе этот пункт подробнее, что бы пользователь понял, что стоит выбрать вас</span>
                    </div>
                    <div class="row_course_blocks">
                        <img class="w8" src="{{ asset('img/icons/img.png') }}" alt="">
                        <p class="ff_m fsz_1">Название подзаголовка #2</p>
                        <span class="text_center_reg_dp_1">Распишите что содержит в себе этот пункт подробнее, что бы пользователь понял, что стоит выбрать вас</span>
                    </div>
                    <div class="row_course_blocks">
                        <img class="w8" src="{{ asset('img/icons/img.png') }}" alt="">
                        <p class="p_text_m_1">Название подзаголовка #3</p>
                        <span class="text_center_reg_dp_1">Распишите что содержит в себе этот пункт подробнее, что бы пользователь понял, что стоит выбрать вас</span>
                    </div>
                </div>

                <div class="bg_add_button_blocK_course">
                    <div onclick="choose_type_course('three_blocks')"  class="add_button_blocK_course">Добавить</div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="df fdr_r w72 jc_spb">
        <div class="df fdr_c g1">
            <div class="df fdr_r g4 ali_c">
                <h4 class="fsz_1_5 ff_ml c_dp ">Создание курса</h4>
            </div>

            <form id="form_create_course" class="df fdr_c g1" action="{{route('create_course')}}" method="POST" enctype= "multipart/form-data">
                @csrf
                <div class="df fdr_c g1">
                    <div class="ff_mr fsz_1 c_dp" for="title">Заголовок</div>
                    <input class="w35 form_inputs" name="title" type="text" value="{{old('title') ? old('title') : ''}}">
                </div>


                <div class="df fdr_c g1">
                    <div class="ff_mr fsz_1 c_dp" for="category">Категория</div>
                    <select class="w35 form_inputs" name="category">
                        @foreach ($categories as $category)
                            @if($category->id == old('category'))
                                <option selected value="{{$category->id}}">{{$category->title}}</option>
                            @else
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="df fdr_c g1">
                    <div class="ff_mr fsz_1 c_dp" for="description">Описание</div>
                    <textarea class="mx_w_34 mn_w_34 mx_h10 mn_h_4 form_inputs" name="description">{{old('description') ? old('description') : ''}}</textarea>
                </div>

                <div class="df fdr_c g1">
                    <div class="ff_mr fsz_1 c_dp" for="image">Изображение</div>
                    <input class="w35 paa_0_5 br_03 ou_n brc_lp fsz_0_8" name="image" type="file" value="">
                </div>

                <h3 id="name_new_blocks" class="ff_ml fsz_1_2 c_dp">Дополнительные блоки</h3>
                <div id="new_blocks">
                        @if (old('old_new_blocks'))
                            {!! old('old_new_blocks') !!}
                        @endif

                </div>
                

                <div class="df fdr_r w80 jc_e g4">
                    <div onclick="see_choose_type()" class="add_block_course" title="Добавить дополнительный блок">
                        Добавить блок
                    </div>

                    <input class="add_block_course ou_n" type="submit" value="Сохранить">
                </div>
            </form>
        </div>
        
    </div>

    <div id="errors_messages" class="errors_absolute t_2">
        <ul>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            @endif
        </ul>
    </div>


    <script>
        $('#form_create_course').on('submit',function(){
            event.preventDefault();
            check_all_images = $('.all_images');
            check_all_images.each(function(index, elem){
                console.log(index);
                console.log(elem);
                if(elem.value != null){
                    $($('.all_images')[index]).next().after("<div class='paa_1 bg_lr c_red br_03'>Выберите изображение</div>");
                    console.log('no');
                }else{
                    console.log('yes');
                }
            });
            
            console.log(check_all_images);
            event.preventDefault();
            if($('#old_new_blocks').length == 0){
                let old_new_blocks = document.createElement('input');
                old_new_blocks.setAttribute('name', 'old_new_blocks');
                old_new_blocks.setAttribute('id', 'old_new_blocks');
                old_new_blocks.setAttribute('hidden', true);
                old_new_blocks.setAttribute('value', $('#new_blocks').html());
                $('#form_create_course').append(old_new_blocks);
                // console.log($('#new_blocks').html());
            }else{
                $('#form_create_course').val($('#new_blocks').outerHTML);
            }
            
            this.submit();
        });

        $(function() {
            setTimeout(function() {
                $('#errors_messages').animate({
                opacity: 0,
                height: 0,
                padding: 0
                }, 500, function() {
                $(this).hide(); // полностью скрыть после анимации
                });
            }, 30000);

            
        });

        function see_choose_type(){
            $('#bg_modal').css('display', 'flex');
        }
        function close_choose_types(){
            $('#bg_modal').css('display', 'none');
        }
        function choose_type_course(type){
            let count_types = document.getElementsByClassName('type_course');
            if(count_types == null ){
                count_types = 1;
            }else{
                count_types = count_types.length+1;
            }
            switch(type){
                case 'list':
                    let list = document.createElement('div');
                    list.classList.add('type_list_block', 'brc_lp', 'type_course', 'pos_r');
                    list.setAttribute('id','type_course_'+count_types);
                    list.innerHTML = `
                        <div class="df fdr_c g0_5 c_dp fsz_1_2">
                            Заголовок блока
                            <input onchange="set_val(this)" oninput="set_val(this)" required class="form_inputs" type="text" name="type[`+count_types+`][list][title]">
                        </div>

                        <div class="plus_div" onclick="add_list_list(`+count_types+`)">+</div>
                        <div id="list_list_`+count_types+`" class="df fdr_c g0_5">
                            <div class="type_list_point pos_r" id="list_`+count_types+`_point_1">
                                <div class="type_list_num fsz_1_5">&#9733;</div>
                                <input onchange="set_val(this)" oninput="set_val(this)" required name="type[`+count_types+`][list][points][1]" class="form_inputs w54" type="text" placeholder="Введите свой текст">

                                <div onclick="del_list_list(`+count_types+`, 1)" class="plus_div rm_2 pos_a">-</div>
                            </div>
                        </div>

                        <div onclick="del_type(`+count_types+`)" class="plus_div rm_3 pos_a t_0">-</div>

                    `;
                    $('#new_blocks').append(list);
                    break;
                case 'four_blocks':
                    let four_blocks = document.createElement('div');
                    four_blocks.classList.add('type_list_block', 'brc_lp', 'type_course', 'pos_r', 'type_four_blocks');
                    four_blocks.setAttribute('id','type_course_'+count_types);
                    four_blocks.innerHTML = `
                        <div class="df fdr_c g0_5 c_dp fsz_1_2">
                            Заголовок блока
                            <input onchange="set_val(this)" oninput="set_val(this)" class="form_inputs" type="text" name="type[`+count_types+`][four_blocks][title]">
                        </div>
                        <div class="type_four_blocks_wrap">
                            <div class="one_of_four_blocks">
                                <div id="type_four_blocks_img_`+count_types+`_1" class="df fdr_c g0_5 ali_c">
                                    <input class="all_images" id="hidden_four_blocks_img_`+count_types+`_1" type="hidden" name="type[`+count_types+`][four_blocks][1][img]" value="">
                                    <img id="type_four_blocks_`+count_types+`_1" class="h6" src="{{ asset('img/icons/img.png') }}" alt="img">
                                    <button onclick="see_all_desc_courses_four_blocks(`+count_types+`, 1)" class="w8 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
                                </div>
                                <textarea placeholder="Здесь дожен быть текст, описывающий изображение" class="mn_h_2 mx_h10 w20 wmx_20 wmn_20 form_inputs" name="type[`+count_types+`][four_blocks][1][text]"></textarea>
                            </div>
                            <div class="one_of_four_blocks">
                                 <div id="type_four_blocks_img_`+count_types+`_2" class="df fdr_c g0_5 ali_c">
                                    <input class="all_images" id="hidden_four_blocks_img_`+count_types+`_2" type="hidden" name="type[`+count_types+`][four_blocks][2][img]" value="">
                                    <img id="type_four_blocks_`+count_types+`_2" class="h6" src="{{ asset('img/icons/img.png') }}" alt="img">
                                    <button onclick="see_all_desc_courses_four_blocks(`+count_types+`, 2)" class="w8 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
                                </div>
                                <textarea placeholder="Здесь дожен быть текст, описывающий изображение" class="mn_h_2 mx_h10 w20 wmx_20 wmn_20 form_inputs" name="type[`+count_types+`][four_blocks][2][text]" id=""></textarea>
                            </div>
                        </div>

                        <div onclick="del_type(`+count_types+`)" class="plus_div rm_3 pos_a t_0">-</div>
                        `;
                        $('#new_blocks').append(four_blocks);
                    break;
                case 'text_img':
                    let text_img = document.createElement('div');
                    text_img.classList.add('type_list_block', 'brc_lp', 'type_course', 'pos_r', 'type_l_text_r_img', 'pos_r');
                    text_img.setAttribute('id','type_course_'+count_types);
                    text_img.innerHTML = `
                        <div class="in_type_l_text_r_img">
                            <div class="title_content_l_text_r_img">
                                <div class="df fdr_c g0_5 fsz_1_2 c_dp">
                                    Заголовок блока
                                    <input onchange="set_val(this)" oninput="set_val(this)" required class="form_inputs" type="text" name="type[`+count_types+`][text_img][title]">
                                </div>
                                <div class="df fdr_c g0_5 c_dp">
                                    Описание блока
                                    <textarea required class="w30 form_inputs" name="type[`+count_types+`][text_img][desc]" placeholder="Введите описание блока" rows="10" ></textarea>
                                </div>
                            </div>
                            <div class="df fdr_c g1 ali_e" id="type_text_img_`+count_types+`">
                                <input class="all_images" required type="hidden" name="type[`+count_types+`][text_img][img]">
                                <img class="w24" id="text_img_image_`+count_types+`" src="{{ asset('img/icons/img.png') }}" alt="img_course_`+count_types+`">
                                <button onclick="see_all_desc_courses(`+count_types+`)" class="w10 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03 ">Изменить</button>
                            </div>
                        </div>
                        <div onclick="del_type(`+count_types+`)" class="plus_div rm_3 pos_a t_0">-</div>

                    `;

                    $('#new_blocks').append(text_img);
                    break;
                case 'three_blocks':
                    let three_blocks = document.createElement('div');
                    // three_blocks.classList.add('');
                    three_blocks.classList.add('type_list_block', 'brc_lp', 'type_course', 'pos_r', 'type_three_blocks');
                    three_blocks.setAttribute('id', 'type_course_'+count_types);
                    blocks_three_blocks = ``;
                    for(let i=1; i<=3; i++){
                        blocks_three_blocks = blocks_three_blocks+`
                            <div class="row_course_blocks">
                                <div id="type_three_blocks_images_`+count_types+`_`+i+`" class="df fdr_c g0_5">
                                    <input class="all_images" required id="hidden_three_blocks_img_`+count_types+`_`+i+`" type="hidden" name="type[`+count_types+`][three_blocks][`+i+`][img]">
                                    <img id="three_blocks_img_`+count_types+`_`+i+`" class="w8" src="{{ asset('img/icons/img.png') }}" alt="img">
                                    <button onclick="see_all_desc_courses_three_blocks(`+count_types+`, `+i+`)" class="w8 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
                                </div>
                                
                                <div>
                                    Название блока
                                    <input onchange="set_val(this)" oninput="set_val(this)" required id="three_blocks_title`+count_types+`_`+i+`" class="three_blocks_title form_inputs" type="text" name="type[`+count_types+`][three_blocks][`+i+`][title]" value="" placeholder="Введите название">
                                </div>
                                <div>
                                    Описание блока
                                    <textarea required placeholder="Здесь дожен быть текст, описывающий изображение" class="one_of_three_blocks_text form_inputs" name="type[`+count_types+`][three_blocks][`+i+`][text]" id="three_blocks_`+count_types+`_text_`+i+`"></textarea>
                                </div>
                            </div>
                        `;
                    }

                    three_blocks.innerHTML = `
                        <div class="df fdr_c g0_5 fsz_1_2 c_dp">
                            Заголовок блока
                            <input onchange="set_val(this)" oninput="set_val(this)" required class="form_inputs" type="text" name="type[`+count_types+`][three_blocks][title]">
                        </div>
                        <div class="in_row_block">
                            `+blocks_three_blocks+`
                        </div>

                        <div onclick="del_type(`+count_types+`)" class="plus_div rm_3 pos_a t_0">-</div>
                        `;
                    $('#new_blocks').append(three_blocks);
                    break;
            }
            
            $('#bg_modal').css('display', 'none');
        }

        function add_list_list(id){
            count_child = $('#list_list_'+id).children().length+1;
            console.log(count_child);
            let point = document.createElement('div');
            point.classList.add('type_list_point', 'pos_r');
            point.setAttribute('id','list_'+id+'_point_'+(count_child));
            point.innerHTML = `
                    <div class="type_list_num fsz_1_5">&#9733;</div>
                    <input onchange="set_val(this)" oninput="set_val(this)" required name="type[`+id+`][list][points][`+count_child+`]" class="form_inputs w54" type="text" placeholder="Введите свой текст">
                    <div onclick="del_list_list(`+id+`, `+count_child+`)" class="plus_div rm_2 pos_a">-</div> `;
            $('#list_list_'+id).append(point);
            alert(count_child);
        }

        function del_list_list(types, childrens){
            $('#list_'+types+'_point_'+childrens).remove();
        }

        function del_type(id){
            $('#type_course_'+id).remove();
        }


        function set_val(elem){
            elem.setAttribute('value',elem.value);
        }

        function see_all_desc_courses(id){
            event.preventDefault();
            let all_img = document.createElement('div');
            all_img.setAttribute('id', 'images_desc_course');
            all_img.innerHTML =`
                    <span class="als_s h3 ff_mr fsz_1_5 c_dp">Выберите фото: </span>
                    <div id="wrapped_desc_course_choose">
                        @foreach ($desc_img as $img)
                            <div class="frame_for_desc_img">
                                <img onclick="choose_img_desc('{{ $img->name }}','{{asset( 'img/desc_courses/'.$img->name) }}', `+id+`)" class="image_desc_course_choose" src="{{ asset( 'img/desc_courses/'.$img->name ) }}" alt="">
                            </div>
                        @endforeach
                    </div>`;
            
            $('#bg_modal_desc').css('display', 'flex');
            $('#bg_modal_desc').append(all_img);
        }

        function see_all_desc_courses_four_blocks(id, child){
            event.preventDefault();
            let all_img = document.createElement('div');
            all_img.setAttribute('id', 'images_desc_course');
            all_img.innerHTML =`
                    <span class="als_s h3 ff_mr fsz_1_5 c_dp">Выберите фото: </span>
                    <div id="wrapped_desc_course_choose">
                        @foreach ($desc_img as $img)
                            <div class="frame_for_desc_img">
                                <img onclick="choose_img_desc_four_blocks('{{ $img->name }}','{{ asset('img/desc_courses/'.$img->name) }}', `+id+`, `+child+`)" class="image_desc_course_choose" src="{{ asset( 'img/desc_courses/'.$img->name ) }}" alt="">
                            </div>
                        @endforeach
                    </div>`;
            
            $('#bg_modal_desc').css('display', 'flex');
            $('#bg_modal_desc').append(all_img);
        }

        function choose_img_desc(img_name, img, id){
            console.log(img,id);
            
            $('#type_text_img_'+id).html(`
                <input onchange="set_val(this)" oninput="set_val(this)" class="form_inputs" type="hidden" name="type[`+id+`][text_img][img]" value="`+img_name+`">
                <img class="h24" id="text_img_image_`+id+`" src="`+img+`" alt="img_course_`+id+`">
                <button onclick="see_all_desc_courses(`+id+`)" class="w10 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
            `);
            $('#images_desc_course').remove();
            $('#bg_modal_desc').css('display', 'none');
        }

        function choose_img_desc_four_blocks(img_name ,img, id, child){
            $('#type_four_blocks_img_'+id+'_'+child).html(`
                    <input onchange="set_val(this)" oninput="set_val(this)" id="hidden_four_blocks_img_`+id+`_`+child+`" type="hidden" name="type[`+id+`][four_blocks][`+child+`][img]" value="`+img_name+`">
                    <img id="type_four_blocks_`+id+`_`+child+`" class="h6" src="`+img+`" alt="img">
                    <button onclick="see_all_desc_courses_four_blocks(`+id+`, `+child+`)" class="w8 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
            `);
            $('#images_desc_course').remove();
            $('#bg_modal_desc').css('display', 'none');
        }

        function see_all_desc_courses_three_blocks(id, child){
            event.preventDefault();
            let all_img = document.createElement('div');
            all_img.setAttribute('id', 'images_desc_course');
            all_img.innerHTML =`
                    <span class="als_s h3 ff_mr fsz_1_5 c_dp">Выберите фото: </span>
                    <div id="wrapped_desc_course_choose">
                        @foreach ($desc_img as $img)
                            <div class="frame_for_desc_img">
                                <img onclick="choose_img_desc_three_blocks('{{ $img->name }}' ,'{{asset( 'img/desc_courses/'.$img->name )}}', `+id+`, `+child+`)" class="image_desc_course_choose" src="{{ asset( 'img/desc_courses/'.$img->name ) }}" alt="">
                            </div>
                        @endforeach
                    </div>`;
            
            $('#bg_modal_desc').css('display', 'flex');
            $('#bg_modal_desc').append(all_img);
        }
        function choose_img_desc_three_blocks(img_name, img, id, child){
            $('#type_three_blocks_images_'+id+'_'+child).html(`
                    <input class="from_inputs" onchange="set_val(this)" oninput="set_val(this)" id="hidden_three_blocks_img_`+id+`_`+child+`" type="hidden" value="`+img_name+`" name="type[`+id+`][three_blocks][`+child+`][img]">
                    <img id="three_blocks_img_`+id+`_`+child+`" class="w8" src="`+img+`" alt="img">
                    <button onclick="see_all_desc_courses_three_blocks(`+id+`, `+child+`)" class="w8 paa_0_5 bg_lp c_dp ff_mr fsz_0_8 ou_n brc_lp br_03">Изменить</button>
            `);
            $('#images_desc_course').remove();
            $('#bg_modal_desc').css('display', 'none');
        }
    </script>
@endsection