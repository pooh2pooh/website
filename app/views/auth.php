  <link href="/styles/login.css" rel="stylesheet">
</head>
<body class="text-center">
  <main class="form-signin">
    <img class="mb-4" src="/apple-touch-icon.png" alt="logo" width="72">
    <h1 class="h3 mb-3 fw-normal">Авторизация</h1>
    <div class="was-validated">
      <div class="form-floating">
        <input id="login" type="text" class="form-control" name="login" value="" placeholder="admin" required autofocus>
        <label for="login">Логин</label>
      </div>
      <div class="form-floating">
        <input id="password" type="password" class="form-control" name="password" placeholder="Пароль" required data-eye>
        <label for="password">Пароль</label>
      </div>
    </div>
    <button class="w-100 btn btn-lg btn-primary" onclick="auth()">Войти</button>
    <div class="mt-4 text-center">
        <div id="status"></div>
        <a href="/">&larr; вернуться на главную</a>
    </div>
    <p class="mt-5 mb-3 text-muted">
        Copyright &copy; 2021 &mdash; <a href="#">Ульяна</a>
    </p>
  </main>

  <script>
    let attempt = 0;
    function auth() {
      if(attempt > 2) {
          $('#status').html('<span class="text-danger">Вы не авторизовались!</span>');
          return;
      }
      let login = document.getElementById("login").value;
      let password = document.getElementById("password").value;
      $.ajax({
          type: 'POST',
          cache: false,
          dataType: 'json',
          url: '/index/auth',
          data: { login: login, password: password },
          success: function(data) {
              if(data.result === 'success') {
                  $('#status').html('<span class="text-success font-weight-bold">Привет, '+login+'!</span>');
                  setTimeout(function() {
                      window.location.href = window.location.origin+"/auth/dashboard";
                  }, 2000);
              }
          },
          error: function() {
              $('#status').html('<span class="text-danger">Неверный логин или пароль!</span>');
              attempt++;
              // console.log(attempt);
          }
      }).done();
    }
  </script>
</body>