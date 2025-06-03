@extends('author.header')


@section('title','Изображения уроков')
@section('content')
    <form class="df fdr_c g1 c_dp" action="{{route('add_to_dir')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <span class="fsz_1_5">Автор/ Добавление файла в директорию <span class="td_u fsz_1_2">img/...</span></span>
        <label class="df fdr_c g1 fsz_1 c_dp ff_mr" for="directory">
            Выберите для чего фото
            <select class="paa_0_5 ou_n brc_lp br_03 c_dp ff_mr fsz_1" required name="directory">
                <option value="desc_courses">Описание курса</option>
                <option value="lessons">Урок</option>
            </select>
        </label>
        <label for="img" class="ff_mr fsz_1">Выберите один файл</label>
        <input class="ff_mr fsz_1" type="file" name="img">
        <input class="ff_mr fsz_1 paa_0_5 w_au br_03 ou_n btn_lp_dp" type="submit" value="Добавить">
    </form>
@endsection