<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class WebPageEntity extends Entity
{
  protected string $type = 'WebPage';

  public function make(string $url)
  {
    $this->set('@id', $url);

    return $this;
  }
}
