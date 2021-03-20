<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    <img src="/apple-touch-icon.png" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title text-center">Авторизация</h4>
                        <div class="was-validated">
                            <div class="form-group">
                                <label for="login">Логин</label>
                                <input id="login" type="text" class="form-control" name="login" value="" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password">Пароль
                                    <a href="#" class="float-right">
                                        Забыли пароль?
                                    </a>
                                </label>
                                <input id="password" type="password" class="form-control" name="password" required data-eye>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                <label for="remember" class="custom-control-label">Запомнить меня</label>
                            </div>
                        </div>

                        <div class="form-group m-0">
                            <button class="btn btn-primary btn-block" onclick="auth()">
                                Войти
                            </button>
                        </div>

                        <div class="mt-4 text-center">
                            <div id="status"></div>
                            <a href="/">&larr; вернуться на главную</a>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; 2021 &mdash; <a href="#">Ульяна</a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

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
				if(data.result === "success") {
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