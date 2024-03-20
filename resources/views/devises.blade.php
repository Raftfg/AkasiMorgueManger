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
                    <h1 class="m-0">Mouvement de corps</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Mouvement de corps</li>
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
                    <h3 class="card-title pt-2">Tous vos mouvement de corps</h3>
                    <button type="button" class="btn bg-gradient-success float-end add" data-toggle="modal" data-target="#new-mouvement-corps">Nouvel mouvement de corps</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th>Corps</th>
                          <th>Date départ</th>
                          <th>Lieu départ</th>
                          <th>Responsable</th>
                          {{-- <th>Statut</th> --}}
                          <th style="width: 15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 1;
                        @endphp
                        @foreach ($devises as $devise)
                          <tr>
                            <td>{{ $i++ }}</td>
                            {{-- <td>{{ $devise->corps->nom_defunt }} {{ $devise->corps->prenom_defunt }}</td> --}}
                            <td>
                              @if ($devise->corps != null)
                                  {{ $devise->corps->nom_defunt }} {{ $devise->corps->prenom_defunt }}
                              @else
                                  {{ __('Corps non spécifié') }}
                              @endif
                          </td>
                            <td>{{ $devise->date_heure_depart }}</td>
                            <td>{{ $devise->Lieu_Départ }}</td>
                            <td>{{ $devise->responsable_mouvement	 }}</td> 
                            <td>
                              {{-- <button type="button" class="btn bg-gradient-info btn-sm action see" data-toggle="modal" data-target="#details" data-id="{{$devise->uuid}}"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn bg-gradient-warning btn-sm action update" data-toggle="modal" data-target="#update" data-id="{{$devise->uuid}}"><i class="fa fa-pen"></i></button>
                              <button type="button" class="btn bg-gradient-danger btn-sm action delete" data-toggle="modal" data-target="#delete" data-id="{{$devise->uuid}}"><i class="fa fa-trash"></i></button>
                               --}}
                               <button type="button" class="btn bg-gradient-info btn-sm action see" data-toggle="modal" data-target="#details" data-id="{{$devise->uuid}}"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn bg-gradient-warning btn-sm action update" data-toggle="modal" data-target="#update" data-id="{{$devise->uuid}}"><i class="fa fa-pen"></i></button>
                              <button type="button" class="btn bg-gradient-danger btn-sm action delete" data-toggle="modal" data-target="#delete" data-id="{{$devise->uuid}}"><i class="fa fa-trash"></i></button>
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

    @include('devisesModal')

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
      $(document).on("click", ".delete", function () {
      var uuid = $(this).data('id');
      axios.get('/api/v1/mouvements/' + uuid).then(response => {
        var devise = response.data.data;
        document.getElementById('del_form').action = '/devise/' + uuid;
        document.getElementById('del_libelle').innerHTML = devise['responsable_mouvement'];
      }).catch( error => console.log(error))
    });
      
    $(document).on("click", ".update", function () {
    var uuid = $(this).data('id');
    axios.get('/api/v1/mouvements/' + uuid).then(response => {
        var devise = response.data.data;
        document.getElementById('upd_form').action = '/devise/' + uuid;
        $("#upd_corps_id").val('').trigger('change');
          if (devise['corps'] !== null) {
          $("#upd_corps_id").val(devise['corps']['uuid']).trigger('change');
          }
          document.getElementById('upd_date_heure_depart').value = "";
          document.getElementById('upd_date_heure_depart').value = devise['date_heure_depart'];
          document.getElementById('upd_lieu_depart').value = "";
          document.getElementById('upd_lieu_depart').value = devise['Lieu_Départ'];
          document.getElementById('upd_date_heure_arrivee').value = "";
          document.getElementById('upd_date_heure_arrivee').value = devise['date_heure_arrivee'];
          document.getElementById('upd_lieu_arrivee').value = "";
          document.getElementById('upd_lieu_arrivee').value = devise['lieu_arrivee'];
          document.getElementById('upd_responsable_mouvement').value = "";
          document.getElementById('upd_responsable_mouvement').value = devise['responsable_mouvement'];
           }).catch(error => console.log(error))
      });

       $(document).on("click", ".see", function () {
        var uuid = $(this).data('id');
        axios.get('/api/v1/mouvements/' + uuid).then(response => {
          var devise = response.data.data;  
          document.getElementById('see_corps_id').innerHTML = "";
          var nomPrenom = devise['corps'] === null ? 'N/A' : devise['corps']['nom_defunt'] + ' ' + devise['corps']['prenom_defunt'];
          document.getElementById('see_corps_id').innerHTML = nomPrenom;

          document.getElementById('see_date_heure_depart').innerHTML = "";
          document.getElementById('see_date_heure_depart').innerHTML = devise['date_heure_depart'];
          document.getElementById('see_Lieu_Départ').innerHTML = "";
          document.getElementById('see_Lieu_Départ').innerHTML = devise['Lieu_Départ'];
          document.getElementById('see_date_heure_arrivee').innerHTML = "";
          document.getElementById('see_date_heure_arrivee').innerHTML = devise['date_heure_arrivee'];
          document.getElementById('see_lieu_arrivee').innerHTML = "";
          document.getElementById('see_lieu_arrivee').innerHTML = devise['lieu_arrivee'];
          document.getElementById('see_responsable_mouvement').innerHTML = "";
          document.getElementById('see_responsable_mouvement').innerHTML = devise['responsable_mouvement'];
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