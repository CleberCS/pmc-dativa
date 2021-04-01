<?php

/** Classe responsável pela criação do registro no banco de dados */
/** Description of create
 * @author Cleber C. Santos
 */
class Create extends Conn {  
    private $Tabela;
    private $Dados;
    private $Result;
/** @var PDOStatement */
    private $Create;
/** @var PDO */
    private $Conn;
/**
 * <b>ExeCreate:</b> Insere um cadastro na tabela 
 * @param STRING  $tabela Informe o nome da tabela no banco
 * @param ARRAY  Dados = informe um array atribuitivos (nome da Coluna => Valor).
 */
    
    public function ExeCreate($Tabela, array $Dados) {
    $this->Tabela = (string) $Tabela;   
    $this->Dados = $Dados;
    $this->getSyntax();
    $this->Execute();
}
    public function getResult() {
    return $this->Result;
    
}
    
/**************************************************
 **************** PRIVATE METHODS *****************
 **************************************************/    
    private function Connect() {
    $this->Conn = parent::getConn();
    $this->Create = $this->Conn->prepare($this->Create);
}
    private function getSyntax() {
    $Fields = implode(', ', array_keys($this->Dados));
    $Places = ':' .implode(', :', array_keys($this->Dados));
    $this->Create = "INSERT INTO {$this->Tabela} ({$Fields}) VALUES ({$Places})";
}
    private function Execute() {
        $this->Connect();
        try{
            $this->Create->execute($this->Dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = NULL;
            WSerro("<b>Erro ao inserir dados:</b> {$e->getMessage()}", $e->getCode());
        }
}
}
