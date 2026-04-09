<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\ProductEntity;
use JDZ\JsonLd\BrandEntity;
use JDZ\JsonLd\OfferEntity;
use JDZ\JsonLd\AggregateOfferEntity;

class ProductEntityTest extends TestCase
{
    public function testType(): void
    {
        $product = new ProductEntity();

        $this->assertEquals('Product', $product->get('@type'));
    }

    public function testMake(): void
    {
        $product = new ProductEntity();
        $result = $product->make('Widget', 'SKU123', 'A great widget', 'https://example.com/img.jpg', 'https://example.com/widget');

        $this->assertEquals('Widget', $product->get('name'));
        $this->assertEquals('SKU123', $product->get('sku'));
        $this->assertEquals('A great widget', $product->get('description'));
        $this->assertEquals('https://example.com/img.jpg', $product->get('image'));
        $this->assertEquals('https://example.com/widget', $product->get('url'));
        $this->assertSame($product, $result);
    }

    public function testSetBrand(): void
    {
        $product = new ProductEntity();
        $brand = new BrandEntity();
        $brand->make('Acme');

        $result = $product->setBrand($brand);

        $this->assertSame($brand, $product->json['brand']);
        $this->assertSame($product, $result);
    }

    public function testAddOffer(): void
    {
        $product = new ProductEntity();
        $offer = new OfferEntity();
        $offer->make('19.99', 'USD');

        $result = $product->addOffer($offer);

        $this->assertSame($offer, $product->json['offers']);
        $this->assertSame($product, $result);
    }

    public function testAddOffers(): void
    {
        $product = new ProductEntity();
        $aggregate = new AggregateOfferEntity();
        $aggregate->make('10', '50', 'EUR', '3');

        $result = $product->addOffers($aggregate);

        $this->assertSame($aggregate, $product->json['offers']);
        $this->assertSame($product, $result);
    }
}
