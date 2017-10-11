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
use NumoBundle\Entity\Partner;
use NumoBundle\Services\UserUploader;
use Symfony\Component\HttpFoundation\RequestStack;


class PartnerUploadListener
{
    private $uploader;
    private $oldFile;

    public function __construct(UserUploader $fileUpload, RequestStack $requestStack)
    {
        $this->uploader = $fileUpload;
        $this->requestStack = $requestStack;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Partner) {
            return;
        }
        $masterRequest = $this->requestStack->getMasterRequest()->get('_route');
        if ($masterRequest == 'partner_edit') {
            $this->oldFile = $entity->getImageUrl();
            if ($fileName = $entity->getImageUrl()) {
                $entity->setImageUrl(new File($this->uploader->getTargetDir() . '/' . $fileName));
            }
        }

    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Partner){
            return;
        }

        $this->uploadFile($entity);

        if ($this->oldFile) {
            $entity->setImageUrl($this->oldFile);

        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Partner) {
            return;
        }
        if (is_file($entity->getImageUrl())) {
            unlink($entity->getImageUrl());
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Partner) {
            return;
        }

        $file = $entity->getImageUrl();
        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setImageUrl($fileName);
        }

    }
}