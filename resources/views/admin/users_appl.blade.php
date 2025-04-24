@extends('admin/header')

@section('title', 'Пользователи')
@section('content')

<div class="df fdr_r g2">
    <a class="td_n fsz_1_5" href="{{route('main_admin')}}">Пользователи</a>
    {{--<a class="td_n fsz_1_5" href="{{route('users_appl')}}">Заявки</a>--}}
</div>
<?php
    // dd($users);
?>
@if (count($users)>0)
    <div class="w100 h1"></div>
    <table class="table ">
        <thead>
            <tr class="fsz_1">
                <td>Имя</td>
                <td>Старая роль</td>
                <td>Желаемая роль</td>
                <td>Дата</td>
                <td>Статус</td>
                <td>Действия</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <?php
                  
            ?>
            @if(Auth::user()->id !== $user->id)
            <?php
                // $status = $user->blocked == '1' ? 'Заблокирован' : 'Разблокирован';
                // $action = $user->blocked == '1' ? 'Разблокировать' : 'Заблокировать';
                // $color_btn = $user->blocked == '1' ? 'bg_lg' : 'bg_lr';
                // $bg_color_btn = $user->blocked == '1' ? 'c_dg' : 'c_dr';
                // $to = $user->blocked == '1' ? '0' : '1';
                // $arr_role = ['admin', 'student'];
            ?>
                <tr class=" fsz_1 h3 f_w300 ff_mr">
                    <td>{{$user->name}}</td>
                    <td>{{$user->current_status}}</td>
                    <td>{{$user->wish_status}}</td>
                    <td>{{$user->date}}</td>
                    <td>{{$user->status_appl}}</td>
                    @if($user->status_appl == 'Отправлена')
                        <td class="df fdr_r g1"><a class="fsz_1_5" href="{{route('change_role', ['id_user'=>$user->user_id, 'id_appl'=>$user->id, 'role'=>$user->wish_status, 'status_appl'=>'Принята'])}}">{{html_entity_decode('&#10003;')}}</a><a class="fsz_1_5" href="{{route('change_role', ['id_user'=>$user->user_id, 'id_appl'=>$user->id, 'role'=>$user->wish_status, 'status_appl'=>'Отклонена'])}}">{{html_entity_decode('&#x2717;')}}</a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
                @else
                <tr class=" fsz_1 h3 f_w300 ff_mr">
                    <td>{{$user->name}}</td>
                    <td>{{$user->current_status}}</td>
                    <td>{{$user->wish_status}}</td>
                    <td>{{$user->date}}</td>
                    <td>{{$user->status_appl}}</td>
                    @if($user->status_appl == 'Отправлена')
                        <td class="df fdr_r g1"><a class="fsz_1_5" href="{{route('change_role', ['id_user'=>$user->user_id, 'id_appl'=>$user->id, 'role'=>$user->wish_status, 'status_appl'=>'Принята'])}}">{{html_entity_decode('&#10003;')}}</a><a class="fsz_1_5" href="{{route('change_role', ['id_user'=>$user->user_id, 'id_appl'=>$user->id, 'role'=>$user->wish_status, 'status_appl'=>'Отклонена'])}}">{{html_entity_decode('&#x2717;')}}</a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    
    <div class="fsz_1">Пока нет ни одного курса.</div>
    
@endif

@endsection