<?php
namespace MotogpBundle\Admin\Media;


trait FeaturedMediaAdminTrait  {

    private function saveFeaturedMedia($object) {

        $featuredMediaAdmin = $this
            ->getConfigurationPool()
            ->getAdminByAdminCode('motogp.admin.featured_media');

        if ($object->getFeaturedMedia() && !$object->getFeaturedMedia()->isEnabled()) {
            $object->setFeaturedMedia(null);
            $featuredMediaAdmin->deleteHook($object->getFeaturedMedia());
            return;
        }

        if ($object->getFeaturedMedia() && $object->getFeaturedMedia()->getUploadFile() ) {
            $featuredMediaAdmin->saveHook($object->getFeaturedMedia());
        }
    }

}