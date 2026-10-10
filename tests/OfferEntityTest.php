<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\OfferEntity;
use JDZ\JsonLd\SellerEntity;

class OfferEntityTest extends TestCase
{
    public function testMake(): void
    {
        $offer = new OfferEntity();
        $result = $offer->make('29.99', 'EUR');

        $this->assertEquals('29.99', $offer->get('price'));
        $this->assertEquals('EUR', $offer->get('priceCurrency'));
        $this->assertEquals('https://schema.org/InStock', $offer->get('availability'));
        $this->assertEquals('https://schema.org/NewCondition', $offer->get('itemCondition'));
        $this->assertSame($offer, $result);
    }

    public function testMakeWithCustomAvailabilityAndCondition(): void
    {
        $offer = new OfferEntity();
        $offer->make('50.00', 'USD', OfferEntity::AVAILABLE_PRE_ORDER, OfferEntity::CONDITION_REFURBISHED);

        $this->assertEquals('https://schema.org/PreOrder', $offer->get('availability'));
        $this->assertEquals('https://schema.org/RefurbishedCondition', $offer->get('itemCondition'));
    }

    public function testSetAvailabilityFallsBackToInStockOnInvalid(): void
    {
        $offer = new OfferEntity();
        $offer->setAvailability('InvalidStatus');

        $this->assertEquals('https://schema.org/InStock', $offer->get('availability'));
    }

    public function testSetItemConditionFallsBackToNewOnInvalid(): void
    {
        $offer = new OfferEntity();
        $offer->setItemCondition('InvalidCondition');

        $this->assertEquals('https://schema.org/NewCondition', $offer->get('itemCondition'));
    }

    public function testAllAvailabilityStatuses(): void
    {
        $statuses = [
            OfferEntity::AVAILABLE_IN_STOCK,
            OfferEntity::AVAILABLE_IN_STORE_ONLY,
            OfferEntity::AVAILABLE_ONLINE_ONLY,
            OfferEntity::AVAILABLE_SOLD_OUT,
            OfferEntity::AVAILABLE_PRE_ORDER,
            OfferEntity::AVAILABLE_PRE_SALE,
            OfferEntity::AVAILABLE_DISCOUNTINUED,
            OfferEntity::AVAILABLE_LIMITED_AVAILABILITY,
            OfferEntity::AVAILABLE_OUT_OF_STOCK,
        ];

        foreach ($statuses as $status) {
            $offer = new OfferEntity();
            $offer->setAvailability($status);
            $this->assertEquals('https://schema.org/' . $status, $offer->get('availability'));
        }
    }

    public function testAllConditionStatuses(): void
    {
        $conditions = [
            OfferEntity::CONDITION_NEW,
            OfferEntity::CONDITION_DAMAGED,
            OfferEntity::CONDITION_REFURBISHED,
            OfferEntity::AVAILABLE_USED,
        ];

        foreach ($conditions as $condition) {
            $offer = new OfferEntity();
            $offer->setItemCondition($condition);
            $this->assertEquals('https://schema.org/' . $condition, $offer->get('itemCondition'));
        }
    }

    public function testSetCategory(): void
    {
        $offer = new OfferEntity();
        $result = $offer->setCategory(42);

        $this->assertEquals(42, $offer->get('category'));
        $this->assertSame($offer, $result);
    }

    public function testSetUrl(): void
    {
        $offer = new OfferEntity();
        $result = $offer->setUrl('https://example.com/product');

        $this->assertEquals('https://example.com/product', $offer->get('url'));
        $this->assertSame($offer, $result);
    }

    public function testSetSeller(): void
    {
        $offer = new OfferEntity();
        $seller = new SellerEntity();
        $seller->make('Shop', 'https://shop.com', '');

        $result = $offer->setSeller($seller);

        $this->assertSame($seller, $offer->get('seller'));
        $this->assertSame($offer, $result);
    }
}
