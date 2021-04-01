<?php

/**Update.class 
 * Classe responsável pela Atualização de registros no banco de dados 
 * @author Cleber C. Santos
 */
class Update extends Conn {

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Update;

    /** @var PDO */
    private $Conn;

    /**
     * <b>ExeUpdate:</b> Atualiza um cadastro na tabela 
     * @param STRING  $tabela Informe o nome da tabela no banco
     * @param ARRAY  Dados = informe um array atribuitivos (nome da Coluna => Valor).
     */
    public function ExeUpdate($Tabela, array $Dados, $Termos, $ParseString) {
    $this->Tabela = (string) $Tabela;   
    $this->Dados = $Dados;
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
        return $this->Update->rowCount();
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
        $this->Conn = parent::getConn();
        $this->Update = $this->Conn->prepare($this->Update);
    }

//cria a SYNTAXE da query para o prepare statements
    private function getSyntax() {
        foreach($this->Dados as $key => $Value):
            $Places[] = $key .' = :' . $key; 
        endforeach;
        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }
    private function Execute() {
        $this->Connect();
        try{
            $this->Update->execute(array_merge($this->Dados, $this->Places));
            $this->Result = TRUE;
        } catch (PDOException $e) {
            $this->Result = NULL;
            WSerro("<b>Erro ao atualizar dados:</b> {$e->getMessage()}", $e->getCode());        }
    }

}