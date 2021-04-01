<?php

/** Classe responsável pela leitura dos registro no banco de dados */

/** Description of create
 * @author Cleber C. Santos
 */
class Read extends Conn {

    private $Select;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    /**
     * <b>ExeCreate:</b> Insere um cadastro na tabela
     * @param STRING  $tabela Informe o nome da tabela no banco
     * @param ARRAY  Dados = informe um array atribuitivos (nome da Coluna => Valor).
     */
    public function ExeRead($Tabela, $Termos = NULL, $ParseString = NULL) {
        if (!empty($ParseString)):
            parse_str($ParseString, $this->Places);
        endif;

        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    /** <b>Obtem o resultado, ultimo id inserido</b>* */
    public function getResult() {
        return $this->Result;
    }

    /** <b>Obtem o resultado, ultimo id inserido</b>* */
    public function getRowCount() {
        return $this->Read->rowCount();
    }

    public function FullRead($Query, $ParseString = NULL) {
        $this->Select = (string) $Query;
        if (!empty($ParseString)):
            parse_str($ParseString, $this->Places);
        endif;
        $this->Execute();
    }

    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->Execute();

    }

    /**************************************************
     **************** PRIVATE METHODS *****************
     **************************************************/

//obtem o PDO e prepara a QUERY
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }

//cria a SYNTAXE da query para o prepare statements
    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = NULL;
            WSerro("<b>Erro ao selecionar registro:</b> {$e->getMessage()}", $e->getLine());
        }
    }

}
