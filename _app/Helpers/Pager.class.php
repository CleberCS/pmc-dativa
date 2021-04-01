<?php

/*
 * Pager.Class [HELPER]
 * Classe responsável pela gestão e paginação de resultados do sistema!
 * 
 * @author Cleber Cerqueira
 */

class Pager {
    /*     * DEFINE O PAGER */

    private $Page;
    private $Limit;
    private $Offset;

    /*     * REALIZA A LEITURA */
    private $Tabela;
    private $Termos;
    private $Places;

    /*     * DEFINE O PAGINATOR */
    private $Rows;
    private $Link;
    private $MaxLinks;
    private $First;
    private $Last;

    /*     * RENDERIZA O PAGINATOR */
    private $paginator;

    function __construct($Link, $First = NULL, $Last = NULL, $MaxLinks = NULL) {
        $this->Link = (string) $Link;
        $this->First = ((string) $First ? $First : 'Primeira Página');
        $this->Last = ((string) $Last ? $Last : 'Última Página');
        $this->MaxLinks = ((int) $MaxLinks ? $MaxLinks : 5);
    }

    public function ExePager($Page, $Limit) {
        $this->Page = ((int) $Page ? $Page : 1);
        $this->Limit = (int) $Limit;
        $this->Offset = ($this->Page * $this->Limit) - $this->Limit;
    }

    public function ReturnPage() {
        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("location: {$this->Link}{$nPage}");
        endif;
    }

    function getPage() {
        return $this->Page;
    }

    function getLimit() {
        return $this->Limit;
    }

    function getOffset() {
        return $this->Offset;
    }

    public function ExePaginator($Tabela, $Termos = NULL, $ParseString = NULL) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        $this->Places = (string) $ParseString;
        $this->getSyntax();
    }

    public function getPaginator() {
        return $this->paginator;
    }

    // PRIVATE METHODS 

    private function getSyntax() {
        $read = new Read;
        $read->ExeRead($this->Tabela, $this->Termos, $this->Places);
        $this->Rows = $read->getRowCount();
        if ($this->Rows > $this->Limit):
            $Paginas = ceil($this->Rows / $this->Limit);
            $Maxlinks = $this->MaxLinks;

            $this->paginator = "<ul class=\"paginator\">";
            $this->paginator .= "<li><a title=\"{$this->First}\" href=\"{$this->Link}1\">{$this->First}</a></li>";

            for ($iPag = $this->Page - $Maxlinks; $iPag <= $this->Page - 1; $iPag++):
                if ($iPag >= 1):
                    $this->paginator .= "<li><a title=\"{$iPag}\" href=\"{$this->Link}{$iPag}\">{$iPag}</a></li>";
                endif;
            endfor;

            $this->paginator .= "<li><span class=\"active \">{$this->Page}</span></li>";

            for ($dPag = $this->Page + 1; $dPag <= $this->Page - $Maxlinks; $dPag++):
                if ($dPag <= $Paginas):
                    $this->paginator .= "<li><a title=\"{$dPag}\" href=\"{$this->Link}{$dPag}\">{$dPag}</a></li>";
                endif;
            endfor;


            $this->paginator .= "<li><a title=\"{$this->Last}\" href=\"{$this->Link}{$Paginas}\">{$this->Last}</a></li>";
            $this->paginator .= "</ul>";


        endif;
    }

}
