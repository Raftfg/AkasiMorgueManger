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
                    <h1 class="m-0">Tableau de bord</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>75.000<sup style="font-size: 20px">FCFA</sup></h3>

                            <p>Total J</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>375.350<sup style="font-size: 20px">FCFA</sup></h3>

                            <p>Total J-1</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>4</h3>

                            <p>Transactions J</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>85</h3>

                            <p>Transactions J-1</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            
            <!-- Main row -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title pt-2">Toutes vos écritures</h3>
                    <button type="button" class="btn bg-gradient-success float-end" data-toggle="modal" data-target="#new-ecriture">Nouvelle écriture</button>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th style="width: 35%">Description</th>
                          <th style="width: 13%">Exercice</th>
                          <th style="width: 13%">Comptable</th>
                          <th style="width: 13%">Date</th>
                          <th style="width: 11%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Achat de médicament</td>
                          <td>Exercice 2023</td>
                          <td>Système</td>
                          <td>20/10/2023</td>
                          <td>
                            {{-- <a type="button" class="btn btn-block bg-gradient-info btn-xs">Détails</a>
                            <a type="button" class="btn btn-block bg-gradient-warning btn-xs">Extourner</a> --}}
                            <button type="button" class="btn bg-gradient-info btn-sm action" data-toggle="modal" data-target="#details"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn bg-gradient-warning btn-sm action" data-toggle="modal" data-target="#extourne"><i class="fa fa-exchange-alt"></i></button>
                            <button type="button" class="btn bg-gradient-danger btn-sm action" data-toggle="modal" data-target="#delete"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Achat de médicament</td>
                          <td>Exercice 2023</td>
                          <td>Système</td>
                          <td>20/10/2023</td>
                          <td>
                            <a type="button" class="btn bg-gradient-info btn-sm action"><i class="fa fa-eye"></i></a>
                            <a type="button" class="btn bg-gradient-warning btn-sm action"><i class="fa fa-exchange-alt"></i></a>
                            <a type="button" class="btn bg-gradient-danger btn-sm action"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Achat de carburant</td>
                          <td>Exercice 2023</td>
                          <td>ALIA Albert</td>
                          <td>20/10/2023</td>
                          <td>
                            <a type="button" class="btn bg-gradient-info btn-sm action"><i class="fa fa-eye"></i></a>
                            <a type="button" class="btn bg-gradient-warning btn-sm action"><i class="fa fa-exchange-alt"></i></a>
                            <a type="button" class="btn bg-gradient-danger btn-sm action"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>                        
                          <td>Achat d'une voiture</td>
                          <td>Exercice 2023</td>
                          <td>KPOTIN Emmanuel</td>
                          <td>20/10/2023</td>
                          <td>
                            <a type="button" class="btn bg-gradient-info btn-sm action"><i class="fa fa-eye"></i></a>
                            <a type="button" class="btn bg-gradient-warning btn-sm action"><i class="fa fa-exchange-alt"></i></a>
                            <a type="button" class="btn bg-gradient-danger btn-sm action"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
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

    <script>
      $(document).ready(function(){

        $(document).on('click', '.add', function(){ 
          var html = '';
          html += '<tr>';
          html += '<td><input type="text" name="compte_id[]" class="form-control" required/></td>';
          html += '<td><input type="text" name="type[]" class="form-control" required/></td>';
          html += '<td><input type="text" name="montant[]" class="form-control" required/></td>';
          html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus"></span></button></td></tr>';
          $('#item_table').append(html);
        });
      
        $(document).on('click', '.remove', function(){
          $(this).closest('tr').remove();
        });     
      
      });
    </script>
@endsection