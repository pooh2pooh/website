  <link href="/styles/productor.css" rel="stylesheet">
</head>
<body>
  %{header}%
  <main>
    %{toasts}%
    <div class="container">
      <div class="row">
        <div class="col col-md-6 my-5 mx-auto">
          <form method="post" action="/auth/productor" enctype="multipart/form-data" id="productor" target="uploadTarget">
            {widget_productor}
          </form>
        </div>
        <div class="w-100 btn-group">
          <a class="btn btn-lg btn-light" href="/auth/dashboard">&larr; Управление</a>
          <a id="submit_productor" class="btn btn-lg btn-light fw-bold" href="javascript:void(0)"><i class="fas fa-save mr-1"></i> Сохранить</a>
        </div>
      </div>
    </div>
  </main>
  %{footer}%

  <script>
    $(document).ready(function() {
        $("#submit_productor").click(function(){
            sendAjaxForm('productor', '/auth/productor');
            return false;
        });
    });

    // Отправляет форму
    function sendAjaxForm(ajax_form, url) {
        $.ajax({
            url: url, // url обработчика формы (/auth/productor)
            type: 'POST', // метод отправки
            dataType: 'html', // формат данных
            data: $('#'+ajax_form).serialize(), // Сеарилизуем объект
            success: function(response) { // Данные отправлены успешно
                console.log(response); // Выводим в консоль ответ для дебага
                result = $.parseJSON(response);
                if(result.status === "success") {
                    $('#add_toast_text').html('«'+result.name+'» &mdash; обновлено!');
                    $('#addToast').toast('show');
                }
                
            },
            error: function(response) { // Данные не отправлены
                console.log('Ошибка! Нельзя отправить форму');
            }
        });
    }
  </script>
  <script>
    $(document).ready(function () {
        //If image edit link is clicked
        $(".editLink").on('click', function(e){
            e.preventDefault();
            $("#fileInput:hidden").trigger('click');
        });

        //On select file to upload
        $("#fileInput").on('change', function(){
            var image = $('#fileInput').val();
            var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            
            //validate file type
            if(!img_ex.exec(image)){
                alert('Разрешены только изображения .jpg/.jpeg/.png/.gif file.');
                $('#fileInput').val('');
                return false;
            }else{
                $('.uploadProcess').show();
                $('#uploadForm').hide();
                $( "#productor" ).submit();
            }
        });
    });

    //After completion of image upload process
    function completeUpload(success, fileName) {
        if(success == 1){
            $('#imagePreview').attr("src", "");
            $('#imagePreview').attr("src", "/images/"+fileName);
            $('#fileInput').attr("value", fileName);
            $('#fileInput').attr("type", "");
            $('#fileInput').attr("type", "text");
            $('.uploadProcess').hide();
        }else{
            $('.uploadProcess').hide();
            alert('Изображение не загрузилось :(');
        }
        return true;
    }
  </script>
</body>
