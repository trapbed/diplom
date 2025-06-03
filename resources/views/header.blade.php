<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script> -->
    <!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> -->
</head>
<body class="">
@error('mess')
<script>alert("{{$message}}");</script>
@enderror

<div id="content">
    <nav id="header_student">
        <div id="left_header_student">
            <a class="left_header_student" href="{{route('main')}}"><img class="w2_5 h2_5" src="{{asset('img/logo.png')}}" alt="LOGO"><span class="fsz_1 ff_m c_dp">Лига знаний</span></a>
            <a class="left_header_student" href="{{route('courses')}}">Все курсы</a>
            @auth
                <!-- <a class="left_header_student" href="{{route('courses')}}">Моя статистка</a> -->

                
            @endauth
            {{--<a class="td_n ff_m c_dp fsz_1" href="{{route('categories_main')}}">Категории</a>--}}
        </div>
        <div id="right_header_student">
            @guest
                <a class="buttons_dp_lp" href="{{route('signup')}}">Зарегистрироваться</a>
                <a class="buttons_dp_lp" href="{{route('login')}}">Войти</a>
            @endguest
            @auth
                <a class="td_n ff_m c_dp fsz_1" href="{{route('my_statistics')}}">Моя статистка</a>
                <a class="td_n ff_m c_dp fsz_1" href="{{route('student_account')}}">{{ Auth::user()->email }}</a>
                <a class="td_n ff_m c_dp fsz_1" href="{{route('logout')}}"><img class="w1_5 h1_5" src="{{asset('img/logout.png')}}" alt=""></a>

            @endauth
        </div>
    </nav>
    <!-- <br><br><br> -->
    <div class="" id="content_student">
    @yield('content')
    </div>
</div>
    <!-- footer -->
    <div id="footer">
        <div class=" df fdr_r jc_spb w72 h8 paa_2 ">
            <div class="df fdr_c g1 w18 ">
                <a class="td_n df fdr_r g1 ali_c h3" href="{{route('main')}}"><img class="w2_5 h2_5" src="{{asset('img/logo.png')}}" alt="LOGO"><span class="fsz_1 ff_m c_dp">Лига знаний</span></a>
                    <a href="" class="df fdr_r ali_c td_n  g1"><img src="{{asset('img/mail.png')}}" alt="" class="w2"><span class="td_n fsz_1 c_dp g1 ff_m">trapbed@mail.ru</span></a>
                    
            {{-- <a href="{{route('main')}}" class="td_n fsz_1 c_dp g1 ff_m">Категории</a>--}}
                
            </div>
            <div class="df fdr_c g1 w18 ">
                <a href="{{route('main')}}" class="td_n fsz_1 c_dp g1 ff_m">Главная</a>
                <a href="{{route('main')}}" class="td_n fsz_1 c_dp g1 ff_m">Все курсы</a>
                <a href="{{route('main')}}" class="td_n fsz_1 c_dp g1 ff_m">Категории</a>
                <a href="{{route('main')}}" class="td_n fsz_1 c_dp g1 ff_m">Контакты</a><!-- Почта(mail, gmail, phone, address, post index)-->
                
            </div>
            <div class="df fdr_c g1 w18 ">
                <span class="fsz_1 c_dp g1 ff_m">Социальные сети</span>
                <div class="w12 df fdr_r g1">
                    <a href="https://t.me/Ioweve" class="td_n img_sh"><img src="{{asset('img/telegram.png')}}" alt="" class="w2"></a>
                    <a href="https://vk.com/trapbed" class="td_n img_sh"><img src="{{asset('img/vk.png')}}" alt="" class="w2"></a>
                    <a href="https://www.figma.com/design/mscDtNunLdbsMpM1C9kxDl/project-manager?node-id=79-1430&m=dev&t=CWGPF7ZAXra0rMlf-1" class="td_n img_sh"><img src="{{asset('img/figma.png')}}" alt="" class="w2"></a>
                </div>
            </div>
            
            
        </div>
    </div>

</body>
</html>