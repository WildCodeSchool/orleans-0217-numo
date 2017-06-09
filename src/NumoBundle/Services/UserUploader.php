<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 07/06/17
 * Time: 11:44
 */

namespace NumoBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = uniqid().'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}