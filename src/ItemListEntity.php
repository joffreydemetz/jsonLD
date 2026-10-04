<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\ListItemEntity;

class ItemListEntity extends Entity
{
  protected string $type = 'ItemList';

  public function validate()
  {
    if (false === $this->has('numberOfItems')) {
      $this->set('numberOfItems', count($this->json['itemListElement']));
    }

    return parent::validate();
  }

  public function make(string $url, int $numberOfItems)
  {
    $this->set('url', $url);
    $this->set('numberOfItems', $numberOfItems);

    $this->json['itemListElement'] = [];

    return $this;
  }

  public function addListItemWithUrl(string $url, string $name = '')
  {
    $listItem = (new ListItemEntity())
      ->make($url, $name);

    $this->addListItem($listItem);

    return $this;
  }

  public function addListItem(ListItemEntity $listItem)
  {
    // position is per list: the next slot of THIS instance, never a counter
    // shared across instances (or across subclasses, as a static would be)
    $listItem->set('position', count($this->json['itemListElement'] ?? []) + 1);

    $this->json['itemListElement'][] = $listItem;

    return $this;
  }
}
