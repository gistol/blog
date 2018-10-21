<?php

namespace App\Service;

use App\Entity\Image;
use Cocur\Slugify\SlugifyInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\Polyfill\FileExtensionTrait;

class ImageNamer implements NamerInterface
{
    use FileExtensionTrait;

    private $slugify;

    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        /** @var UploadedFile $file */
        $file = $mapping->getFile($object);

        /** @var Image $object */
        $originalName = basename($file->getClientOriginalName(), $file->getClientOriginalExtension());
        $slug = $this->slugify->slugify($originalName, ['ruleset' => 'turkish']);

        /** @see \Symfony\Component\HttpKernel\Profiler\Profiler::collect() */
        $name =  $slug . '-' . substr(hash('sha256', uniqid(mt_rand(), true)), 0, 6);

        if ($extension = $this->getExtension($file)) {
            $name = sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }
}