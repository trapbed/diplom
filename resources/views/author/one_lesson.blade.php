@extends('author.header')

@section('title', $lesson->title)
@section('content')
<div class="df fdr_c g3">
    <div class="df fdr_c g1_5">
        <span class="fsz_1_5 c_dp">Курс: {{$lesson->course}}</span>
        <span class="fsz_1_2 c_dp">Урок: {{$lesson->title}}</span>
    </div>
    <div class="w78 df fdr_c g1 ff_ml fsz_1">
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
</div>
<?php
    unset($errors);
?>
@endsection