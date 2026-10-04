<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\AggregateOfferEntity;
use JDZ\JsonLd\BreadcrumbListEntity;
use JDZ\JsonLd\ItemListEntity;
use JDZ\JsonLd\OfferEntity;

/**
 * Positions are per instance: a second list (or a breadcrumb, which inherits
 * addListItem()) in the same request starts again at 1.
 */
class PositionTest extends TestCase
{
    private function positions(array $items): array
    {
        return array_map(fn($item) => $item->get('position'), $items);
    }

    public function testEachListNumbersFromOne(): void
    {
        $first = (new ItemListEntity())->make('https://example.com/a', 0);
        $first->addListItemWithUrl('https://example.com/a/1', 'One');
        $first->addListItemWithUrl('https://example.com/a/2', 'Two');

        $second = (new ItemListEntity())->make('https://example.com/b', 0);
        $second->addListItemWithUrl('https://example.com/b/1', 'One');

        $crumbs = (new BreadcrumbListEntity())->make('https://example.com', 0);
        $crumbs->addListItemWithUrl('https://example.com', 'Home');
        $crumbs->addListItemWithUrl('https://example.com/b', 'B');

        $this->assertSame([1, 2], $this->positions($first->json['itemListElement']));
        $this->assertSame([1], $this->positions($second->json['itemListElement']));
        $this->assertSame([1, 2], $this->positions($crumbs->json['itemListElement']));
    }

    public function testMakeRestartsTheNumbering(): void
    {
        $list = (new ItemListEntity())->make('https://example.com', 0);
        $list->addListItemWithUrl('https://example.com/1', 'One');

        $list->make('https://example.com', 0);
        $list->addListItemWithUrl('https://example.com/1', 'One again');

        $this->assertSame([1], $this->positions($list->json['itemListElement']));
    }

    public function testEachAggregateNumbersItsOffersFromOne(): void
    {
        $first = (new AggregateOfferEntity())->init();
        $first->addOfferItem((new OfferEntity())->make('10.00', 'EUR'));
        $first->addOfferItem((new OfferEntity())->make('20.00', 'EUR'));

        $second = (new AggregateOfferEntity())->init();
        $second->addOfferItem((new OfferEntity())->make('30.00', 'EUR'));

        $this->assertSame([1, 2], $this->positions($first->json['offers']));
        $this->assertSame([1], $this->positions($second->json['offers']));
    }
}
