@extends('author.header')

@section('title', 'Создание курса')
@section('content')


    <div class="df fdr_r w72 jc_spb">
        <div class="df fdr_c g1">
            <div class="df fdr_r g4 ali_c">
                <h4 class="fsz_1_5 ff_ml c_dp ">Создание курса</h4>
            </div>

            <form class="df fdr_c g1" action="{{route('create_course')}}" method="POST" enctype= "multipart/form-data">
                @csrf
                <div class="df fdr_c g1">
                    <label class="ff_mr fsz_1_2 c_dp" for="title">Заголовок</label>
                    <input class="w35 paa_0_5 br_1 ou_n brc_lp fsz_1" name="title" type="text" value="{{old('title') ? old('title') : ''}}">
                </div>

                <div class="df fdr_c g1">
                    <label class="ff_mr fsz_1_2 c_dp" for="category">Категория</label>
                    <select class="w35 paa_0_5 br_1 ou_n brc_lp fsz_1" name="category">
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
                    <label class="ff_mr fsz_1_2 c_dp" for="description">Описание</label>
                    <textarea class="paa_0_5 mx_w_34 mn_w_34 mx_h10 mn_h_4 fsz_1 br_03 ou_n brc_lp" name="description">{{old('description') ? old('description') : ''}}</textarea>
                </div>
                <div class="df fdr_c g1">
                    <label class="ff_mr fsz_1_2 c_dp" for="image">Изображение</label>
                    <input class="w35 paa_0_5 br_1 ou_n brc_lp fsz_1" name="image" type="file" value="">
                </div>
                <input class="w10 paa_0_5 btn_dp_lp ou_n br_1 ff_m fsz_1" type="submit" value="Сохранить">
            </form>
        </div>
        
    </div>


@endsection