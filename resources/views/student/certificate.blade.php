<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сертификат {{ $course->title }}</title>
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="df fdr_c ali_c">
    <div id="certificate_one_course" class="df fdr_c  ali_c">
        <div id="certificate_line_logo" class="df fdr_r g1">
            <img class="h3 ptb_1" src="{{ asset('img/logo.png') }}" alt="">
            <span class="ff_m fsz_1_2 ptb_2 c_dp">Лига знаний</span>
        </div>
        <div class="h1_5 w20"></div>
        <div id="certificate_main_content">
            <span class="fsz_1_2 w30 ta_c">Настоящий сертификат подтверждает, что</span>
            <span class="c_dp fsz_1_5 ta_c w45">{{ Auth::user()->name }}</span>
            <span class="fsz_1_2 ta_c">завершил(-а) изучение курса</span>
            <span class="c_dp fsz_5">{{ $course->title }}</span>
        </div>
        <div class="h10 w20"></div>
        <div class="df fdr_c ali_c g0_3 h4 als_e w24">
            <?php
                switch (date("m")){
                        case 1:
                            $month= "Январь";
                            break;
                        case 2:
                            $month= "Февраль";
                            break;
                        case 3:
                            $month= "Март";
                            break;
                        case 4:
                            $month= "Апрель";
                            break;
                        case 5:
                            $month= "Май";
                            break;
                        case 6:
                            $month= "Июнь";
                            break;
                        case 7:
                            $month= "Июль";
                            break;
                        case 8:
                            $month= "Август";
                            break;
                        case 9:
                            $month= "Сентябрь";
                            break;
                        case 10:
                            $month= "Октябрь";
                            break;
                        case 11:
                            $month= "Ноябрь";
                            break;
                        case 12:
                            $month= "Декабрь";
                            break;
                        }
            ?>
            <span class="ff_mr fsz_1_2 ">{{ date('d  '.$month.'  Y') }}</span>
            <hr id="certificate_date_ht">
            <span class="ff_mr fsz_1_2">дата</span>
        </div>
    </div>

    <div class="df fdr_r ali_c w80 h7 jc_spb ">
        <a class="td_n" id="get_certificate_btn" href="{{route('one_course_main', $course->id)}}">Назад</a>
        <button onclick="generatePDF()" id="get_certificate_btn">Сохранить</button>
    </div>
    <script>
         function generatePDF() {
            
            const element = document.getElementById('certificate_one_course');
            var opt = {
                margin: 0,
                filename:     'certificate_{{ $course->title }}.pdf',
                image:        { type: 'jpeg', quality: 1},
                html2canvas:  { scale: 2  },
                jsPDF:        { unit: 'mm', format: 'legal', orientation: 'landscape' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
</body>
</html>