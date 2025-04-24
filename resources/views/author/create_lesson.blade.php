@extends('author.header')

@section('title', "Создание урока  к курсу :'".$course->title."'")
@section('content')
    <span class="ff_mr fsz_2">Создание урока к курсу : '{{$course->title}}'</span>
    <span class="ff_mr fsz_1_2 c_lr">Выбирайте изображения исключительно из <span class="td_u">'img/lessons'</span>, предварительно загрузив их <a href="">в меню->второй раздел.</a></span>
    <span class="ff_mr fsz_1">Уже есть: {{$course->lesson_count}}</span>
    <div class="df fdr_r jc_spb pos_f bg_w b_2 w84  br_03">
        <form class="df fdr_r g1 w50 brc_lp br_03 paa_0_5" enctype="multipart/form-data">
            <div onclick="remove_disabled(event)" class="df ali_c jc_c btn_dp_lp ff_mr fsz_1 w2_5 h2_5 ou_n br_03">+</div>
            <button id="text" class=" ff_mr fsz_1 paa_0_5 ou_n br_03" disabled>Текст</button>
            <button id="img" class=" ff_mr fsz_1 paa_0_5 ou_n br_03" disabled>Изображение</button>
            <input id="img_imitation" name="image" class=" ff_mr fsz_1 paa_0_5 ou_n br_03" type="file" style="display:none">
        </form>

        <button onclick="check_before_submit(event)"  class="btn_dp_lp br_03 paa_0_5 ou_n w_au ff_mr fsz_1">Создать урок</button>

    </div>

    <form id="preview"  class="sc_w_th oy_s h30 df fdr_c g1" action="{{route('create_lesson')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_course" value="{{$course->id}}">
        <label class="fsz_1_2 ff_mr c_dp" for="title">Заголовок урока</label>
        <input id="title_lesson" class="w48 h1 paa_1 ff_mr fsz_1 br_03 brc_lp ou_n" type="text" name="title">
        
    </form>

    <script>
        preview = document.querySelector("#preview");
        all_count = 0;


        function remove_disabled(event){
            // alert('1234');
            event.preventDefault();
            if($("#text").attr('disabled') == undefined){
                $('#text').attr('disabled', true);
                $('#img').attr('disabled', true);

                $('#text').removeAttr('onclick');
                $('#img').removeAttr('onclick');
            }
            else{
                $('#text').removeAttr('disabled');
                $('#img').removeAttr('disabled');

                $('#text').attr('onclick', 'add_text(event)');
                $('#img').attr('onclick', 'add_image(event)');

            }


            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
            // console.log(document.querySelectorAll('textarea', 'input').length);
        }

        let count_1 = 1;
        function add_text(event){
            event.preventDefault();
            $('#text').attr('disabled', true);
            $('#img').attr('disabled', true);
            $('#text').removeAttr('onclick');
            $('#img').removeAttr('onclick');
            let preview = $("#preview");
            let new_text = document.createElement(`div`);
            new_text.classList.add('pos_r', 'w50', 'wmx_50', 'ou_n');
            new_text.innerHTML = `<textarea required name='text[`+all_count+`]' class='input_create'></textarea><div id="minus_elem`+count_1+`" onclick="minus_elem('minus_elem`+count_1+`')" class='pos_a b_3 rm_5 fsz_2 paa_1 bg_dp br_03 c_lp minus_elem'>-</div>`;
            new_text.setAttribute('data-id', $("#minus_elem").length);
            preview.append(new_text);
            count_1++;

            all_count++;
            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
            // console.log(document.querySelectorAll('textarea', 'input').length);
        }

        function add_image(event){
            event.preventDefault();
            $('#text').attr('disabled', true);
            $('#img').attr('disabled', true);
            $('#text').removeAttr('onclick');
            $('#img').removeAttr('onclick');
            $("#img_imitation").click();

            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
            // console.log(document.querySelectorAll('textarea', 'input').length);
        }

  
        
        let count_2 = 1;
        $("#img_imitation").on("change", function(event){
            event.preventDefault();
            // получаем выбранный файл
            let image = event.target.files[0];

            // если изображение
            if(image && image.type.startsWith('image/')){
                // создаем скрытый инпут
                let new_i = document.createElement(`input`);
                new_i.setAttribute('type', 'file');
                new_i.setAttribute('id', 'img_'+count_2);
                new_i.setAttribute('name', 'img['+all_count+']');
                new_i.classList.add('dn', 'img_'+count_2, 'images');
                new_i.value
                $("#preview").append(new_i);
                // создаем объект файл с именем изображения
                let image_2 = new File(['image'], image.name, {
                    type:image.type,
                    webkitRelativePath: image.webkitRelativePath
                });
                console.log(image_2);


                console.log($("#img_imitation").val());

                // создаем объект dataTransfer, заносим в него выбранное изображение, присваиваем инпуту значение из объекта файл
                let fileL = new DataTransfer();
                fileL.items.add(image_2);
                new_i.files = fileL.files;
                console.log(new_i);
                
                // создание изображения, в котором будет превью
                image_preview = document.createElement(`div`);
                image_preview.classList.add('w50', 'pos_r', 'img_'+count_2);
                image_preview.innerHTML = `
                    <img class="img_`+count_2+`">
                    <div id="del_img_`+count_2+`" onclick="minus_img('img_`+count_2+`', this)" class='img_`+count_2+` pos_a t_1 rm_5 fsz_2 paa_1 bg_dp br_03 c_lp minus_elem'>-</div>
                `;
                $("#preview").append(image_preview);



                // // объект чтения файлов (вывод)
                let reader = new FileReader();
                reader.onload = () => image_preview.children[0].setAttribute('src', reader.result);
                reader.readAsDataURL(image);
                console.log(reader);

                // // count_2++;
                
                $("#img_imitation").val('');
                all_count++;
            }
            else{
                alert('Выберите изображение!');
            }
            
            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
        })

        function minus_elem(elem){
            $('#'+elem).parent().remove();

            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
        }
        function minus_img(elem, event){
            file_input = document.getElementById(elem);
            name_img = file_input.files[0].name;

            filter =Array.from(file_input.files).filter(file=>file.name == elem);

            new_transfer =new DataTransfer();

            filter.forEach(file=>new_transfer.items.add(file));

            file_input.files = new_transfer.files;
            $("."+elem).remove();

            // console.log(preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length);
            // console.log(document.querySelectorAll('textarea', 'input').length);
        }

        function check_before_submit(event){
            count_input = preview.querySelectorAll('textarea').length + preview.querySelectorAll('input').length;
            textareas = document.querySelectorAll("textarea");
            let error = false;
            let title_length = $("#title_lesson")[0].value.trim().length;
            
            if(count_input <= 3){
                alert('Добавьте данные в урок!');
            }else if(title_length<6){
                alert('Длина заголовка должна быть не меньше 6-ти символов!');
            }
            else{
                textareas.forEach(ta => {
                    if(ta.value.trim().length<10){
                        error = true;
                        return false;
                    }
                });
                if(error == false){
                    preview.submit();
                }
                else{
                    alert('Длина текстового поля не менее 10 символов!');
                }
            }

        }
    </script>
@endsection