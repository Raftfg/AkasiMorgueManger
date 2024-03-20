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
                    <h1 class="m-0">Ecritures</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Ecritures</li>
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
                    <h3 class="card-title pt-2">Toutes vos écritures</h3>
                    @if (isset($journal))
                      <button type="button" class="btn bg-gradient-success float-end" data-toggle="modal" data-target="#new-ecriture">Nouvelle écriture</button>
                    @endif
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th>Code</th>
                          <th>Libellé</th>
                          <th>Montant</th>
                          <th>Journal</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 1;
                        @endphp
                        @foreach ($ecritures as $ecriture)
                          <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $ecriture->code }}</td>
                            <td>{{ $ecriture->libelle }}</td>
                            <td>{{ $ecriture->montant }}</td>
                            @if (isset($ecriture->journal))
                              <td>{{ $ecriture->journal->code }}</td>                              
                            @else
                              <td>N/A</td>                              
                            @endif
                            <td>{{ date1($ecriture->date) }}</td>
                            {{-- <td>{{ $ecriture->statut }}</td> --}}
                            <td>
                              <button type="button" class="btn bg-gradient-info btn-sm action see" data-toggle="modal" data-target="#details" data-id="{{$ecriture->uuid}}"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn bg-gradient-warning btn-sm action update" data-toggle="modal" data-target="#update" data-id="{{$ecriture->uuid}}"><i class="fa fa-pen"></i></button>
                              <button type="button" class="btn bg-gradient-danger btn-sm action delete" data-toggle="modal" data-target="#delete" data-id="{{$ecriture->uuid}}"><i class="fa fa-trash"></i></button>
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

    @include('ecrituresModal')

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
        axios.get('/api/v1/ecritures/' + uuid).then(response => {
          var ecriture = response.data.data;
          document.getElementById('del_form').action = '/ecriture/' + uuid;
          document.getElementById('del_libelle').innerHTML = ecriture['libelle'];
        }).catch( error => console.log(error))
      });
      
      $(document).on("click", ".update", function () {
        var uuid = $(this).data('id');
        axios.get('/api/v1/ecritures/' + uuid).then(response => {
          var ecriture = response.data.data;
          date1 = new Date(ecriture['date_debut']);
          year1 = date1.getFullYear();
          month1 = date1.getMonth()+1;
          dt1 = date1.getDate();
          if (dt1 < 10) {
            dt1 = '0' + dt1;
          }
          if (month1 < 10) {
            month1 = '0' + month1;
          }
          
          date2 = new Date(ecriture['date_fin']);
          year2 = date2.getFullYear();
          month2 = date2.getMonth()+1;
          dt2 = date2.getDate();
          if (dt2 < 10) {
            dt2 = '0' + dt2;
          }
          if (month2 < 10) {
            month2 = '0' + month2;
          }
  
          document.getElementById('upd_form').action = '/ecriture/' + uuid;
          document.getElementById('upd_code').value = "";
          document.getElementById('upd_code').value = ecriture['code'];
          document.getElementById('upd_libelle').value = "";
          document.getElementById('upd_libelle').value = ecriture['libelle'];
          document.getElementById('upd_montant').value = "";
          document.getElementById('upd_montant').value = ecriture['montant'];
          document.getElementById('upd_taxe').value = "";
          document.getElementById('upd_taxe').value = ecriture['taxe'];
          document.getElementById('upd_date').value = "";
          document.getElementById('upd_date').value = ecriture['date'];
          document.getElementById('upd_description').innerHTML = "";
          document.getElementById('upd_description').innerHTML = ecriture['description'];
          $("#upd_compte_debit_id").val('').trigger('change');
          $("#upd_compte_credit_id").val('').trigger('change');
          document.getElementById('upd_compte_credit_id').value = "";
          if (ecriture['compte_debit']!==null) {
            $("#upd_compte_debit_id").val(ecriture['compte_debit']['uuid']).trigger('change');
            document.getElementById('upd_compte_debit_id').value = ecriture['compte_debit']['uuid'];            
          }
          if (ecriture['compte_credit']!==null) {
            $("#upd_compte_credit_id").val(ecriture['compte_credit']['uuid']).trigger('change');
            document.getElementById('upd_compte_credit_id').value = ecriture['compte_credit']['uuid'];            
          }
        }).catch( error => console.log(error))
      });
      
      $(document).on("click", ".see", function () {
        var uuid = $(this).data('id');
        // const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        axios.get('/api/v1/ecritures/' + uuid).then(response => {
          var ecriture = response.data.data;
          console.log(ecriture);
          // console.log(new Date(ecriture['date_debut']).toLocaleDateString('fr-FR'));
          // console.log(new Date(ecriture['date_debut']).toLocaleDateString('fr-FR', options));
  
          document.getElementById('see_code').innerHTML = "";
          document.getElementById('see_code').innerHTML = ecriture['code'];
          document.getElementById('see_libelle').innerHTML = "";
          document.getElementById('see_libelle').innerHTML = ecriture['libelle'];
          document.getElementById('see_montant').innerHTML = "";
          document.getElementById('see_montant').innerHTML = ecriture['montant']+" ("+(ecriture['devise']==null?'N/A':ecriture['devise']['libelle'])+")";
          document.getElementById('see_taxe').innerHTML = "";
          document.getElementById('see_taxe').innerHTML = ecriture['taxe']===null?'':ecriture['taxe']+" %";
          document.getElementById('see_compte_debit_id').innerHTML = "";
          document.getElementById('see_compte_debit_id').innerHTML = ecriture['compte_debit']===null?'N/A':"("+ecriture['compte_debit']['num']+") - "+ecriture['compte_debit']['libelle'];          
          document.getElementById('see_compte_credit_id').innerHTML = "";
          document.getElementById('see_compte_credit_id').innerHTML = ecriture['compte_credit']===null?'N/A':"("+ecriture['compte_credit']['num']+") - "+ecriture['compte_credit']['libelle'];
          // document.getElementById('see_budget_id').innerHTML = "";
          // document.getElementById('see_budget_id').innerHTML = ecriture['ligne']===null?'N/A':ecriture['ligne']['budget']['libelle']; 
          // document.getElementById('see_ligne_id').innerHTML = "";
          // document.getElementById('see_ligne_id').innerHTML = ecriture['ligne']===null?'N/A':ecriture['ligne']['libelle']; 
          document.getElementById('see_journal_id').innerHTML = "";
          document.getElementById('see_journal_id').innerHTML = ecriture['journal']===null?'N/A':ecriture['journal']['libelle']; 
          document.getElementById('see_exercice_id').innerHTML = "";
          document.getElementById('see_exercice_id').innerHTML = ecriture['exercice']===null?'N/A':ecriture['exercice']['libelle']; 
          // document.getElementById('see_devise_id').innerHTML = "";
          // document.getElementById('see_devise_id').innerHTML = ecriture['devise']==null?'N/A':ecriture['devise']['libelle']; 
          document.getElementById('see_date').innerHTML = "";
          document.getElementById('see_date').innerHTML = new Date(ecriture['date']).toLocaleDateString('fr-FR');
          document.getElementById('see_description').innerHTML = "";
          document.getElementById('see_description').innerHTML = ecriture['description'];
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