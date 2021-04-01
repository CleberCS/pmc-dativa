<?php
//INSTRUÇÕES INICIAIS
session_start();
ob_start();
//definindo a timezone
date_default_timezone_set('America/Sao_Paulo');
if (!isset($_SESSION['system'])):
    $_SESSION['system'] = array();
endif;
//FILTRA OS GETS GENÉRICOS DO SISTEMA E CRIA AS SESSÕES GERAIS NECESSÁRIAS
$pg = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);
//envia um alerta
$alert = filter_input(INPUT_GET, 'alert', FILTER_DEFAULT);
if (!empty($alert)):
    $_SESSION['system']['alert'] = $alert;
endif;
//INSERE O ARQUIVO DE CONFIGURAÇÕES BÁSICAS
//(Ex: dados de conexão, autoload de classes, configurações de email, etc)
require_once '_app/Config.inc.php';

echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<title>PMC - Divida Ativa</title>';

require_once 'scripts/top-scripts.php';


echo '</head>';
echo '<body class="hold-transition sidebar-mini layout-fixed">';
echo '<div class="wrapper">';
// Preloader 
//echo '<div class="preloader flex-column justify-content-center align-items-center">';
//echo '<img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">';
//echo '</div>';

// Navbar 
include_once 'includes/nav-bar.php';
// Main Sidebar Container
include_once 'includes/main-menu.php';
// INICIA PÁGINAS DE CONTEÚDO -->
foreach ($_REQUEST as $___opt => $___val) {
    $$___opt = $___val;
}
if (empty($pg)) {
    include("pages/home.php");
} elseif (substr($pg, 0, 4) == 'http' or substr($pg, 0, 1) == "/" or substr($pg, 0, 1) == ".") {
    echo '<br><font face=arial size=11px><br><b>A página não existe.</b><br>Por favor selecione uma página a partir do Menu Principal.</font>';
} else {
    include("pages/$pg.php");
}
include_once 'includes/footer.php';
// Control Sidebar 
include_once 'includes/control-sidebar.php';
echo '</div>'; // ./wrapper 
echo '</body>';
echo '</html>';
