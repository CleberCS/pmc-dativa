<?php

require ('_app/library/PHPMailer/class.phpmailer.php');

/**
 * Email [MODEL]
 * Modelo responsável por configurar o PHPMailer, validar os dados e disparar os e-mails do sistema
 * @author Cleber
 */
class Email {

    /** @var PHPMailer */
    private $Mail;

    /** EMAIL DATA */
    private $Data;

    /** CORPO DO E-MAIL */
    private $Assunto;
    private $Mensagem;

    /** REMETENTE */
    private $RemetenteNome;
    private $RemetenteEmail;

    /** DESTINATÁRIO */
    private $DestinatarioNome;
    private $DestinatarioEmail;

    /** CONTROLE */
    private $Error;
    private $Result;

    function __construct() {
        $this->Mail = new PHPMailer;
        $this->Mail->setLanguage('pt');
        $this->Mail->Host = MAILHOST;
        $this->Mail->Port = MAILPORT;
        $this->Mail->Username = MAILUSER;
        $this->Mail->Password = MAILPASS;
        $this->Mail->Charset = 'UTF-8';
    }

    public function Enviar(array $Data) {
        $this->Data = $Data;
        $this->Clear();
        if (in_array('', $this->Data)):
            $this->Error = ['Erro ao enviar mensagem: Para enviar esse e-mail preencha todos os campos necessários', WS_ALERT];
            $this->Result = FALSE;
        elseif (!Check::Email($this->Data['RemetenteEmail'])):
            $this->Error = ['Erro ao enviar mensagem: O e-mail não tem um formato válido', WS_ALERT];
            $this->Result = FALSE;
        else:
            $this->SetMail();
            $this->Config();
            $this->SendMail();
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    /** PRIVATES  */
    private function Clear() {
        array_map('strip_tags', $this->Data);
        array_map('trim', $this->Data);
    }

    private function SetMail() {
        $this->Assunto = $this->Data['Assunto'];
        $this->Mensagem = $this->Data['Mensagem'];
        $this->RemetenteNome = $this->Data['RemetenteNome'];
        $this->RemetenteEmail = $this->Data['RemetenteEmail'];
        $this->DestinatarioNome = $this->Data['DestinatarioNome'];
        $this->DestinatarioEmail = $this->Data['DestinatarioEmail'];

        $this->Data = NULL;
        $this->SetMsg();
    }

    private function SetMsg() {
        $this->Mensagem = "{$this->Mensagem}<hr><small>Recebido em:" . date('d/m/y H:i') . "</small>";
    }

    private function Config() {
        //SMTP AUTH
        $this->Mail->isSMTP();
        $this->Mail->SMTPAuth = TRUE;
        $this->Mail->isHTML();

        //REMETENTE E RETORNO
        $this->Mail->From = MAILUSER;
        $this->Mail->FromName = $this->RemetenteNome;
        $this->Mail->addReplyTo($this->RemetenteEmail, $this->RemetenteNome);

        //ASSUNTO, MENSAGEM E DESTINO
        $this->Mail->Subject = $this->Assunto;
        $this->Mail->Body = $this->Mensagem;
        $this->Mail->addAddress($this->DestinatarioEmail, $this->DestinatarioNome);
    }

    private function SendMail() {
        if ($this->Mail->send()):
            $this->Error = ['E-mail enviado com sucesso, aguarde nosso contato!', WS_ACCEPT];
            $this->Result = TRUE;            
        else:
            $this->Error = ["Erro ao enviar mensagem: Entre em contato com o admin. ( {$this->Mail->ErrorInfo} )", WS_ERROR];
            $this->Result = FALSE;
        endif;
    }
}