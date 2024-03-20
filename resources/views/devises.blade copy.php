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
                    <h1 class="m-0">Devises</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Devises</li>
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
                    <h3 class="card-title pt-2">Tous vos devises</h3>
                    <button type="button" class="btn bg-gradient-success float-end add" data-toggle="modal" data-target="#new-devise">Nouvelle devise</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th>Code</th>
                          <th>Libellé</th>
                          <th>Description</th>
                          <th>Date</th>
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
                            <td>{{ $devise->code }}</td>
                            <td>{{ $devise->libelle }}</td>
                            <td>{{ $devise->description }}</td>
                            <td>{{ date2($devise->created_at) }}</td>
                            {{-- <td>{{ $devise->statut }}</td> --}}
                            <td>
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
        axios.get('/api/v1/devises/' + uuid).then(response => {
          var devise = response.data.data;
          document.getElementById('del_form').action = '/devise/' + uuid;
          document.getElementById('del_libelle').innerHTML = devise['libelle'];
        }).catch( error => console.log(error))
      });
      
      $(document).on("click", ".update", function () {
        var uuid = $(this).data('id');
        axios.get('/api/v1/devises/' + uuid).then(response => {
          var devise = response.data.data;  
          document.getElementById('upd_form').action = '/devise/' + uuid;
          document.getElementById('upd_code').value = "";
          document.getElementById('upd_code').value = devise['code'];
          document.getElementById('upd_libelle').value = "";
          document.getElementById('upd_libelle').value = devise['libelle'];
          document.getElementById('upd_description').innerHTML = "";
          document.getElementById('upd_description').innerHTML = devise['description'];
        }).catch( error => console.log(error))
      });
      
      $(document).on("click", ".see", function () {
        var uuid = $(this).data('id');
        // const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        axios.get('/api/v1/devises/' + uuid).then(response => {
          var devise = response.data.data;
          // console.log(new Date(devise['created_at']).toLocaleDateString('fr-FR'));
          // console.log(new Date(devise['created_at']).toLocaleDateString('fr-FR', options));  
          document.getElementById('see_code').innerHTML = "";
          document.getElementById('see_code').innerHTML = devise['code'];
          document.getElementById('see_libelle').innerHTML = "";
          document.getElementById('see_libelle').innerHTML = devise['libelle'];
          document.getElementById('see_created_at').innerHTML = "";
          document.getElementById('see_created_at').innerHTML = new Date(devise['created_at']).toLocaleDateString('fr-FR');
          document.getElementById('see_description').innerHTML = "";
          document.getElementById('see_description').innerHTML = devise['description'];
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