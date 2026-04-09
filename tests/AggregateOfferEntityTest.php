<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\AggregateOfferEntity;
use JDZ\JsonLd\OfferEntity;

class AggregateOfferEntityTest extends TestCase
{
    public function testType(): void
    {
        $agg = new AggregateOfferEntity();

        $this->assertEquals('AggregateOffer', $agg->get('@type'));
    }

    public function testMake(): void
    {
        $agg = new AggregateOfferEntity();
        $result = $agg->make('10.00', '99.99', 'EUR', '5');

        $this->assertEquals('10.00', $agg->get('lowPrice'));
        $this->assertEquals('99.99', $agg->get('highPrice'));
        $this->assertEquals('EUR', $agg->get('priceCurrency'));
        $this->assertEquals('5', $agg->get('offerCount'));
        $this->assertIsArray($agg->json['offers']);
        $this->assertSame($agg, $result);
    }

    public function testAddOfferItem(): void
    {
        $agg = new AggregateOfferEntity();
        $agg->make('10', '50', 'USD', '2');

        $offer = new OfferEntity();
        $offer->make('25.00', 'USD');

        $result = $agg->addOfferItem($offer);

        $this->assertCount(1, $agg->json['offers']);
        $this->assertSame($agg, $result);
    }

    public function testValidateCalculatesPricesFromOffers(): void
    {
        $agg = new AggregateOfferEntity();
        $agg->init();

        $offer1 = new OfferEntity();
        $offer1->make('10.00', 'EUR');
        $agg->addOfferItem($offer1);

        $offer2 = new OfferEntity();
        $offer2->make('30.00', 'EUR');
        $agg->addOfferItem($offer2);

        $offer3 = new OfferEntity();
        $offer3->make('20.00', 'EUR');
        $agg->addOfferItem($offer3);

        $agg->validate();

        $this->assertEquals('10.00', $agg->get('lowPrice'));
        $this->assertEquals('30.00', $agg->get('highPrice'));
        $this->assertEquals('EUR', $agg->get('priceCurrency'));
        $this->assertEquals(3, $agg->get('offerCount'));
    }

    public function testValidateDoesNotOverrideExplicitValues(): void
    {
        $agg = new AggregateOfferEntity();
        $agg->make('5.00', '100.00', 'GBP', '10');

        $offer = new OfferEntity();
        $offer->make('25.00', 'GBP');
        $agg->addOfferItem($offer);

        $agg->validate();

        $this->assertEquals('5.00', $agg->get('lowPrice'));
        $this->assertEquals('100.00', $agg->get('highPrice'));
        $this->assertEquals('GBP', $agg->get('priceCurrency'));
        $this->assertEquals('10', $agg->get('offerCount'));
    }

    public function testInit(): void
    {
        $agg = new AggregateOfferEntity();
        $result = $agg->init();

        $this->assertIsArray($agg->json['offers']);
        $this->assertEmpty($agg->json['offers']);
        $this->assertSame($agg, $result);
    }
}
