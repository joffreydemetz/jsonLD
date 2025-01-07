<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\GeoCoordinatesEntity;

class PlaceEntity extends Entity
{
  protected string $type = 'Place';

  public function make(string $name, string $mapUrl = '', string $latitude = '', string $longitude = '')
  {
    $this->set('name', $name);

    if ($latitude && $longitude) {
      $geo = (new GeoCoordinatesEntity())
        ->make($latitude, $longitude);

      $this->setGeo($geo);
    }

    if ($mapUrl) {
      $this->set('hasMap', $mapUrl);
    }

    return $this;
  }

  public function setGeo(GeoCoordinatesEntity $geo)
  {
    $this->set('geo', $geo);

    return $this;
  }
}
