<?php
session_start();
ob_start();
require_once '_app/Config.inc.php';
if (!isset($_SESSION['system'])):
    $_SESSION['system'] = array();
endif;

//define os gets
$pg = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);
$alert = filter_input(INPUT_GET, 'alert', FILTER_DEFAULT);
if (!empty($alert)):
    $_SESSION['system']['alert'] = $alert;
    header('Location: login.php');
endif;


//verifica se existe usuários cadastrados
$lerUsers = new Read();
$lerUsers->ExeRead('users');
if (!$lerUsers->getResult()):
    //se não encontrar usuários cadastrados, redireciona para a página de registro
    header('Location: register.php');
endif;
//se tiver vindo de uma solicitação de LOGOFF, exibe a mensagem de logoff efetuado com sucesso
if ($pg && $pg === 'logoff'):
    unset($_SESSION['userlogin'], $_SESSION['system']);
    $logoff = 'logoff';
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PMC - Dívida Ativa | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="./"><b>PMC - </b>Dívida Ativa</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Informe e-mail e senha para prosseguir!</p>
          <?php
          $login = new Login(1);
          if ($login->CheckLogin()):
              header('Location: ./');
          endif;
          $datalogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          if (!empty($datalogin) && isset($datalogin['login'])):
              $login->ExeLogin($datalogin);
              if (!$login->getResult()):
                  header('Location: login.php?alert=dados_incorretos');
              else:
                  header('Location: ./');
              endif;
          endif;
          if (isset($_SESSION['system']['alert'])):
              if ($_SESSION['system']['alert'] === 'dados_incorretos'):
                  ?>
                  <div class="alert alert-warning alert-dismissible text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-unsorted"></i> Atenção!</h5>
                      <i class="fa fa-lock"></i> Os dados NÃO conferem!
                  </div>
                  <?php
              elseif ($_SESSION['system']['alert'] === 'nuser-ok'):0
                  ?>
                  <div class="alert alert-success alert-dismissible text-center">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-check-square"></i> Sucesso!</h5>
                      <i class="fa fa-thumbs-up"></i> Novo usuário cadastrado!
                  </div>
                  <?php
              endif;
          endif;
          if (isset($logoff) && $logoff === 'logoff'):
              ?>
              <div class="alert alert-success alert-dismissible text-center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check-square"></i> Deslogou!</h5>
                  <i class="fa fa-thumbs-up"></i> Você encerrou corretamente a sessão!
              </div>
              <?php
          endif;
          ?>

          <form action="" method="post">
              <div class="input-group mb-3">
                  <input name="user" type="email" class="form-control" placeholder="Email">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                      </div>
                  </div>
              </div>
              <div class="input-group mb-3">
                  <input name="pass" type="password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-8"></div>
                  <div class="col-4">
                      <button name="login" type="submit" class="btn btn-primary btn-block">Logar</button>
                  </div>
                  <!-- /.col -->
              </div>
          </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
