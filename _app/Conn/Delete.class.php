<?php

/**Delete.class 
 * Classe responsável pela Exclusão de registros no banco de dados 
 * @author Cleber C. Santos
 */
class Delete extends Conn {

    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;

    /**
     * <b>ExeDelete:</b> Deleta um cadastro na tabela 
     * @param STRING  $tabela Informe o nome da tabela no banco
     */
    public function ExeDelete($Tabela, $Termos, $ParseString) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /** <b>Obtem o resultado, ultimo id inserido</b>* */
    public function getResult() {
        return $this->Result;
    }

    /** <b>Obtem o resultado, ultimo id inserido</b>* */
    public function getRowCount() {
        return $this->Delete->rowCount();
    }

    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->getSyntax();                
        $this->Execute();
    }

    /*     * ************************************************
     * *************** PRIVATE METHODS *****************
     * ************************************************ */

//obtem o PDO e prepara a QUERY    
    private function Connect() {
        $this->Conn =  parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

//cria a SYNTAXE da query para o prepare statements
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }
    private function Execute() {
        $this->Connect();
        try{
            $this->Delete->execute($this->Places);
            $this->Result = TRUE;
        } catch (PDOException $e) {
            $this->Result = NULL;
            WSerro("<b>Erro Deletar o registro:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}