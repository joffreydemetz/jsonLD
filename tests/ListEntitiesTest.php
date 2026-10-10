<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\ItemListEntity;
use JDZ\JsonLd\BreadcrumbListEntity;
use JDZ\JsonLd\ListItemEntity;

class ListEntitiesTest extends TestCase
{
    public function testListItemMake(): void
    {
        $item = new ListItemEntity();
        $result = $item->make('https://example.com/page', 'Page Name', 1);

        $this->assertEquals(1, $item->get('position'));
        $this->assertTrue($item->has('item'));
        $this->assertSame($item, $result);
    }

    public function testListItemMakeWithoutName(): void
    {
        $item = new ListItemEntity();
        $item->make('https://example.com/page', '', 2);

        $itemData = $item->get('item');
        $this->assertEquals('https://example.com/page', $itemData->{'@id'});
        $this->assertObjectNotHasProperty('name', $itemData);
    }

    public function testItemListMake(): void
    {
        $list = new ItemListEntity();
        $result = $list->make('https://example.com/list', 5);

        $this->assertEquals('https://example.com/list', $list->get('url'));
        $this->assertEquals(5, $list->get('numberOfItems'));
        $this->assertIsArray($list->json['itemListElement']);
        $this->assertSame($list, $result);
    }

    public function testItemListAddListItem(): void
    {
        $list = new ItemListEntity();
        $list->make('https://example.com', 0);

        $item = new ListItemEntity();
        $item->make('https://example.com/item1', 'Item 1');

        $result = $list->addListItem($item);

        $this->assertCount(1, $list->json['itemListElement']);
        $this->assertSame($list, $result);
    }

    public function testItemListAddListItemWithUrl(): void
    {
        $list = new ItemListEntity();
        $list->make('https://example.com', 0);

        $result = $list->addListItemWithUrl('https://example.com/page', 'My Page');

        $this->assertCount(1, $list->json['itemListElement']);
        $this->assertSame($list, $result);
    }

    public function testItemListValidateCalculatesCount(): void
    {
        $list = new ItemListEntity();
        $list->make('https://example.com', 0);
        $list->clear('numberOfItems');

        $list->addListItemWithUrl('https://example.com/1', 'One');
        $list->addListItemWithUrl('https://example.com/2', 'Two');

        $list->validate();

        $this->assertEquals(2, $list->get('numberOfItems'));
    }

    public function testBreadcrumbListInheritsItemList(): void
    {
        $breadcrumb = new BreadcrumbListEntity();
        $breadcrumb->make('https://example.com', 0);
        $breadcrumb->addListItemWithUrl('https://example.com', 'Home');
        $breadcrumb->addListItemWithUrl('https://example.com/about', 'About');

        $this->assertCount(2, $breadcrumb->json['itemListElement']);
    }
}
