<?php
/**
 * Classe responsavel por gerenciar os posts em geral, adaptável a outros tipos de cadastros (utilizado no admin)
 *
 * @author Cleber
 */
class AdminPost {

    private $Data;
    private $Post;
    private $Error;
    private $Result;

    // Nome da tabela no banco de dados

    const entity = 'sh_quartos';

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        if (in_array('', $this->Data)):
            $this->Error = ['Erro ao cadastrar: Favor preencher todos os campos', WS_ALERT];
            $this->Result = FALSE;
        else:
            $this->SetData();
            if ($this->Data['capa']):
                $imagemCapa = 'capa-'. time();
                $upload = new Upload('../midias/hoteis/hot-' . $this->Data['nome'] . '/');
                $upload->Image($this->Data['capa'], $imagemCapa, 600);
            endif;
            if (isset($upload) && $upload->getResult()):
                $this->Data['capa'] = $imagemCapa;
                $this->Create();
            else:
                $this->Data['capa'] = NULL;
                $this->Create();
            endif;
        endif;
    }

    public function upGallery(array $imagens, $QtoId) {
        $this->QtoId = (int) $QtoId;
        $this->Data = $imagens;
        $imagemNome = new Read;
        $imagemNome->ExeRead(self::entity, "WHERE qto_id = :id", "id={$this->QtoId}");
        if (!$imagemNome->getResult()):
            $this->Error = ["Erro ao enviar galeria: O índice {$this->QtoId} não foi encontrado no banco!", WS_ERROR];
            $this->Result = FALSE;
        else:
            $imgQtoId = $imagemNome->getResult()[0]['qto_id'];
            $imagemNome = $imagemNome->getResult()[0]['qto_id'];
            $gbFiles = array();
            $gbCount = count($this->Data['tmp_name']);
            $gbKeys = array_keys($this->Data);
            for ($gb = 0; $gb < $gbCount; $gb++):
                foreach ($gbKeys as $Keys):
                    $gbFiles[$gb][$Keys] = $this->Data[$Keys][$gb];
                endforeach;
            endfor;
            $sendGallery = New Upload('../midias/quartos/gal-' . $imagemNome. '/');
            $img = 0;
            $upl = 0;
            foreach ($gbFiles as $gbUpload):
                $img++;
                $imgNome = "qto-{$imagemNome}-img-{$img}-" . (substr(md5(time() + $img), 0, 5));
                $sendGallery->Image($gbUpload, $imgNome);
                if ($sendGallery->getResult()):
                    $gbImagem = $sendGallery->getResult();
                    $gbCreate = ['gal_qto_id' => $imgQtoId, 'gal_imagem_nome' => $imgNome, 'criado_em' => date('Y-m-d H:i:s')];
                    $gravaGaleria = new Create();
                    $gravaGaleria->ExeCreate('sh_galeria_qtos', $gbCreate);
                    $upl++;
                endif;
            endforeach;
            if ($upl > 1):
                $this->Error = ["Galeria Enviada com sucesso: Foram inseridas {$upl} imagens na galeria do <span style=\"font-weight:bolder;\">Quarto {$imagemNome}</span>!", WS_ACCEPT];
                $this->Result = \TRUE;
            endif;
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

//PRIVATES
    private function SetData() {
        $capa = $this->Data['capa'];
        $descricao = $this->Data['descricao'];
        unset($this->Data['capa'], $this->Data['descricao']);

        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);

        $this->Data['criado_em'] = check::Data($this->Data['criado_em']);
        $this->Data['capa'] = $capa;
        $this->Data['descricao'] = $descricao;
    }

    private function Create() {
        $cadastra = new Create();
        $cadastra->ExeCreate(self::entity, $this->Data);
        if ($cadastra->getResult()):
            $this->Error = ["O quarto {$this->Data['qto_numero']} foi cadastrado com sucesso", WS_ACCEPT];
            $this->Result = $cadastra->getResult();
        endif;
    }
}
