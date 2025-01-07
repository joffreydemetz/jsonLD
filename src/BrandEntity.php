<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\ImageObjectEntity;

class BrandEntity extends Entity
{
  protected string $type = 'Brand';

  public function make(string $name, string $logo = '', string $url = '')
  {
    $this->set('name', $name);
    $this->set('logo', $logo);
    $this->set('url', $url);

    return $this;
  }

  public function setLogo(ImageObjectEntity $logo)
  {
    $this->set('logo', $logo);
    return $this;
  }
}
