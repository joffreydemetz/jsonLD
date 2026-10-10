<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\WebPageEntity;

class WebPageEntityTest extends TestCase
{
    public function testMake(): void
    {
        $page = new WebPageEntity();
        $result = $page->make('https://example.com/page');

        $this->assertEquals('https://example.com/page', $page->get('@id'));
        $this->assertSame($page, $result);
    }
}
