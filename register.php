<?php
session_start();
ob_start();
require_once '_app/Config.inc.php';
$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PMC - Dívida Ativa| Registrar</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="./"><b>PMC - Dívida Ativa</b>Registrar</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>
                    <?php
                    if ($post && isset($post['gravar'])):
                        unset($post['gravar']);
                        //verifica se já existe o e-mail cadastrado
                        $verificaEmail = new Read();
                        $verificaEmail->ExeRead('users', "WHERE user_email = :e", "e={$post['user_email']}");
                        if (!$verificaEmail->getResult()):
                            //verifica se as senhas informadas conferem
                            if ($post['user_password'] != $post['user_password_rt']):
                                ?>
                                <div class="alert alert-danger alert-dismissible text-center">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                                    <i class="fa fa-lock"></i> Senhas NÃO conferem!
                                </div>
                                <?php
                            else:
                                unset($post['user_password_rt']);
                                $post['user_password'] = md5($post['user_password']);
                                //grava usuário
                                $gravaUser = new Create();
                                $gravaUser->ExeCreate('users', $post);
                                if ($gravaUser->getResult()):
                                    header('Location: login.php?alert=nuser-ok');
                                endif;
                            endif;
                        else:
                            ?>
                            <div class="alert alert-danger alert-dismissible text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Alerta!</h5>
                                <i class="fa fa-lock"></i> E-mail já utilizado!
                            </div>
                        <?php
                        endif;
                    endif;
                    ?>
                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="hidden" class="form-control" name="criado_por" value="0">
                            <input type="hidden" class="form-control" name="criado_em" value="<?= date('Y-m-d H:i:s'); ?>">
                            <input name="user_nome" type="text" class="form-control" placeholder="Nome" required
                                   value="<?= (isset($post['user_nome']) ? $post['user_nome'] : '') ?>" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="user_sobrenome" type="text" class="form-control" placeholder="Sobrenome" required
                                   value="<?= (isset($post['user_sobrenome']) ? $post['user_sobrenome'] : '') ?>" >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="user_email" type="email" class="form-control" placeholder="Email" required
                                   value="<?= (isset($post['user_email']) ? $post['user_email'] : '') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="user_password" type="password" class="form-control" placeholder="Senha" required
                                   value="<?= (isset($post['user_password']) ? $post['user_password'] : '') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="user_password_rt" type="password" class="form-control" placeholder="Repetir a Senha" required
                                   value="<?= (isset($post['user_password_rt']) ? $post['user_password_rt'] : '') ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input name="user_termos" type="checkbox" id="agreeTerms" required>
                                    <label for="agreeTerms">
                                        Eu aceito os <a href="#">termos</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button name="gravar" type="submit" class="btn btn-primary btn-block">Registrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

      <form action="../../index.html" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
