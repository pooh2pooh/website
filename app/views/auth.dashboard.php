  <link href="/lib/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
%{header}%
<main>
  %{toasts}%
  <div class="progress" style="height: 30px;">
    <div class="progress-bar bg-light" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span class="text-dark fw-bold">25%</span></div>
  </div>
  <div class="container">
    <div class="row">
      <h1 class="h2 text-center my-4">Сегодня 123 <span class="text-success fw-bold">↑</span><br><span class="text-muted small">Всего 456</span></h1>
      %{widget_products}%
    </div>
  </div>
</main>
%{footer}%

<script>
  function delProduct(id) {
      $.ajax({
          type: 'POST',
          cache: false,
          dataType: 'json',
          url: '/auth/dashboard',
          data: { id: id },
          success: function(data) {
              if(data.result === "success") {
                  let node = document.querySelector('#id'+id);
                  node.parentNode.removeChild(node);
                  $('#del_toast_text').html('Удалено! (#'+id+')');
                  $('#delToast').toast('show');
              }
          },
          error: function() {
             console.log('Ошибка! Нельзя удалить');
          }
      }).done();
  }
</script>
<script src="/lib/datatables/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready( function () {
      $('#dataTable').DataTable({
          language: {
              url: '/lib/datatables/Russian.json'
          }
      });
  } );
</script>
</body>