@extends("layouts.template")

@section("stylesheets")
    <!-- DataTables -->
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">  
@endsection

@section("content")
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Corps</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Corps</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title pt-2">Tous vos corps</h3>
                    <button type="button" class="btn bg-gradient-success float-end add" data-toggle="modal" data-target="#new-corps">Nouveau corps</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th>Nom et Prénom du défunt</th>
                          <th>Date naissance</th>
                          <th>Date décès</th>
                          <th>Lieu décès</th>
                          <th>Cause du décès</th>
                          {{-- <th>Statut</th> --}}
                          <th style="width: 15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 1;
                        @endphp
                        @foreach ($exercices as $exercice)
                          <tr>
                           <td>{{ $i++ }}</td>
                            <td>{{ $exercice->nom_defunt }} {{ $exercice->prenom_defunt }}</td>
                            <td>{{ $exercice->date_naissance }}</td>
                            <td>{{ $exercice->date_deces }}</td>
                            <td>{{ $exercice->lieu_deces }}</td>
                            <td>{{ $exercice->cause_décès}}</td>
                            
                            {{-- <td>
                              @if ($exercice->uuid == parametre()->exercice->uuid)
                                <span class="right badge badge-success">Ouvert</span>
                              @else
                                <span class="right badge badge-danger">Fermé</span>
                              @endif
                            </td> --}}
                            {{-- <td>{{ $exercice->statut }}</td> --}}
                            {{-- data-id="{{$exercice->uuid}}" --}}
                            <td>                              
                              {{-- <button type="button" class="btn bg-gradient-success btn-sm action activation" data-toggle="modal" data-target="#activation" data-id=""><i class="fas fa-book"></i></button> --}}
                              {{-- <a type="button" class="btn bg-gradient-success btn-sm" href="{{route('journaux.exercice', ['exercice' => $exercice->uuid])}}"><i class="fas fa-book"></i></a> --}}
                              <button type="button" class="btn bg-gradient-info btn-sm action see" data-toggle="modal" data-target="#details" data-id="{{$exercice->uuid}}"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn bg-gradient-warning btn-sm action update" data-toggle="modal" data-target="#update" data-id="{{$exercice->uuid}}"><i class="fa fa-pen"></i></button>
                              <button type="button" class="btn bg-gradient-danger btn-sm action delete" data-toggle="modal" data-target="#delete" data-id="{{$exercice->uuid}}"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>                            
                        @endforeach

                      </tbody>
                    </table>
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

    @include('exercicesModal')

@endsection

