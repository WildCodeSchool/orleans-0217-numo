<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 04/07/17
 * Time: 15:56
 */

namespace NumoBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use NumoBundle\Entity\Published;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NumoBundle\Entity\Event;
use NumoBundle\Services\UserUploader;
use Symfony\Component\HttpFoundation\RequestStack;


class EventUploadListener
{
    private $uploader;
    private $oldFile;

    public function __construct(UserUploader $uploader, RequestStack $requestStack)
    {
        $this->uploader = $uploader;
        $this->requestStack = $requestStack;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($this->oldFile) {
            $entity->setImageUrl($this->oldFile);

        } else {
            $this->uploadFile($entity);
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Event || $entity instanceof Published) {
            $masterRequest = $this->requestStack->getMasterRequest()->get('_route');
            if($masterRequest == 'event_edit') {
                $this->oldFile = $entity->getImage();
                if ($fileName = $entity->getImage()) {
                    $entity->setImage(new File($this->uploader->getTargetDir() . '/' . $fileName));
                }
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Event || $entity instanceof Published) {
            if (is_file($entity->getImage())) {
                unlink($entity->getImage());
            }
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if ($entity instanceof Event || $entity instanceof Published) {
            $file = $entity->getImage();
            // only upload new files
            if (!$file instanceof UploadedFile) {
                return;
            }
            $fileName = $this->uploader->upload($file);
            $entity->setImage($fileName);
        }
    }
}