@extends('admin/header')

@section('title', 'Пользователи')
@section('content')

<div class="df fdr_r g2">
    <a class="td_n fsz_1_5" href="{{route('main_admin')}}">Пользователи</a>
    {{--<a class="td_n fsz_1" href="{{route('users_appl')}}">Заявки</a>--}}
</div>


@if (count($users)>0)
    <div class="w100 h1"></div>
    <table class="table ">
        <thead>
            <tr class="fsz_1">
                <td>Имя</td>
                <td>Почта</td>
                <td>Роль</td>
                <td>Статус</td>
                <td>Действия</td>
                <!-- <td>Действия</td> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <?php
                  
            ?>
            @if(Auth::user()->id !== $user->id)
            <?php
                $status = $user->blocked == '1' ? 'Заблокирован' : 'Разблокирован';
                $action = $user->blocked == '1' ? 'Разблокировать' : 'Заблокировать';
                $color_btn = $user->blocked == '1' ? 'bg_lg' : 'bg_lr';
                $bg_color_btn = $user->blocked == '1' ? 'c_dg' : 'c_dr';
                $to = $user->blocked == '1' ? '0' : '1';
                $arr_role = ['admin', 'student'];
            ?>
                <tr class=" fsz_1 h3 f_w300 ff_mr">
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$status}}</td>
                    <td><a class="fsz_0_8 br_03 ff_mr  td_n paa_0_3 {{$color_btn}} {{$bg_color_btn}}" href="{{route('change_blocked',['id_user'=> $user->id, 'blocked'=>$to])}}">{{$action}}</a></td>
                </tr>
                @else
                <tr class=" fsz_1 h3 f_w300 ff_mr">
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$status}}</td>
                    <td></td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    
    <div class="fsz_1">Пока нет ни одного курса.</div>
    
@endif

@endsection