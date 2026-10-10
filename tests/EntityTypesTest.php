<?php

namespace JDZ\JsonLd\Tests;

use JDZ\JsonLd\AggregateOfferEntity;
use JDZ\JsonLd\ArticleEntity;
use JDZ\JsonLd\BlogPostingEntity;
use JDZ\JsonLd\BrandEntity;
use JDZ\JsonLd\BreadcrumbListEntity;
use JDZ\JsonLd\EducationalOccupationalProgramEntity;
use JDZ\JsonLd\GeoCoordinatesEntity;
use JDZ\JsonLd\ImageObjectEntity;
use JDZ\JsonLd\ItemListEntity;
use JDZ\JsonLd\ListItemEntity;
use JDZ\JsonLd\OfferEntity;
use JDZ\JsonLd\OrganizationEntity;
use JDZ\JsonLd\PersonEntity;
use JDZ\JsonLd\PlaceEntity;
use JDZ\JsonLd\ProductEntity;
use JDZ\JsonLd\SellerEntity;
use JDZ\JsonLd\WebPageEntity;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Each entity starts as its schema.org type and nothing else; the export of a
 * nested graph is one JSON-LD script with the nested entities inline.
 */
class EntityTypesTest extends TestCase
{
    public static function entities(): array
    {
        return [
            'AggregateOffer' => [AggregateOfferEntity::class, 'AggregateOffer'],
            'Article' => [ArticleEntity::class, 'Article'],
            'BlogPosting' => [BlogPostingEntity::class, 'BlogPosting'],
            'Brand' => [BrandEntity::class, 'Brand'],
            'BreadcrumbList' => [BreadcrumbListEntity::class, 'BreadcrumbList'],
            'EducationalOccupationalProgram' => [EducationalOccupationalProgramEntity::class, 'EducationalOccupationalProgram'],
            'GeoCoordinates' => [GeoCoordinatesEntity::class, 'GeoCoordinates'],
            'ImageObject' => [ImageObjectEntity::class, 'ImageObject'],
            'ItemList' => [ItemListEntity::class, 'ItemList'],
            'ListItem' => [ListItemEntity::class, 'ListItem'],
            'Offer' => [OfferEntity::class, 'Offer'],
            'Organization' => [OrganizationEntity::class, 'Organization'],
            'Person' => [PersonEntity::class, 'Person'],
            'Place' => [PlaceEntity::class, 'Place'],
            'Product' => [ProductEntity::class, 'Product'],
            'a Seller is an Organization' => [SellerEntity::class, 'Organization'],
            'WebPage' => [WebPageEntity::class, 'WebPage'],
        ];
    }

    #[DataProvider('entities')]
    public function testANewEntityIsItsSchemaType(string $class, string $type): void
    {
        $this->assertSame(['@type' => $type], (new $class())->json);
    }

    public function testANestedGraphExportsAsOneJsonLdScript(): void
    {
        $product = (new ProductEntity(true))
            ->make('Mug', 'MUG-1', 'A blue mug', 'https://shop.example/mug.jpg', 'https://shop.example/mug')
            ->setBrand((new BrandEntity())->make('Acme'))
            ->addOffer((new OfferEntity())->make('12.50', 'EUR'));

        $this->assertSame(
            '<script type="application/ld+json">' . \PHP_EOL
            . '{"@context":"https://schema.org","@type":"Product","name":"Mug","sku":"MUG-1","description":"A blue mug",'
            . '"image":"https://shop.example/mug.jpg","url":"https://shop.example/mug","brand":{"@type":"Brand","name":"Acme"},'
            . '"offers":{"@type":"Offer","price":"12.50","priceCurrency":"EUR","availability":"https://schema.org/InStock",'
            . '"itemCondition":"https://schema.org/NewCondition"}}' . \PHP_EOL
            . '</script>' . \PHP_EOL,
            $product->export(false)
        );
    }
}
