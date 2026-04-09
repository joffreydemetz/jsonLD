<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\GeoCoordinatesEntity;
use JDZ\JsonLd\PlaceEntity;

class GeoAndPlaceEntityTest extends TestCase
{
    public function testGeoCoordinatesType(): void
    {
        $geo = new GeoCoordinatesEntity();

        $this->assertEquals('GeoCoordinates', $geo->get('@type'));
    }

    public function testGeoCoordinatesMake(): void
    {
        $geo = new GeoCoordinatesEntity();
        $result = $geo->make('48.8566', '2.3522');

        $this->assertEquals('48.8566', $geo->get('latitude'));
        $this->assertEquals('2.3522', $geo->get('longitude'));
        $this->assertSame($geo, $result);
    }

    public function testPlaceType(): void
    {
        $place = new PlaceEntity();

        $this->assertEquals('Place', $place->get('@type'));
    }

    public function testPlaceMakeBasic(): void
    {
        $place = new PlaceEntity();
        $result = $place->make('Eiffel Tower');

        $this->assertEquals('Eiffel Tower', $place->get('name'));
        $this->assertFalse($place->has('hasMap'));
        $this->assertFalse($place->has('geo'));
        $this->assertSame($place, $result);
    }

    public function testPlaceMakeWithMapAndGeo(): void
    {
        $place = new PlaceEntity();
        $place->make('Eiffel Tower', 'https://maps.google.com/eiffel', '48.8584', '2.2945');

        $this->assertEquals('Eiffel Tower', $place->get('name'));
        $this->assertEquals('https://maps.google.com/eiffel', $place->get('hasMap'));
        $this->assertTrue($place->has('geo'));
    }

    public function testPlaceSetGeo(): void
    {
        $place = new PlaceEntity();
        $geo = new GeoCoordinatesEntity();
        $geo->make('40.7128', '-74.0060');

        $result = $place->setGeo($geo);

        $this->assertSame($geo, $place->get('geo'));
        $this->assertSame($place, $result);
    }
}
