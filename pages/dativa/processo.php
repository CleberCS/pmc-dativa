  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Processos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Processos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- Application buttons -->
            <div class="card">
              <div class="card-body">
                <a class="btn btn-app bg-secondary">
                  <i class="fas fa-plus"></i>&nbspNovo Processo&nbsp
                </a>
                <a class="btn btn-app bg-success">
                  <span class="badge bg-purple">891</span>
                  <i class="fas fa-file-pdf"></i> Relatórios
                </a>
                <a class="btn btn-app bg-danger">
                  <i class="fas fa-chart-bar"></i> Estatísticas
                </a>
              </div><!-- /.card-body -->
              <div class="card-header">
                <h3 class="card-title">Processos de anistia realizados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="10">#</th>
                    <th>Protocolo</th>
                    <th>ID. Cadastral</th>
                    <th>Requerente</th>
                    <th>Composição</th>
                    <th>Condição</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td>2514/2021</td>
                    <td>05.032.005</td>
                    <td>Cleber Cerqueira dos Santos</td>
                    <td>IPTU (2008/2009/2010)</td>
                    <td>P - 3X</td>
                    <td>
                    <a href="#" title="Visualizar Processo"> <i class="fas fa-eye text-green"></i></a>&nbsp&nbsp
                    <a href="#" title="Editar Processo"> <i class="fas fa-edit text-blue"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>2601/2021</td>
                    <td>07.132.008</td>
                    <td>Paulo Moreira Vicente</td>
                    <td>IPTU (2011/2012/2013/2014)</td>
                    <td>A Vista</td>
                    <td>
                    <a href="#" title="Visualizar Processo"> <i class="fas fa-eye text-green"></i></a>&nbsp&nbsp
                    <a href="#" title="Editar Processo"> <i class="fas fa-edit text-blue"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>2605/2021</td>
                    <td>03.033.025</td>
                    <td>Alberto Palhares </td>
                    <td>IPTU (2002/2010/2011/2012)</td>
                    <td>P - 6X</td>
                    <td>
                    <a href="#" title="Visualizar Processo"> <i class="fas fa-eye text-green"></i></a>&nbsp&nbsp
                    <a href="#" title="Editar Processo"> <i class="fas fa-edit text-blue"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>2514/2021</td>
                    <td>08.132.023</td>
                    <td>Roberto Ventura</td>
                    <td>Taxas/Multas (2006/2007/2008)</td>
                    <td>P - 3X</td>
                    <td>
                    <a href="#" title="Visualizar Processo"> <i class="fas fa-eye text-green"></i></a>&nbsp&nbsp
                    <a href="#" title="Editar Processo"> <i class="fas fa-edit text-blue"></i></a>
                    </td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Protocolo</th>
                    <th>ID. Cadastral</th>
                    <th>Requerente</th>
                    <th>Composição</th>
                    <th>Condição</th>
                    <th>Ações</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
    });
  });
</script>
