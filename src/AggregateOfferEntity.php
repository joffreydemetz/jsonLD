<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\OfferEntity;

class AggregateOfferEntity extends Entity
{
  protected string $type = 'AggregateOffer';

  public function validate()
  {
    $lowPrice = null;
    $highPrice = null;
    $priceCurrency = null;

    foreach ($this->json['offers'] as $offer) {
      if (null === $priceCurrency) {
        $priceCurrency = $offer->get('priceCurrency');
      }
      if (null === $lowPrice) {
        $lowPrice = $offer->get('price');
      }
      if (null === $highPrice) {
        $highPrice = $offer->get('price');
      }

      $lowPrice = min($lowPrice, $offer->get('price'));
      $highPrice = max($highPrice, $offer->get('price'));
    }

    if (false === $this->has('priceCurrency')) {
      $this->set('priceCurrency', $priceCurrency);
    }

    if (false === $this->has('lowPrice')) {
      $this->set('lowPrice', $lowPrice);
    }

    if (false === $this->has('highPrice')) {
      $this->set('highPrice', $highPrice);
    }

    if (false === $this->has('offerCount')) {
      $this->set('offerCount', count($this->json['offers']));
    }

    return parent::validate();
  }

  public function init()
  {
    if (!isset($this->json['offers'])) {
      $this->json['offers'] = [];
    }
    return $this;
  }

  public function make(string $lowPrice, string $highPrice, string $priceCurrency, string $offerCount)
  {
    $this->set('lowPrice', $lowPrice);
    $this->set('highPrice', $highPrice);
    $this->set('priceCurrency', $priceCurrency);
    $this->set('offerCount', $offerCount);

    return $this->init();
  }

  public function addOfferItem(OfferEntity $offer)
  {
    static $position;
    if (!isset($position)) {
      $position = 1;
    }

    $offer->set('position', $position++);

    $this->json['offers'][] = $offer;
    return $this;
  }
}
