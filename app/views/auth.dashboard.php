    <link href="/lib/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
  %{header}%
  <main>
    %{toasts}%
    <div class="container">
      <div class="row">
        <h1 class="h2 text-center my-4">Сегодня 123<br><span class="text-muted small">Всего 456</span></h1>
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
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Russian.json'
            }
        });
    } );
  </script>
</body>