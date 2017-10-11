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
use Symfony\Component\HttpFoundation\RequestStack;

class CompanyUploadListener
{
    private $uploader;
    private $oldPdf;
    private $oldImgUrl;

    public function __construct(UserUploader $fileUpload, RequestStack $requestStack)
    {
        $this->uploader = $fileUpload;
        $this->requestStack = $requestStack;

    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Company) {
            return;
        }
        $masterRequest = $this->requestStack->getMasterRequest()->get('_route');
        if($masterRequest == 'company_edit'){
            $this->oldPdf = $entity->getPdf();
            $this->oldImgUrl = $entity->getImageUrl();
            if ($fileName = $entity->getPdf()) {
                $entity->setPdf(new File($this->uploader->getTargetDir().'/'.$fileName));
            }
            if ($fileName = $entity->getImageUrl()) {
                $entity->setImageUrl(new File($this->uploader->getTargetDir().'/'.$fileName));
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

        if (!$entity instanceof Company) {
            return;
        }

        $this->uploadFile($entity);

        if ($this->oldPdf) {
            $entity->setPdf($this->oldPdf);
        } elseif($this->oldImgUrl) {
            $entity->setImageUrl($this->oldImgUrl);
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

        $pdf = $entity->getPdf();
        $imgUrl = $entity->getImageUrl();

        // only upload new files
        if ($pdf instanceof UploadedFile) {
            $fileName = $this->uploader->upload($pdf);
            $entity->setPdf($fileName);
        }

        if ($imgUrl instanceof UploadedFile) {
            $fileName = $this->uploader->upload($imgUrl);
            $entity->setImageUrl($fileName);
        }
    }
}