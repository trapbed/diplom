@extends('admin.header')

@section('title', "Редактирование категории '".$cat->title."'")
@section('content')
<div class="df fdr_r w72 jc_spb">
        <div class="df fdr_c g1">
            <div class="df fdr_r g4 ali_c">
                <h4 class="fsz_1_5 ff_ml c_dp ">Редактирование категории &nbsp;'{{$cat->title}}'</h4>
            </div>

            <form class="df fdr_c g1" action="{{route('edit_cat')}}" method="POST">
                @csrf
                <input name="id" type="hidden" value="{{$cat->id}}">
                <div class="df fdr_c g1">
                    <label class="ff_mr fsz_1_2 c_dp" for="title">Заголовок</label>
                    <input class="w35 paa_0_5 br_1 ou_n brc_lp ff_mr fsz_1" name="title" type="text" value="{{$cat->title}}">
                </div>         
                <input class="w10 paa_0_5 btn_dp_lp ou_n br_1 ff_m fsz_1" type="submit" value="Сохранить">
            </form>
        </div>
        
    </div>
@endsection