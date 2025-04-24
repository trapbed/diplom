<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('../css/style.css')}}">
</head>
<body>
    <header id="header_student" class="">
        <div class="df fdr_r jc_spb ali_c w12">
            <img class="w4 h4" src="{{asset('../img/logo.png')}}" alt="logo">
            <span>Лига знаний</span>
        </div>
        <div class="df fdr_r jc_spb w72">
            <div class="als_s df fdr_r g2">
                <a class="td_n hvr" href="">Курсы</a>
                <a class="td_n hvr" href="">Категории</a>
            </div>
            <a class="td_n hvr" href="{{Auth::logout()}}">{{Auth::user()->name}}</a>
        </div>
    </header>
    @yield('content')
</body>
</html>