<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\ImageObjectEntity;

class ImageObjectEntityTest extends TestCase
{
    public function testType(): void
    {
        $image = new ImageObjectEntity();

        $this->assertEquals('ImageObject', $image->get('@type'));
    }

    public function testMakeWithLocalImage(): void
    {
        $tmpFile = sys_get_temp_dir() . '/jdz_test_' . uniqid() . '.png';

        // Create a minimal 1x1 PNG
        $img = imagecreatetruecolor(100, 50);
        imagepng($img, $tmpFile);
        imagedestroy($img);

        try {
            $image = new ImageObjectEntity();
            $result = $image->make($tmpFile);

            $this->assertEquals($tmpFile, $image->get('url'));
            $this->assertEquals(100, $image->get('width'));
            $this->assertEquals(50, $image->get('height'));
            $this->assertSame($image, $result);
        } finally {
            unlink($tmpFile);
        }
    }

    public function testMakeWithUnreadableImageSetsOnlyUrl(): void
    {
        // A local path that does not exist: no network, and no PHP warning (failOnWarning)
        $missing = sys_get_temp_dir() . '/jdz-jsonld-missing-' . uniqid() . '.jpg';

        $image = new ImageObjectEntity();
        $image->make($missing);

        $this->assertEquals($missing, $image->get('url'));
        $this->assertFalse($image->has('width'));
        $this->assertFalse($image->has('height'));
    }

    public function testUrlToImageObjectEntityFromBaseEntity(): void
    {
        $tmpFile = sys_get_temp_dir() . '/jdz_test_' . uniqid() . '.png';

        $img = imagecreatetruecolor(200, 100);
        imagepng($img, $tmpFile);
        imagedestroy($img);

        try {
            $entity = new ImageObjectEntity();
            $imageObj = $entity->urlToImageObjectEntity($tmpFile);

            $this->assertInstanceOf(ImageObjectEntity::class, $imageObj);
            $this->assertEquals($tmpFile, $imageObj->get('url'));
            $this->assertEquals(200, $imageObj->get('width'));
            $this->assertEquals(100, $imageObj->get('height'));
        } finally {
            unlink($tmpFile);
        }
    }
}
