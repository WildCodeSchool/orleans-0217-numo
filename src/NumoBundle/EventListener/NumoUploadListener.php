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
use NumoBundle\Services\UserUploader;


class NumoUploadListener
{
    private $uploader;

    public function __construct(UserUploader $fileUpload)
    {
        $this->uploader = $fileUpload;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Company) {
            return;
        }

        if ($fileName = $entity->getImageUrl()) {
            $entity->setImageUrl(new File($this->uploader->getTargetDir().'/'.$fileName));
        }

    }
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Company) {
            return;
        }
        if(is_file($entity->getImageUrl())) {
            unlink($entity->getImageUrl());
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Company) {
            return;
        }

        $file = $entity->getImageUrl();
        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }
        $fileName = $this->uploader->upload($file);
        $entity->setImageUrl($fileName);
    }
}