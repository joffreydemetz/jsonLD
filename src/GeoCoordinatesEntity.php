<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class GeoCoordinatesEntity extends Entity
{
  protected string $type = 'GeoCoordinates';

  public function make(string $latitude, string $longitude)
  {
    $this->set('latitude', $latitude);
    $this->set('longitude', $longitude);

    return $this;
  }
}
