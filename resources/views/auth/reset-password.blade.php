<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} | Gestion de la comptabilité</title>
    <link href="{{ compta_asset('dist/img/favicon.png') }}" rel="icon">  
  
    <!-- Google Font: Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ compta_asset('plugins/fontawesome-free/css/all.min.css') }}"> 
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ compta_asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ compta_asset('dist/css/adminlte.min.css') }}">
  <!-- Custom style -->
  <link rel="stylesheet" href="{{ compta_asset('dist/css/custom.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo color">
    <div class="logo"><i class="fas fa-compta fa-fw"></i></div>        
    <span class="brand-text">compta</span>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Vous y êtes presque, récupérez votre mot de passe maintenant.</p>

      <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{--show the status--}}
        @if (session('status'))
          @if (session('status') == "passwords.reset")
            <div class="alert alert-success" role="alert">
              <span>Mot de passe réinitialisé !</span>
            </div>
          @else    
            <div class="alert alert-success" role="alert">
              <span>{{ session('status') }}</span>
            </div>
          @endif
        @endif
        
        {{--show the errors--}}
        @if(  $errors->any() )
          <div class="alert alert-danger" role="alert">
            {{-- <ul class="mb-0"> --}}
              @foreach( $errors->all() as $error )
                {{-- <li>{{ $error }}</li> --}}
                @if ($error == "validation.min.string")
                  <span>Le mot de passe doit avoir au moins 8 caractères !</span><br>
                @else
                  <span>{{ $error }}</span><br>
                @endif
              @endforeach
            {{-- </ul> --}}
          </div>
        @endif        

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirmez Mot de passe" name="password_confirmation" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Changer Mot de passe</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Se connecter</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ compta_asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ compta_asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ compta_asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
