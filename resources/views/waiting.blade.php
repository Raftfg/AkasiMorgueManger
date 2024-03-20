@extends("layouts.template")

@section("stylesheets") 

@endsection

@section("content")
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Page</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        {{-- <h2 class="headline text-warning"> 404</h2> --}}
        <div class="error-content ml-0">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Fonctionnalité en cours de production.</h3>

          <p>
            Merci de revenir une prochaine fois. Une version sera disponible sous peu
            En attendant, vous pouvez <a href="/">revenir au tableau de bord</a> ou essayer une autre fonctionnalité. 
            <br> Equipe Commercial Akasi
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  
@endsection

@section("scripts")

@endsection