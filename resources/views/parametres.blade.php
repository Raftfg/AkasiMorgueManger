@extends("layouts.template")

@section("stylesheets") 
    <!-- Select2 -->
    <link rel="stylesheet" href="{{compta_asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{compta_asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> 
@endsection

@section("content")
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Paramètres</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Paramètres</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title pt-2">Vos paramètres</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <form action="{{route('parametre.update', ['uuid' => $parametre->uuid])}}" method="post" enctype="multipart/form-data">
                      @csrf
                      {{ method_field('PUT') }}
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Exercice </label>
                          <select class="form-control select2" name="exercice_id" style="width: 100%;" required>
                            <option disabled>Sélectionnez un exercice</option>
                            @foreach ($exercices as $exercice)
                              @php
                                $selected = ($parametre->exercice->uuid == $exercice->uuid)?"selected":"";
                              @endphp
                              <option value="{{$exercice->uuid}}" {{$selected}}>{{$exercice->libelle}}</option>  
                              @php
                                $selected = "";
                              @endphp            
                            @endforeach
                          </select>  
                        </div>
                        <div class="form-group col-md-6">
                          <label>Devise </label>
                          <select id="projects" class="form-control select2" name="devise_id" style="width: 100%;" required>
                            <option selected disabled>Sélectionnez une devise</option>
                            @foreach ($devises as $devise)
                              @php
                                $selected = ($parametre->devise->uuid == $devise->uuid)?"selected":"";
                              @endphp
                              <option value="{{$devise->uuid}}" {{$selected}}>{{$devise->libelle}} ({{$devise->description}})</option>  
                              @php
                                $selected = "";
                              @endphp             
                            @endforeach
                          </select>  
                        </div>
                      </div>
                      <button type="submit" class="btn btn-warning">Enregistrer</button>
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section("scripts")
<!-- Select2 -->
<script src="{{compta_asset('plugins/select2/js/select2.full.min.js')}}"></script>

<script>    
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
    theme: 'bootstrap4'
    })
  })
</script> 

@endsection