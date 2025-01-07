<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class OrganizationEntity extends Entity
{
  protected string $type = 'Organization';

  public function make(string $name, string $url, string $logo, string $email = '', string $telephone = '')
  {
    $this->set('name', $name);
    $this->set('url', $url);
    $this->set('email', $email);
    $this->set('telephone', $telephone);

    if ('' !== $logo) {
      $this->set('logo', $this->urlToImageObjectEntity($logo));
    }

    return $this;
  }
}
