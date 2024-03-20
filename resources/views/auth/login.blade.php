<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }} | Gestion de la comptabilité</title>
  <link href="{{compta_asset('dist/img/cuttlefish.svg')}}" rel="icon">
  {{-- <link href="{{ compta_asset('dist/img/favicon.png') }}" rel="icon">   --}}

  <!-- Google Font: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ compta_asset('plugins/fontawesome-free/css/all.min.css') }}"> 
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ compta_asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ compta_asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ compta_asset('dist/css/adminlte.min.css') }}">
  <!-- Custom style -->
  <link rel="stylesheet" href="{{ compta_asset('dist/css/custom.css') }}">
  {!! htmlScriptTagJsApi() !!}    
</head>
<style>
  .card-danger {
    padding: 0;
  }
  .card-title {
    font-size: small !important;
  }
  .card-tools {
    font-size: small !important;
  }
  .card-header {
    padding: 0.5rem !important;
    border-radius: 0.25rem !important;
}
.btn-tool {
    background-color: transparent;
    color: #fff !important;
    font-size: smaller !important;
    margin: -1.rem 0 0 0 !important;
    padding: 0rem 0.5rem!important;
}
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo color">
    <div class="log-brand-link">
      {{-- <img src="{{compta_asset('dist/img/AdminLTELogo.png')}}" alt="AkasiCompta" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      {{-- <i class="fab fa-cuttlefish brand-icon text-success no-left"></i> --}}
      <span class="brand-text font-weight-bolder">AkasiMorgue<span class="text-success">Manager</span></span>
  </div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg" style="font-size: 1.2rem"><strong>Connectez-vous</strong></p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- @if (session('error'))
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span>{{ session('error') }}</span><br>
          </div>
        @endif --}}
        {{--show the errors--}}
        @if(  $errors->any() )
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{-- <ul class="mb-0"> --}}
              @foreach( $errors->all() as $error )
                {{-- <li>{{ $error }}</li> --}}
                @if ($error == "validation.min.string")
                  <span>Le mot de passe doit avoir au moins 8 caractères !</span><br>
                @elseif ($error == "passwords.user")
                  <span>Utilisateur non trouvé !</span><br>
                @elseif ($error == "passwords.token")
                  <span>Jeton invalide !</span><br>
                @elseif ($error == "passwords.throttled")
                  <span>Plus de 3 tentatives. Réessayez plus tard !</span><br>
                @else
                  <span>{{ $error }}</span><br>
                @endif
              @endforeach
            {{-- </ul> --}}
          </div>
        @endif 

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Remenber me
              </label>
            </div>
          </div>
        </div> --}}
        <div class="row">
          <div class="col-12 my-3">{!! htmlFormSnippet() !!}</div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" class="btn btn-success btn-block" id="submitButton" disabled>Se connecter</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1 mt-2 text-right">
        {{-- <a href="{{ route('password.request') }}">Mot de passe oublié</a> --}}
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
<!-- Toastr -->
<script src="{{compta_asset('plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ compta_asset('dist/js/adminlte.min.js') }}"></script>

<script src="https://www.google.com/recaptcha/api.js?" async defer></script>
<script>
  function callbackFunction(response){
    $('#submitButton').removeAttr('disabled');
  }
  function expiredCallbackFunction(){
    document.getElementById('submitButton').setAttribute('disabled', 'disabled');
  }
</script>

@if (session('error'))  
<script>
    toastr.error("{{session('error')}}");
</script>
@endif

</body>
</html>
