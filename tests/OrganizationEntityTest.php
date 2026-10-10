<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\OrganizationEntity;
use JDZ\JsonLd\ImageObjectEntity;

class OrganizationEntityTest extends TestCase
{
    public function testMakeBasic(): void
    {
        $org = new OrganizationEntity();
        $result = $org->make('Acme Corp', 'https://acme.com', '');

        $this->assertEquals('Acme Corp', $org->get('name'));
        $this->assertEquals('https://acme.com', $org->get('url'));
        $this->assertFalse($org->has('logo'));
        $this->assertSame($org, $result);
    }

    public function testMakeWithOptionalFields(): void
    {
        $org = new OrganizationEntity();
        $org->make('Acme', 'https://acme.com', '', 'info@acme.com', '+1234567890');

        $this->assertEquals('info@acme.com', $org->get('email'));
        $this->assertEquals('+1234567890', $org->get('telephone'));
    }
}
