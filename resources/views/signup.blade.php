<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div id="main_login">
        <div id="div_for_login_form" class="df fdr_c g3  paa_2">
        <!-- Добро пожаловать в мир знаний! -->
            <div class="df g1 fdr_r ali_e"><span class="fsz_1_5">Добро пожаловать в мир знаний</span><img class="w2 h2" src="{{asset('../img/milky_way.png')}}"></div>
            <form class="df fdr_c fsz_1 g1" method="POST" action="{{route('signup')}}">
                @csrf
                <div class="df fdr_r g1 ali_s">
                    <label class="w7" for="name">Имя</label>
                    <input type="text" name="name" class="input_p w16_5 br_1 ou_n fsz_1" value="{{ old('name') }}">
                </div>
                <div class="df fdr_r g1 ali_s">
                    <label class="w7" for="email">Почта</label>
                    <input type="text" name="email" class="input_p w16_5 br_1 ou_n fsz_1" value="{{ old('email') }}">
                </div>
                <div class="df fdr_r g1 ali_s">
                    <label class="w7" for="pass">Пароль</label>
                    <input type="password" name="pass" class="input_p w16_5 br_1 ou_n fsz_1" value="{{ old('pass') }}">
                </div>
                <div class="df fdr_r als_e g1">
                    <a href="{{route('main')}}" class="paa_1 fsz_1 ou_n btn_purple td_n c_b als_e">Вернуться в каталог</a>
                    <input class="paa_1 fsz_1 ou_n btn_purple  als_e" type="submit" value="Зарегистрироваться">
                </div>
                <span class="fsz_0_8 als_c ac_c">Если у вас уже есть аккаунт, <a class="c_dp" href="{{route('login')}}">войдите</a>!</span>
            </form>
        </div>
    </div>
@if ($errors->any())
    <div class="errors_absolute">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- <php
    echo($errors);
?> -->

</body>
</html>