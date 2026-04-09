<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\BrandEntity;

class BrandEntityTest extends TestCase
{
    public function testType(): void
    {
        $brand = new BrandEntity();

        $this->assertEquals('Brand', $brand->get('@type'));
    }

    public function testMakeBasic(): void
    {
        $brand = new BrandEntity();
        $result = $brand->make('Nike');

        $this->assertEquals('Nike', $brand->get('name'));
        $this->assertFalse($brand->has('logo'));
        $this->assertFalse($brand->has('url'));
        $this->assertSame($brand, $result);
    }

    public function testMakeWithLogoAndUrl(): void
    {
        $brand = new BrandEntity();
        $brand->make('Nike', 'https://nike.com/logo.png', 'https://nike.com');

        $this->assertEquals('Nike', $brand->get('name'));
        $this->assertEquals('https://nike.com/logo.png', $brand->get('logo'));
        $this->assertEquals('https://nike.com', $brand->get('url'));
    }
}
