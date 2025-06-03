@if ($has)
                            {{-- in_array($lesson->id, $completed_lessons) --}}
                            <?php 
                                // $compl_less_in_course =  count(array_intersect($arr_less, $completed_lessons)); 
                            ?>
                            {{-- array_search($lesson->id, $arr_less) }}
                            {{ $compl_less_in_course }}


                            {{ array_search($lesson->id, $arr_less) }}

                            @if(array_search($lesson->id, $arr_less) == $compl_less_in_course)
                                11111
                            @elseif(array_search($lesson->id, $arr_less)+1 == $compl_less_in_course)
                                22222
                            @else
                                33333
                            @endif


                            {{ dd(array_intersect($arr_less, $completed_lessons)) --}}
                            




                            {{-- 
                            {{ dd($arr_less, $completed_lessons) }}
                            
                            array_search($lesson->id, $arr_less)+1 }}
                            {{ count($lessons) }}
                            {{ $less_key }}
                            {{ $lesson->id 
                            @if (count($lessons) > array_search($lesson->id, $arr_less)+1)--}}
                                <a href="{{route('one_lesson_student', ['id'=>$lesson->id, 'course'=>$course->id])}}" class="df fdr_r g1 ali_c td_n btn_w_lp w69 paa_1 h1 fsz_1 br_03 brc_lp">
                                    <div id="{{in_array( $lesson->id, $completed_lessons) == 1 ? 'checkmark_lesson_green': 'checkmark_lesson_none'}}">{!!in_array( $lesson->id, $completed_lessons) == 1 ? '&#10003;': ''!!}</div>
                                    <span>{{$lesson->title}}</span>
                                </a>
                            {{-- @else
                                <div class="td_n  w69 paa_1 h1 fsz_1 br_03 brc_lp">{{$lesson->title}}</div>
                            @endif --}
                        --}}  
                        @else
                            <div class="td_n  w69 paa_1 h1 fsz_1 br_03 brc_lp">{{$lesson->title}}</div>
                        @endif