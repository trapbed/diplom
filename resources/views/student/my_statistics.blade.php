@extends('header')

@section('title', 'Моя статистка')
@section('content')
    <div class="h6 w98"></div>
    <div id="content_chart">
        <p class="ff_mr fsz_1_5 c_dp">Статистика</p>

        <div id="all_charts">

            <div class="w30 h30 df fdr_c g1 ali_c">
                <p class="ff_mr fsz_1_2 c_dp">Статистика по результатам тестов</p>
                <canvas id="pie_chart_grade" style="width:20vmax;height:20vmax;">

                </canvas>
            </div>

            <div class="w30 h30 df fdr_c g1 ali_c">
                <p class="ff_mr fsz_1_2 c_dp">Статистика по прогрессу</p>
                <canvas id="pie_chart_progress" style="width:20vmax;height:20vmax;">

                </canvas>
            </div>
            
        </div>
    </div>

    <?php
      $all_courses = $courses->all_courses!=null ? count(json_decode($courses->all_courses)->courses) : 0;
      $compl_courses = $courses->completed_courses != null ? count(json_decode($courses->completed_courses)->courses) : 0;
      $uncompl_courses = $all_courses-$compl_courses;        
    ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx_1 = document.getElementById('pie_chart_grade');

  let pie_data_1 = [];
  let pie_less_1 = [];
  @foreach ($grades as $grade)
      pie_data_1.push('Пройдено на оценку {{ $grade->grade }}');
      pie_less_1.push({{ $grade->count }});
  @endforeach

  @if ($compl_courses != 0)
    new Chart(ctx_1, {
      type: 'pie',
      data: {
        labels: pie_data_1,
        datasets: [{
          label: 'Количество оценок',
          data: pie_less_1,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    @else
      let no_stat = document.createElement('span');
      no_stat.classList.add('ff_mr', 'fsz_1', 'c_dp', 'als_s', 'paa_0_3', 'bg_lp', 'br_03');
      no_stat.innerText = 'Вы не прошли ни одного курса!';
      $('#pie_chart_grade').before(no_stat);
    @endif
  

  const ctx_2 = document.getElementById('pie_chart_progress');

  let pie_data_2 = [];
  let pie_less_2 = [];
  
  

  new Chart(ctx_2, {
    type: 'bar',
    data: {
      labels: ['Пройдено курсов', 'В процессе'],
      datasets: [{
        label: 'Прогресс по курсам',
        data: [{{ $compl_courses}},{{ $uncompl_courses}}],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  </script>
@endsection