@extends('author.header')

@section('title', $lesson->title)
@section('content')
    {{-- dd($lesson) --}}
    @if ($lesson->type == 'lesson')
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
    @elseif($lesson->type == 'test')
        <div class="df fdr_c g3">
            <div class="df fdr_c g1_5">
                <span class="fsz_1_5 c_dp">Курс: {{$lesson->course}}</span>
                <span class="fsz_1_2 c_dp">Тест: {{$lesson->title}}</span>
            </div>
        </div>
        <div class="w78 df fdr_c g1 ff_ml fsz_1">
            {{-- dd($content) --}}
            @foreach ($content as $key=>$val)
                @switch($key)
                    @case('timer')
                        <div>
                            <span>Таймер: {{ $val }} минут</span>
                        </div>
                    @break
                    @case('content')
                        @foreach($val as $key2=>$val2)
                            <div class="test_task df fdr_c g1">
                                <span>Задание {{ $key2 }}</span>
                                @foreach($val2 as $key3=>$val3)
                                    @switch($key3)
                                        @case('one_answer')
                                            <div id="{{ $key3 }}_{{ $key2 }}" class="df fdr_c g1">
                                                <div class="df fdr_c g0_3">
                                                    <span>Вопрос: </span>
                                                    <span>{{ $val3->question }}</span>
                                                </div>
                                                <div class="df fdr_c g0_5">
                                                    <span>Варианты ответов:</span>
                                                    <div class="df fdr_c g0_3">
                                                        @foreach($val3->answers as $answer)
                                                            <span class="paa_0_3 br_03 {{ $val3->current == $answer ? 'bg_lg' : 'bg_lr' }}">{{ $answer }}</span>
                                                        @endforeach 
                                                    </div>
                                                </div>
                                            </div>

                                                @break
                                        @case('subsequence')
                                            <div id="{{ $key3 }}_{{ $key2 }}"  class="df fdr_c g1">
                                                <div class="df fdr_c g0_3">
                                                    <span>Вопрос: </span>
                                                    <span>{{ $val3->question }}</span>
                                                </div>
                                            </div>
                                            <div class="df fdr_c g0_5">
                                                <span>Правильная последовательность:</span>
                                                <div class="df fdr_c g0_5">
                                                    @foreach($val3->answers as $key_a=>$answer)
                                                        <span class="paa_0_3 br_03 bg_lp">{{ $key_a+1 }}. {{ $answer }}</span>
                                                    @endforeach
                                                </div>
                                               
                                            </div>
                                            
                                                @break
                                        @case('word')
                                            <div id="{{ $key3 }}_{{ $key2 }}" class="df fdr_c g1">
                                                <div class="df fdr_c g0_3">
                                                    <span>Вопрос: </span>
                                                    <span>{{ $val3->question }}</span>
                                                </div>
                                                <div class="df fdr_c g0_3">
                                                    <span>Правильный ответ</span>
                                                    <span class="paa_0_3 br_03 bg_lp">{{ $val3->current }}</span>
                                                </div>
                                            </div>
                                                @break
                                        @case('some_answer')
                                            <div id="{{ $key3 }}_{{ $key2 }}" class="df fdr_c g1">
                                                <div class="df fdr_c g0_3">
                                                    <span>Вопрос: </span>
                                                    <span>{{ $val3->question }}</span>
                                                </div>
                                                <div class="df fdr_c g0_3">
                                                            @foreach($val3->incorrect as $answer)
                                                                <span class="bg_lr paa_0_3 br_03">{{ $answer }}</span>
                                                            @endforeach
                                                        
                                                            @foreach($val3->correct as $answer)
                                                                <span class="bg_lg paa_0_3 br_03">{{ $answer }}</span>
                                                            @endforeach
                                                        
                                                </div>
                                            </div>
                                                @break
                                    @endswitch
                                    <br>
                                @endforeach
                            </div>
                        @endforeach
                    @break
                @endswitch
                {{-- @foreach ($val as $k=>$v)
                    @if($k == 'img')
                        <img class="w50" src="{{asset('img/lessons/'.$v)}}" alt="image_course">
                    
                    @elseif($k=='txt')
                        <div class="w50 paa_0_5 brc_lp br_03">{{$v}}</div>
                    @endif
                    <br>
                @endforeach --}}
            @endforeach
            
        </div>
    @endif

<?php
    unset($errors);
?>
@endsection