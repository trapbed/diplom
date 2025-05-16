<!DOCTYPE html>
<html>
<head>
    <script src="{{ asset('js/html2pdf.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
  <div id="content">
    <h1>Заголовок</h1>
    <p>Этот текст будет в PDF!</p>
  </div>
  <button onclick="generatePDF()">Скачать PDF</button>

  <script>
    function generatePDF() {
      const element = document.getElementById('content');
      html2pdf().from(element).save('document.pdf');

    //   html2pdf()
    //     .from(element)
    //     .set({
    //         // Настройки html2canvas
    //         html2canvas: {
    //         scale: 2,          // Увеличивает качество (2 = 2x DPI)
    //         logging: false,    // Отключает логи
    //         useCORS: true,     // Разрешает кросс-доменные изображения
    //         },

    //         // Настройки jsPDF
    //         jsPDF: {
    //         unit: 'mm',        // Единицы измерения (mm, pt, in)
    //         format: 'a4',      // Формат страницы (a4, letter, etc.)
    //         orientation: 'portrait', // или 'landscape'
    //         },

    //         // Доп. настройки
    //         margin: 10,          // Отступы (число или массив [top, right, bottom, left])
    //         filename: 'file.pdf', // Имя файла
    //         pagebreak: { mode: 'avoid-all' }, // Управление разрывами страниц
    //     })
    //     .save();
    }
  </script>
</body>
</html>
    