@extends('author.header')


@section('title','Изображения уроков')
@section('content')
    <form class="df fdr_c g1 c_dp" action="{{route('add_to_dir')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <span>Добавление файла в директорию <span class="td_u">img/lessons</span></span>
        <label class="ff_mr fsz_1_2">Выберите 1 файл</label>
        <input class="ff_mr fsz_1" type="file" name="img">
        <input class="ff_mr fsz_1 paa_0_5 w_au br_03 ou_n btn_lp_dp" type="submit" value="Добавить">
    </form>
@endsection