<?php

namespace lightningsdk\photogallery\Pages;

use Lightning\Pages\Table;
use Lightning\Tools\ClientUser;

class AdminGalleries extends Table {
    const TABLE = 'photo_gallery';
    const PRIMARY_KEY = 'gallery_id';

    public function hasAccess() {
        return ClientUser::requireAdmin();
    }

    public function initSettings() {
        $this->action_fields['edit_images'] = [
            'type' => 'link',
            'url' => '/admin/galleries/images?gallery_id=',
        ];
    }
}
