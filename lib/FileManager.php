<?php //PAS FAIRE ATTENTION A CE FICHIER, IL N'A PAS ÉTÉ RÉUTILISÉ (ICI UTILE POUR FAIRE DES RÉDIRECTIONS)

class FileManager {
    private string $filename;
    private string $tmpName;
    private int $size;
    private int $sizeMax;
    private string $ext;
    private array $extAllowed;
    private string $type;
    private string $error;
    private array $file;

    /**
     * On autorise par défaut 3 formats (jpeg, jpg, png) et on limite à 2 Mo max
     *
     * @param array $file
     * @param array|null $extAllow
     * @param integer|null $sizeLimit
     */
    public function __construct(array $file, ?array $extAllow = ["jpeg", "jpg", "png"], ?int $sizeLimit = 2097152) {
        $this->file = $file;
        $this->filename = $this->file['image']['name'];
        $this->size = $_FILES['image']['size'];
        $this->tmpName = $_FILES['image']['tmp_name'];
        $this->type = $_FILES['image']['type'];
        $this->ext = strtolower(end(explode('.', $_FILES['image']['name'])));
        $this->extAllowed = $extAllow;
        $this->sizeMax = $sizeLimit;
    }

    public function isValid(): bool {
        // Test code error upload
        try {

            if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
                if (!$this->isExtentionMax()) throw new Exception("Extention non authorisé");
            } else throw new Exception("Une erreur est survenue lors de l'upload");
        } catch (\Throwable $th) {
            //throw $th;
        }
        return true;
    }

    public function isExtentionMax() {
        return !in_array($this->ext, $this->extAllowed) ? false : true;
    }

    public function isSizeAllowed() {
        return $this->size < $this->sizeMax ? true : false;
    }

    public function moveTo(string $pathTo) {
        move_uploaded_file($this->tmpName,  "$pathTo/{$this->fileName}");
    }
}
