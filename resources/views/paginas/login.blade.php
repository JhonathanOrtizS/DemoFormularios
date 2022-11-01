<body class="login-page">

<div class="login-box">
    
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">

      <div class="card-header text-center">
        <a href="" class="h1"><b>Eva</b>-180</a>
      </div>

      <div class="card-body">
        <p class="login-box-msg">Iniciar Sesión</p>
  
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="input-group mb-3">

                <div class="input-group-append">

                    <div class="input-group-text">

                        <i class="fa-solid fa-envelope"></i>

                    </div>

                </div>

                <input id="email" type="email" class="form-control email_login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="Email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

            </div>



            {{-- PASSWORD --}}
            <div class="input-group mb-3">

                <div class="input-group-append">

                    <div class="input-group-text">

                        <i class="fa-solid fa-key"></i>

                    </div>

                </div>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror " name="password" required autocomplete="current-password"
                placeholder="Password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

            </div>


            <div class="text-center">
                <button class="btn btn-primary btn-block btn-flat" type="submit">Ingresar</button>
            </div>
            
        </form>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>

  <script src="{{url('/')}}/js/login.js"></script>
    
</body>