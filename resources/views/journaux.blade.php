@extends("layouts.template")

@section("stylesheets")
    <!-- DataTables -->
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{compta_asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">  
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
                    <h1 class="m-0">Examen médical</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Examen médical</li>
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
                    <h3 class="card-title pt-2">Tous vos examens médicaux</h3>
                    <button type="button" class="btn bg-gradient-success float-end" data-toggle="modal" data-target="#new-examen-medical">Nouveau examen médical</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th>Corps</th>
                          <th>Date examen</th>
                          <th>Résultat examen</th>
                          <th>Médecin</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 1;
                        @endphp
                        @foreach ($journaux as $journal)
                          <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $journal->corps->nom_defunt }} {{ $journal->corps->prenom_defunt }}</td>
                          </td>
                            <td>{{ $journal->date_examen }}</td>
                            <td>{{ $journal->resultat_examen }}</td>
                            <td>{{ $journal->medecin }}</td>
                          
                            {{-- <td>{{ $journal->statut }}</td> --}}
                            <td>
                              {{-- <a type="button" class="btn bg-gradient-success btn-sm" href="{{route('ecritures.journal', ['journal' => $journal->uuid])}}"><i class="fas fa-newspaper"></i></a> --}}
                              {{-- <button type="button" class="btn bg-gradient-info btn-sm action see" data-toggle="modal" data-target="#details" data-id="{{$journal->uuid}}"><i class="fa fa-eye"></i></button> --}}
                              <button type="button" class="btn bg-gradient-warning btn-sm action update" data-toggle="modal" data-target="#update" data-id="{{$journal->uuid}}"><i class="fa fa-pen"></i></button>
                              <button type="button" class="btn bg-gradient-danger btn-sm action delete" data-toggle="modal" data-target="#delete" data-id="{{$journal->uuid}}"><i class="fa fa-trash"></i></button>
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

    @include('journauxModal')

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
    <!-- Select2 -->
    <script src="{{compta_asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- Axios -->
    <script src="{{compta_asset('plugins/axios/axios.min.js')}}"></script> 

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
  
    <script>
       $(document).on("click", ".delete", function () {
      var uuid = $(this).data('id');
      axios.get('/api/v1/examens/' + uuid).then(response => {
        var journal = response.data.data;
        document.getElementById('del_form').action = '/journal/' + uuid;
        document.getElementById('del_libelle').innerHTML = journal['resultat_examen'];
      }).catch( error => console.log(error))
    });
      
    $(document).on("click", ".update", function () {
    var uuid = $(this).data('id');
    axios.get('/api/v1/examens/' + uuid).then(response => {
        var journal = response.data.data;
        document.getElementById('upd_form').action = '/journal/' + uuid;
        $("#upd_corps_id").val('').trigger('change');
          if (journal['corps'] !== null) {
          $("#upd_corps_id").val(journal['corps']['uuid']).trigger('change');
          }
        document.getElementById('upd_date_examen').value = "";
          document.getElementById('upd_date_examen').value = journal['date_examen'];
          document.getElementById('upd_resultat_examen').value = "";
          document.getElementById('upd_resultat_examen').value = journal['resultat_examen'];
          console.log(journal);
          document.getElementById('upd_medecin').value = "";
          document.getElementById('upd_medecin').value = journal['medecin'];
    }).catch(error => console.log(error))
});
      
      $(document).on("click", ".see", function () {
        var uuid = $(this).data('id');
        // const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        axios.get('/api/v1/journaux/' + uuid).then(response => {
          var journal = response.data.data;
          // console.log(new Date(journal['date_debut']).toLocaleDateString('fr-FR'));
          // console.log(new Date(journal['date_debut']).toLocaleDateString('fr-FR', options));
  
          document.getElementById('see_code').innerHTML = "";
          document.getElementById('see_code').innerHTML = journal['code'];
          document.getElementById('see_libelle').innerHTML = "";
          document.getElementById('see_libelle').innerHTML = journal['libelle'];
          document.getElementById('see_compte_debit_id').innerHTML = "";
          document.getElementById('see_compte_debit_id').innerHTML = journal['compte_debit']==null?'N/A':"("+journal['compte_debit']['num']+") - "+journal['compte_debit']['libelle'];          
          document.getElementById('see_compte_credit_id').innerHTML = "";
          document.getElementById('see_compte_credit_id').innerHTML = journal['compte_credit']==null?'N/A':"("+journal['compte_credit']['num']+") - "+journal['compte_credit']['libelle'];
          document.getElementById('see_created_at').innerHTML = "";
          document.getElementById('see_created_at').innerHTML = new Date(journal['created_at']).toLocaleDateString('fr-FR');
          document.getElementById('see_description').innerHTML = "";
          document.getElementById('see_description').innerHTML = journal['description'];
          document.getElementById('see_ecritures').innerHTML = "";
          document.getElementById('see_ecritures').innerHTML = journal['ecritures']['data'].length;
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