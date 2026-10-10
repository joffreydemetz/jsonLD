<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\PersonEntity;

class PersonEntityTest extends TestCase
{
    public function testMake(): void
    {
        $person = new PersonEntity();
        $result = $person->make('John Doe');

        $this->assertEquals('John Doe', $person->get('name'));
        $this->assertSame($person, $result);
    }
}
