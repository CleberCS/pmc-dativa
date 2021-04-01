<?php

/**
 * Upload.Class [HELPER]
 * classe responsável por uploads de imagens, arquivos e midias 
 *
 * @author Cleber C. Santos
 */
class Upload {

    private $File;
    private $Name;
    private $Send;

    /** UPLOAD DE IMAGEM */
    private $Width;
    private $Image;

    /** RESULTSET */
    private $Result;
    private $Error;

    /** DIRETÓRIOS */
    private $Folder;
    private static $BaseDir;

    function __construct($BaseDir = NULL) {
        self::$BaseDir = ((string) $BaseDir ? $BaseDir : 'midias/');
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)):
            mkdir(self::$BaseDir, 0777, TRUE);
        endif;
    }

    public function Image(array $Image, $Name = NULL, $Width = NULL, $Folder = NULL) {
        $this->File = $Image;
        $this->Name = ((string) $Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')));
        $this->Width = ((int) $Width ? $Width : 5120);
        $this->Folder = ((string) $Folder ? $Folder : '');

        //$this->CheckFolder($this->Folder);
        $this->setFileName();
        $this->UploadImage();
    }

    public function File(array $File, $Name = NULL, $Folder = NULL, $MaxFileSize = NULL) {
        $this->File = $File;
        $this->Name = ((string) $Name ? $Name : substr($File['name'], 0, strrpos($File['name'], '.')));
        $this->Folder = ((string) $Folder ? $Folder : '');
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 2);
        $FileAccept = [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
            'application/pdf',
            'text/plain'
        ];
        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = FALSE;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = FALSE;
            $this->Error = "Tipo de arquivo não suportado, envie arquivo .DOC, .DOCX, .PDF ou .TXT.";
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }
    
    public function FileOfx(array $File, $Name = NULL, $Folder = NULL, $MaxFileSize = NULL) {
        $this->File = $File;
        $this->Name = ((string) $Name ? $Name : substr($File['name'], 0, strrpos($File['name'], '.')));
        $this->Folder = ((string) $Folder ? $Folder : '');
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 2);
        $FileAccept = [
            'application/octet-stream'
        ];
        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = FALSE;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = FALSE;
            $this->Error = "Tipo de arquivo não suportado, envie arquivo \".ofx\"";
        else:
//            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    public function Media(array $Media, $Name = NULL, $Folder = NULL, $MaxFileSize = NULL) {
        $this->File = $Media;
        $this->Name = ((string) $Name ? $Name : substr($Media['name'], 0, strrpos($Media['name'], '.')));
        $this->Folder = ((string) $Folder ? $Folder : 'medias');
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 40);

        $FileAccept = [
            'video/mp4',
            'audio/mp3'
        ];

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = FALSE;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = FALSE;
            $this->Error = "Tipo de arquivo não suportado, envie arquivo .MP3 ou .MP4!";
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

    //PRIVATE METHODS
    private function CheckFolder($Folder) {
        list($y, $m) = explode('/', date('Y/m'));
        $this->CreateFolder("{$Folder}");
        $this->CreateFolder("{$Folder}/{$y}");
        $this->CreateFolder("{$Folder}/{$y}/{$m}/");
        $this->Send = "{$Folder}/{$y}/{$m}/";
    }

    private function CreateFolder($Folder) {
        if (!file_exists(self::$BaseDir . $Folder) && !is_dir(self::$BaseDir . $Folder)):
            mkdir(self::$BaseDir . $Folder, 0777, TRUE);
        endif;
    }

    private function setFileName() {
        $FileName = check::Name($this->Name) . strrchr($this->File['name'], '.');
        if (file_exists(self::$BaseDir . $this->Send . $FileName)):
            $FileName = check::Name($this->Name) . '-' . time() . strrchr($this->File['name'], '.');
        endif;
        $this->Name = $FileName;
    }

    //FAZ O UPLOAD DA IMAGEM FAZENDO TAMBÉM O REDIMENSIONAMENTO

    private function UploadImage() {
        switch ($this->File['type']):
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->Image = imagecreatefromjpeg($this->File['tmp_name']);
                break;
            case 'image/png':
            case 'image/x-png':
                $this->Image = imagecreatefrompng($this->File['tmp_name']);
                break;
        endswitch;

        if (!$this->Image):
            $this->Result = FALSE;
            $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG';
        else:
            $x = imagesx($this->Image);
            $y = imagesy($this->Image);
            $ImageX = ($this->Width < $x ? $this->Width : $x);
            $imageH = ($ImageX * $y) / $x;
            $NewImage = imagecreatetruecolor($ImageX, $imageH);
            imagealphablending($NewImage, FALSE);
            imagesavealpha($NewImage, TRUE);
            imagecopyresampled($NewImage, $this->Image, 0, 0, 0, 0, $ImageX, $imageH, $x, $y);
            switch ($this->File['type']):
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
                case 'image/png':
                case 'image/x-png':
                    imagepng($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
            endswitch;

            if (!$NewImage):
                $this->Result = FALSE;
                $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG';
            else:
                $this->Result = $this->Name;
                $this->Error = NULL;
            endif;

            imagedestroy($this->Image);
            imagedestroy($NewImage);

        endif;
    }

    //ENVIA ARQUIVOS E MIDIAS

    private function MoveFile() {
        if (move_uploaded_file($this->File['tmp_name'], self::$BaseDir . $this->Send . $this->Name)):
            $this->Result = $this->Send . $this->Name;
            $this->Error = NULL;
        else:
            $this->Result = FALSE;
            $this->Error = 'Erro ao mover arquivo. Por favor tente depois!';
        endif;
    }

}
