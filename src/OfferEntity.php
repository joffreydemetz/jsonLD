<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\SellerEntity;

class OfferEntity extends Entity
{
  const AVAILABLE_IN_STOCK = 'InStock';
  const AVAILABLE_IN_STORE_ONLY = 'InStoreOnly';
  const AVAILABLE_ONLINE_ONLY = 'OnlineOnly';
  const AVAILABLE_SOLD_OUT = 'SoldOut';
  const AVAILABLE_PRE_ORDER = 'PreOrder';
  const AVAILABLE_PRE_SALE = 'PreSale';
  const AVAILABLE_DISCOUNTINUED = 'Discontinued';
  const AVAILABLE_LIMITED_AVAILABILITY = 'LimitedAvailability';
  const AVAILABLE_OUT_OF_STOCK = 'OutOfStock';

  const CONDITION_NEW = 'NewCondition';
  const CONDITION_DAMAGED = 'DamagedCondition';
  const CONDITION_REFURBISHED = 'RefurbishedCondition';
  const AVAILABLE_USED = 'UsedCondition';

  protected array $validAvailableStatus = [
    self::AVAILABLE_DISCOUNTINUED,
    self::AVAILABLE_IN_STOCK,
    self::AVAILABLE_IN_STORE_ONLY,
    self::AVAILABLE_LIMITED_AVAILABILITY,
    self::AVAILABLE_ONLINE_ONLY,
    self::AVAILABLE_OUT_OF_STOCK,
    self::AVAILABLE_PRE_ORDER,
    self::AVAILABLE_PRE_SALE,
    self::AVAILABLE_SOLD_OUT,
  ];

  protected array $validItemConditionStatus = [
    self::CONDITION_NEW,
    self::CONDITION_DAMAGED,
    self::CONDITION_REFURBISHED,
    self::AVAILABLE_USED,
  ];

  protected string $type = 'Offer';

  public function make(string $price, string $priceCurrency, string $availability = self::AVAILABLE_IN_STOCK, string $condition = self::CONDITION_NEW)
  {
    $this->set('price', $price);
    $this->set('priceCurrency', $priceCurrency);

    $this->setAvailability($availability);
    $this->setItemCondition($condition);

    return $this;
  }

  public function setAvailability(string $availability = self::AVAILABLE_IN_STOCK)
  {
    if (!in_array($availability, $this->validAvailableStatus)) {
      $availability = self::AVAILABLE_IN_STOCK;
    }
    $this->set('availability', 'https://schema.org/' . $availability);

    return $this;
  }

  public function setItemCondition(string $itemCondition = self::CONDITION_NEW)
  {
    if (!in_array($itemCondition, $this->validItemConditionStatus)) {
      $itemCondition = self::CONDITION_NEW;
    }
    $this->set('itemCondition', 'https://schema.org/' . $itemCondition);

    return $this;
  }

  public function setCategory(int $category)
  {
    $this->set('category', $category);
    return $this;
  }

  public function setUrl(string $url)
  {
    $this->set('url', $url);
    return $this;
  }

  public function setSeller(SellerEntity $seller)
  {
    $this->set('seller', $seller);
    return $this;
  }
}
