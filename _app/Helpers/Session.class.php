<?php

/** Session.Class [HELPER]
 * Classe responsável pela estatísticas, sessões, cache e atualizações de tráfego do sistema.
 *
 * @author Cleber C. Santos
 */
class Session {

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;

    function __construct($Cache = NULL) {
        session_start();
        $this->CheckSession($Cache);
    }

    //VERIFICA E EXECUTA TODOS OS MÉTODOS DA CLASSE
    private function CheckSession($Cache = NULL) {
        $this->Date = date('Y-m-d');
        $this->Cache = ( (int) $Cache ? $Cache : 20);

        if (empty($_SESSION['useronline'])):
            $this->setTraffic();
        else:

        endif;
        $this->Date = NULL;
    }
 
        //verifica e insere o trafego na tabela
    private function setTraffic() {
        $this->getTraffic();
        if (!$this->Traffic):
        $ArrSiteViews = ['siteviews_date' => $this->Date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1];
        $CreateSiteViews = new Create;
        $CreateSiteViews->ExeCreate('ws_siteviews', $ArrSiteViews);
            else:

        endif;
    }


    // obtem dados da tabela [ HELPER TRAFFIC]  
    //ws_siteviews
    private function getTraffic() {
        $readSiteViews = new Read;
        $readSiteViews->ExeRead('ws_siteviews', "WHERE siteviews_date = :date", "date = {$this->Date}");
        if ($readSiteViews->getRowCount()):
            $this->Traffic = $readSiteViews->getResult()[0];
        endif;
    }
    // Verifica, cria e atualiza o cookie  [ HELPER TRAFFIC]  
        private function getCookie() {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        if (!$Cookie):
            return FALSE;
        else:
            return TRUE;
        endif;
        setcookie("useronline", base64_encode("ccs"), time() + 86400);
    }


}