@section("scripts")
    <!-- DataTables  & Plugins -->
    <script src="{{compta_asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{compta_asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{compta_asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{compta_asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{compta_asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Axios -->
    <script src="{{compta_asset('plugins/axios/axios.min.js')}}"></script>  
  
    <script>

      $(document).on("click", ".activation", function () {
        var uuid = $(this).data('id');
        axios.get('/api/v1/exercices/' + uuid).then(response => {
          var exercice = response.data.data;
          document.getElementById('act_link').href = '/journaux/exercice/' + uuid;
          document.getElementById('act_libelle').innerHTML = exercice['libelle'];
        }).catch( error => console.log(error))
      });
      
      $(document).on("click", ".add", function () {
          document.getElementById('add_libelle').value = 'Exercice '+(new Date().getFullYear()+1);
          document.getElementById('add_description').innerHTML = 'Exercice de l\'année '+(new Date().getFullYear()+1);
          document.getElementById('add_date_debut').value = new Date().getFullYear()+1+'-01-01';
          document.getElementById('add_date_fin').value = new Date().getFullYear()+1+'-12-31';
      });

      // $(document).on("click", ".delete", function () {
      //   var uuid = $(this).data('id');
      //   axios.get('/api/v1/corpss/' + uuid).then(response => {
      //     var exercice = response.data.data;
      //     document.getElementById('del_form').action = '/exercice/' + uuid;
      //     document.getElementById('non_defunt').innerHTML = exercice['non_defunt'];
      //   }).catch( error => console.log(error))
      // });
      $(document).on("click", ".delete", function () {
      var uuid = $(this).data('id');
      axios.get('/api/v1/corpss/' + uuid).then(response => {
        var exercice = response.data.data;
        var nomPrenom = exercice['nom_defunt'] + ' ' + exercice['prenom_defunt'];
            document.getElementById('del_form').action = '/exercice/' + uuid;
            document.getElementById('del_libelle').innerHTML = nomPrenom;
      }).catch( error => console.log(error))
    });
      
    $(document).on("click", ".update", function () {
    var uuid = $(this).data('id');
    axios.get('/api/v1/corpss/' + uuid).then(response => {
        var exercice = response.data.data;
        document.getElementById('upd_form').action = '/exercice/' + uuid;
        document.getElementById('upd_nom_defunt').value = "";
          document.getElementById('upd_nom_defunt').value = exercice['nom_defunt'];
          document.getElementById('upd_prenom_defunt').value = "";
          document.getElementById('upd_prenom_defunt').value = exercice['prenom_defunt'];
          document.getElementById('upd_date_naissance').value = "";
          document.getElementById('upd_date_naissance').value = exercice['date_naissance'];
          document.getElementById('upd_date_deces').value = "";
          document.getElementById('upd_date_deces').value = exercice['date_deces'];
          document.getElementById('upd_lieu_deces').value = "";
          document.getElementById('upd_lieu_deces').value = exercice['lieu_deces'];
          $("#upd_morgue_id").val('').trigger('change');
          if (exercice['morgue'] !== null) {
          $("#upd_morgue_id").val(exercice['morgue']['uuid']).trigger('change');
          }
          
          $("upd_etat_corps").val('').trigger('change');
           if (exercice['etat_corps'] !== null) {
           $("upd_etat_corps").val(exercice['etat_corps']).trigger('change');
        }


          // document.getElementById('upd_etat_corps').value = "";
          // document.getElementById('upd_etat_corps').value = exercice['etat_corps'];
          document.getElementById('upd_cause_deces').value = "";
          document.getElementById('upd_cause_deces').value = exercice['cause_décès'];
    }).catch(error => console.log(error))
});

      // $(document).on("click", ".update", function () {
      //   var uuid = $(this).data('id');
      //   axios.get('/api/v1/exercices/' + uuid).then(response => {
      //     var exercice = response.data.data;
      //     date1 = new Date(exercice['date_debut']);
      //     year1 = date1.getFullYear();
      //     month1 = date1.getMonth()+1;
      //     dt1 = date1.getDate();
      //     if (dt1 < 10) {
      //       dt1 = '0' + dt1;
      //     }
      //     if (month1 < 10) {
      //       month1 = '0' + month1;
      //     }
          
      //     date2 = new Date(exercice['date_fin']);
      //     year2 = date2.getFullYear();
      //     month2 = date2.getMonth()+1;
      //     dt2 = date2.getDate();
      //     if (dt2 < 10) {
      //       dt2 = '0' + dt2;
      //     }
      //     if (month2 < 10) {
      //       month2 = '0' + month2;
      //     }
  
      //     document.getElementById('upd_form').action = '/exercice/' + uuid;
      //     document.getElementById('upd_code').value = "";
      //     document.getElementById('upd_code').value = exercice['code'];
      //     document.getElementById('upd_libelle').value = "";
      //     document.getElementById('upd_libelle').value = exercice['libelle'];
      //     document.getElementById('upd_date_debut').value = "";
      //     // document.getElementById('upd_date_debut').value = year1+'-' + month1 + '-'+dt1;
      //     document.getElementById('upd_date_debut').value = exercice['date_debut'];
      //     document.getElementById('upd_date_fin').value = "";
      //     document.getElementById('upd_date_fin').value = year2+'-' + month2 + '-'+dt2;
      //     document.getElementById('upd_description').innerHTML = "";
      //     document.getElementById('upd_description').innerHTML = exercice['description'];
      //   }).catch( error => console.log(error))
      // });
      
      // $(document).on("click", ".see", function () {
      //   var uuid = $(this).data('id');
      //   const options = { year: 'numeric', month: 'long', day: 'numeric' };
      //   axios.get('/api/v1/exercices/' + uuid).then(response => {
      //     var exercice = response.data.data; 
      //     document.getElementById('see_code').innerHTML = "";
      //     document.getElementById('see_code').innerHTML = exercice['code'];
      //     document.getElementById('see_libelle').innerHTML = "";
      //     document.getElementById('see_libelle').innerHTML = exercice['libelle'];
      //     document.getElementById('see_date_debut').innerHTML = "";
      //     document.getElementById('see_date_debut').innerHTML = new Date(exercice['date_debut']).toLocaleDateString('fr-FR');
      //     document.getElementById('see_date_fin').innerHTML = "";
      //     document.getElementById('see_date_fin').innerHTML = new Date(exercice['date_fin']).toLocaleDateString('fr-FR');
      //     document.getElementById('see_created_at').innerHTML = "";
      //     document.getElementById('see_created_at').innerHTML = new Date(exercice['created_at']).toLocaleDateString('fr-FR');
      //     document.getElementById('see_description').innerHTML = "";
      //     document.getElementById('see_description').innerHTML = exercice['description'];
      //   }).catch( error => console.log(error))
      // });
      $(document).on("click", ".see", function () {
        var uuid = $(this).data('id');
        axios.get('/api/v1/corpss/' + uuid).then(response => {
          var exercice = response.data.data;
          // console.log(new Date(exercice['date_debut']).toLocaleDateString('fr-FR'));
          // console.log(new Date(exercice['date_debut']).toLocaleDateString('fr-FR', options));  
          document.getElementById('see_nom_defunt').innerHTML = "";
          document.getElementById('see_nom_defunt').innerHTML = exercice['nom_defunt'];
          document.getElementById('see_prenom_defunt').innerHTML = "";
          document.getElementById('see_prenom_defunt').innerHTML = exercice['prenom_defunt'];
          document.getElementById('see_date_naissance').innerHTML = "";
          document.getElementById('see_date_naissance').innerHTML = exercice['date_naissance'];
          document.getElementById('see_date_deces').innerHTML = "";
          document.getElementById('see_date_deces').innerHTML = exercice['date_deces'];
          document.getElementById('see_lieu_deces').innerHTML = "";
          document.getElementById('see_lieu_deces').innerHTML = exercice['lieu_deces'];
          document.getElementById('see_etat_corps').innerHTML = "";
          document.getElementById('see_etat_corps').innerHTML = exercice['etat_corps'];
          document.getElementById('see_cause_deces').innerHTML = "";
          document.getElementById('see_cause_deces').innerHTML = exercice['cause_décès'];
          document.getElementById('see_morgue_id').innerHTML = "";
          document.getElementById('see_morgue_id').innerHTML = exercice['morgue']===null?'N/A':exercice['morgue']['libelle']; 
         
        }).catch( error => console.log(error))
      });
    </script>
  
    <!-- Page specific script -->
    <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["excel", "pdf", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>
@endsection