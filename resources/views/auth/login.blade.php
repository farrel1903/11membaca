<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Template</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <style>

    .brand-wrapper {
      display: flex;
      justify-content: center; /* Memusatkan logo secara horizontal */
      align-items: center; /* Memusatkan logo secara vertikal */
      height: 100%; /* Agar logo berada di tengah div */
    }
  </style>
</head>
<body>
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="fotobuku/buku4.jpeg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="assets/img/11logo.png" alt="logo" class="logo">
              </div>
              <br>
              <p style="font-weight: bold; text-align:center" class="login-card-description">Sign into your account</p>
              <!-- Form Login -->
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                  <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus />
                  <label for="email">Email Address</label>
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="form-floating mb-3">
                  <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                  <label for="password">Password</label>
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                  <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                  @if (Route::has('password.request'))
                      <a class="small" href="{{ route('password.request') }}">Forgot Your Password?</a>
                  @endif
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>
              <br>
              <!-- End Form Login -->
              <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
              </div>
              <nav class="login-card-footer-nav">
                <a href="#!">Terms of use.</a>
                <a href="#!">Privacy policy</a>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
