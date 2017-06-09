<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 08/06/17
 * Time: 17:01
 */

namespace NumoBundle\Services;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PdfUpload
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $fileName);
        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
