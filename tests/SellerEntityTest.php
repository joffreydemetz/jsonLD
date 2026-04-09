<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\SellerEntity;
use JDZ\JsonLd\OrganizationEntity;

class SellerEntityTest extends TestCase
{
    public function testExtendsOrganization(): void
    {
        $seller = new SellerEntity();

        $this->assertInstanceOf(OrganizationEntity::class, $seller);
    }

    public function testMake(): void
    {
        $seller = new SellerEntity();
        $result = $seller->make('My Shop', 'https://shop.com', '');

        $this->assertEquals('My Shop', $seller->get('name'));
        $this->assertEquals('https://shop.com', $seller->get('url'));
        $this->assertSame($seller, $result);
    }
}
