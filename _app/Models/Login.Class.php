<?php
/** Login.Class [HELPER]
 * Responsável por autenticar, validar e checar usuário do sistema de login.
 * 
 * @author Cleber C. Santos
 */
class Login {
    private $level;
    private $Email;
    private $Senha;
    private $Error;
    private $Result;

    function __construct($level) {
        $this->level = (int) $level;
    }

    public function ExeLogin(array $UserData) {
        $this->Email = (string) strip_tags(trim($UserData['user']));
        $this->Senha = (string) strip_tags(trim($UserData['pass']));
        $this->setLogin();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    /**
     * <b>Checar Login:</b> Execute esse metodo para verificar a sessão USERLOGIN 
     * e revalidar o acesso para proteger telas restritas
     * @return BOOLEAN $login = retorna TRUE ou mata a sessão e retorna FALSE!
     */
    public function CheckLogin() {
        if (empty($_SESSION['userlogin']) || $_SESSION['userlogin']['user_level'] < $this->level):
            unset($_SESSION['userlogin']);
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    //PRIVATES
    private function setLogin() {
        if (!$this->Email || !$this->Senha || !Check::Email($this->Email)):
            $this->Error = ['Informe seu e-mail e senha para efetuar o login!', WS_INFOR];
            $this->Result = FALSE;
        elseif (!$this->getUser()):
            $this->Error = ['Dados incorretos!', WS_ALERT];
            $this->Result = FALSE;
        elseif ($this->Result['user_level'] < $this->level):
            $this->Error = ["Desculpe {$this->Result['nome']}, Você não tem permissão para acessar esta área", WS_ERROR];
            $this->Result = FALSE;
        else:
            $this->Execute();
        endif;
    }

    private function getUser() {
        $this->Senha = md5($this->Senha);
        $read = new Read;
        $read->ExeRead("users", "WHERE user_email = :e AND user_password = :p", "e={$this->Email}&p={$this->Senha}");
        if ($read->getResult()):
            $this->Result = $read->getResult()[0];
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    private function Execute() {
        if (!session_id()):
            session_start();
        endif;
        $_SESSION['userlogin'] = $this->Result;
        $this->Error = ["Olá, {$this->Result['nome']}, Seja bem vindo(a). Aguarde redirecionamento", WS_ACCEPT];
        $this->Result = TRUE;
    }

}
