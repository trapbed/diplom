@extends('author.header')

@section('title', 'Прогресс')
@section('content')
    <div class=" df fdr_r ali_s g2 bg_w w87_5 h4 jc_s">
        <div class="df fdr_r g4 ali_c">
            <h4 class="fsz_1_5 ff_ml c_dp">Статистика по тестам</h4>
        </div>
    </div>

    <div class="df fdr_c bg_lp w87_5 h4">
        <table id="progress_table">
            <tr>
                <th>id</th>
                <th>Курс</th>
                <th>Тест</th>
                <th>Прошедших</th>
                <th>Смотреть</th>
            </tr>
            @foreach ($tests as $test)
                <tr>
                    <td>{{$test->id}}</td>
                    <td>{{$test->course}}</td>
                    <td>{{$test->test}}</td>
                    <td>{{$test->dones}}</td>
                    <td><a href="">Статистика</a></td>
                </tr>
            @endforeach
                
        </table>
    </div>
@endsection