<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\OfferEntity;
use JDZ\JsonLd\BrandEntity;
use JDZ\JsonLd\ImageObjectEntity;
use JDZ\JsonLd\AggregateOfferEntity;

class ProductEntity extends Entity
{
  protected string $type = 'Product';

  public function make(string $name, string $sku, string $description, string $image, string $url)
  {
    $this->set('name', $name);
    $this->set('sku', $sku);
    $this->set('description', $description);
    $this->set('image', $image);
    $this->set('url', $url);
    return $this;
  }

  public function setBrand(BrandEntity $brand)
  {
    $this->json['brand'] = $brand;
    return $this;
  }

  public function setLogo(ImageObjectEntity $logo)
  {
    $this->json['logo'] = $logo;
    return $this;
  }

  public function addOffer(OfferEntity $offer, int $index = 0)
  {
    $this->json['offers'] = $offer;
    return $this;
  }

  public function addOffers(AggregateOfferEntity $offers)
  {
    $this->json['offers'] = $offers;
    return $this;
  }
}
