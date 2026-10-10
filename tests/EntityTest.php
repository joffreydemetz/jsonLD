<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\OfferEntity;
use JDZ\JsonLd\PersonEntity;
use JDZ\JsonLd\WebPageEntity;

class EntityTest extends TestCase
{
    public function testSetAndGet(): void
    {
        $entity = new PersonEntity();
        $entity->set('name', 'John');

        $this->assertEquals('John', $entity->get('name'));
    }

    public function testGetReturnsDefaultWhenMissing(): void
    {
        $entity = new PersonEntity();

        $this->assertNull($entity->get('missing'));
        $this->assertEquals('fallback', $entity->get('missing', 'fallback'));
    }

    public function testHas(): void
    {
        $entity = new PersonEntity();
        $entity->set('name', 'John');

        $this->assertTrue($entity->has('name'));
        $this->assertFalse($entity->has('email'));
    }

    public function testClear(): void
    {
        $entity = new PersonEntity();
        $entity->set('name', 'John');
        $entity->clear('name');

        $this->assertFalse($entity->has('name'));
    }

    public function testClearNonExistentKeyDoesNotError(): void
    {
        $entity = new PersonEntity();
        $result = $entity->clear('nonexistent');

        $this->assertSame($entity, $result);
    }

    public static function setValues(): array
    {
        return [
            'an empty string is no property' => ['', false],
            'null is no property' => [null, false],
            'false is no property' => [false, false],
            'an empty array is no property' => [[], false],
            // set() used `if ($value)`: zeros were dropped too
            'the integer 0 is a value' => [0, true],
            'the float 0.0 is a value' => [0.0, true],
            "the string '0' is a value" => ['0', true],
        ];
    }

    #[DataProvider('setValues')]
    public function testSetSkipsEmptyValuesButKeepsZero(mixed $value, bool $kept): void
    {
        $entity = (new PersonEntity())->set('value', $value);

        $this->assertSame($kept, $entity->has('value'));
    }

    public function testAFreeOfferKeepsItsPrice(): void
    {
        $offer = (new OfferEntity())->make('0', 'EUR');

        $this->assertSame('0', $offer->get('price'));
    }

    public function testConstructorWithContextSetsContext(): void
    {
        $entity = new PersonEntity(true);

        $this->assertEquals('https://schema.org', $entity->get('@context'));
        $this->assertEquals('Person', $entity->get('@type'));
    }

    public function testConstructorWithoutContextOmitsContext(): void
    {
        $entity = new PersonEntity(false);

        $this->assertFalse($entity->has('@context'));
    }

    public function testExportWithContext(): void
    {
        $entity = new PersonEntity(true);
        $entity->make('John');

        $html = $entity->export();

        $this->assertStringContainsString('<script type="application/ld+json">', $html);
        $this->assertStringContainsString('</script>', $html);
        $this->assertStringContainsString('"@context": "https://schema.org"', $html);
        $this->assertStringContainsString('"@type": "Person"', $html);
        $this->assertStringContainsString('"name": "John"', $html);
    }

    public function testExportWithoutContextReturnsEmpty(): void
    {
        $entity = new PersonEntity(false);
        $entity->make('John');

        $this->assertEquals('', $entity->export());
    }

    public function testExportMinified(): void
    {
        $entity = new PersonEntity(true);
        $entity->make('John');

        $html = $entity->export(false);

        $this->assertStringContainsString('"@type":"Person"', $html);
    }

    public function testJsonSerialize(): void
    {
        $entity = new PersonEntity();
        $entity->make('John');

        $json = json_encode($entity);
        $data = json_decode($json, true);

        $this->assertEquals('Person', $data['@type']);
        $this->assertEquals('John', $data['name']);
    }

    public function testValidateReturnsEntity(): void
    {
        $entity = new PersonEntity();
        $entity->make('John');

        $result = $entity->validate();

        $this->assertSame($entity, $result);
    }

    public function testValidateRecursesIntoNestedEntities(): void
    {
        $article = new \JDZ\JsonLd\ArticleEntity();
        $article->make('https://example.com', 'Title', 'Abstract', '2024-01-01');

        $result = $article->validate();

        $this->assertSame($article, $result);
    }

    public function testSetReturnsSelfForChaining(): void
    {
        $entity = new PersonEntity();
        $result = $entity->set('name', 'John');

        $this->assertSame($entity, $result);
    }
}
