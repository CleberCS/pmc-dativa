<?php
//define('HOME', 'http://www.seusite.com.br');

// CONFIGURAÇÕES DO SITE ########################################
define('HOST', 'localhost');//informar o servidor de dados
define('DBSA', 'dativa_db');//informar o banco de dados
define('USER', 'root');//informar o usuário do banco de dados
define('PASS', '');//informar a senha do banco de dados

// CONFIGURAÇÕES DO SITE ########################################

// AUTOLOAD DE CLASSES   ########################################
spl_autoload_register(
        function($Class) {
    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = NULL;
    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . "\\{$dirName}\\{$Class}.class.php") && !is_dir(__DIR__ . "\\{$dirName}\\{$Class}.class.php")):
            include_once (__DIR__ . "\\{$dirName}\\{$Class}.class.php");
            $iDir = TRUE;
        endif;
    endforeach;
    if (!$iDir):
        trigger_error("Não foi possivel incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}
);

// TRATAMENTO DE ERROS   ########################################
// CSS constantes :: mensagens de erro
define('WS_ACCEPT', 'accept');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

// WSErro :: Exibe erros lançados :: FRONT
function WSErro($ErrMsg, $ErrNo, $ErrDie = NULL) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";
    if ($ErrDie):
        die;
    endif;
}

// PHPErro :: Personalisa o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na linha: {$ErrLine}</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');

// TRATAMENTO DE ERROS   ########################################

//MINHAS CONSTANTES
define('LINKBASE', "index.php?pg=");
