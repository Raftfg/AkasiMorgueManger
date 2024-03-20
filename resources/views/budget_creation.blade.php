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
                    <h1 class="m-0">Budgets</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Budgets</li>
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
                    <h3 class="card-title pt-2">Création de budget</h3>
                    <button type="button" class="btn bg-gradient-success float-end" data-toggle="modal" data-target="#new-budget">Nouveau budget</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
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

    @include('budgetsModal')

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