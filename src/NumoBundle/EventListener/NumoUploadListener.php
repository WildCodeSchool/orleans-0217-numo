<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 08/06/17
 * Time: 17:04
 */

namespace NumoBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NumoBundle\Entity\Company;
use NumoBundle\Services\PdfUpload;

class NumoUploadListener
{
    private $uploader;

    public function __construct(PdfUpload $uploader)
    {
        $this->uploader = $uploader;

    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    public function preUpdate(PreUpdateEventArgs $args)
    {        dump('a');

        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Company) {
            return;
        }
        if ($fileName = $entity->getPdf()) {
            $entity->setPdf(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Company) {
            return;
        }
        if(is_file($entity->getPdf())) {
            unlink($entity->getPdf());
        }
    }
    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Company) {
            return;
        }
        $file = $entity->getPdf();
        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }
        $fileName = $this->uploader->upload($file);
        $entity->setPdf($fileName);
    }
}