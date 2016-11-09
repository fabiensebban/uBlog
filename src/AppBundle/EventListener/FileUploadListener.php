<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Post;
use AppBundle\Services\FileUploader;

class FileUploadListener
{
    private $uploader;
    private $targetPath;

    public function __construct(FileUploader $uploader, $targetPath)
    {
        $this->uploader = $uploader;
        $this->targetPath = $targetPath;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadImage($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadImage($entity);
    }

    private function uploadImage($entity)
    {
        // upload only works for Post entities
        if (!$entity instanceof Post) {
            return;
        }

        $file = $entity->getImage();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        $entity->setImage($fileName);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // upload only works for Post entities
        if (!$entity instanceof Post) {
            return;
        }
        
        $fileName = $entity->getImage();

        $entity->setImage(new File($this->targetPath.'/'.$fileName));
    }
}