<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class ListItemEntity extends Entity
{
  protected string $type = 'ListItem';

  public function make(string $url, string $name = '', int $position = 0)
  {
    $this->set('position', $position);

    $item = [];
    $item['@id'] = $url;
    if ('' !== $name) {
      $item['name'] = $name;
    }
    $this->set('item', (object)$item);

    return $this;
  }
}
