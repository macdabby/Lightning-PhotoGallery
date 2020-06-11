<?php

namespace lightningsdk\photogallery\Model;

use Lightning\Model\BaseObject;
use Lightning\Tools\Database;
use Lightning\Tools\IO\FileManager;

class GalleryOverridable extends BaseObject {

    const TABLE = 'photo_gallery';
    const PRIMARY_KEY = 'gallery_id';

    protected $images = null;

    public static function loadBySlug($slug) {
        $galleries = self::loadByQuery([
            'where' => [
                'slug' => $slug,
            ],
        ]);
        if (!empty($galleries)) {
            return $galleries[0];
        }
        return null;
    }

    /**
     * @throws \Exception
     */
    public function loadImages() {
        $this->images = Database::getInstance()->selectAll('photo_gallery_image', ['gallery_id' => $this->id]);
        $fileHandler = FileManager::getFileHandler('', 'images');
        foreach ($this->images as &$i) {
            $i['image'] = $fileHandler->getWebURL($i['image']);
        }
    }

    /**
     * $images is an array of arrays. The arrays contained in images should represent a row from the
     * photo_gallery_image table: image_id (not required), gallery_id (not required), image (url without extension),
     * title, and description.
     *
     * @param array $images
     */
    public function setImages($images) {
        $this->images = $images;
    }

    public function getImages() {
        if ($this->images === null) {
            $this->loadImages();
        }

        return $this->images;
    }
}
