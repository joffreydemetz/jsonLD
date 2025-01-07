<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class ImageObjectEntity extends Entity
{
  protected string $type = 'ImageObject';

  public function make(string $url)
  {
    $this->set('url', $url);

    if ($url && ($size = \getimagesize($url))) {
      $this->set('width', $size[0]);
      $this->set('height', $size[1]);
    }

    return $this;
  }
}
