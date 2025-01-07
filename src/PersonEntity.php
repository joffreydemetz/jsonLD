<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class PersonEntity extends Entity
{
  protected string $type = 'Person';

  public function make(string $name)
  {
    $this->set('name', $name);

    return $this;
  }
}
