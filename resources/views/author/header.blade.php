<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> -->
</head>
<body class="pos_r">
    <?php
        // dd($mess);
    ?>
    @if(isset($mess))
        <div class="errors_absolute">
            <ul>
                <li>{{ htmlspecialchars_decode($mess )}}</li>
            </ul>
        </div>
    @endif 

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>alert("{{$error}}");</script>
        @endforeach
    @endif

    <div class="container_my df fdr_r ali_c g3 pos_f">
        <div class="df fdr_c ali_c g3 admin_navbar pos_r">

            <div>
                <img title="Главная" class="w2_5" src="{{asset('img/logo.png')}}">
            </div>
    

            <div class="df fdr_c ali_c g1_5">
                <a title="Курсы" href="{{route('main_author')}}"><img class="w2 h1" src="{{asset('img/courses.png')}}"></a>
                <a title="Картинки для уроков" href="{{route('get_images_lesson')}}"><img class="w2 h1" src="{{asset('img/img.png')}}"></a>
                <a title="Заявки доступа" href="{{route('application_courses')}}"><img class="w2 h1" src="{{asset('img/access.png')}}"></a>
            </div>

            <div class="df fdr_c pos_a b_1 g2">
                <a href="{{route('student_account')}}"><img class="w1_5" src="{{asset('img/users.png')}}" alt="Аккаунт"></a>
                <a title="Выйти" href="{{route('logout')}}"><img class="w1_5 h1_5" src="{{asset('img/logout.png')}}" alt="logout"></a>
            </div>
    

        </div>
        
        <div class="admin_content df fdr_c g1 ff_m oy_s sc_w_th">
            @yield('content')
        </div>
    </div>
    <?php
        unset($errors);
    ?>
</body>
</html>