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
    <div id="certificate_one_course" class="df fdr_c pos_r ali_c">
       
        <div id="certificate_user">{{ Auth::user()->name }}</div>

        <div id="certificate_course">{{ $course->title }}</div>
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
            <span id="certificate_date">{{ date('d  '.$month.'  Y') }}</span>
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
                html2canvas:  { scale: 3 },
                jsPDF:        { format: 'A5', orientation: 'landscape' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
</body>
</html>