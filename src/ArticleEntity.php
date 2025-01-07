<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;
use JDZ\JsonLd\WebPageEntity;
use JDZ\JsonLd\PersonEntity;
use JDZ\JsonLd\OrganizationEntity;

class ArticleEntity extends Entity
{
  protected string $type = 'Article';

  public function make(string $url, string $headline, string $abstract, string $datePublished)
  {
    $this->setMainEntityOfPage(
      (new WebPageEntity())
        ->make($url)
    );

    $this->set('headline', $headline);
    $this->set('abstract', $abstract);
    $this->set('datePublished', $datePublished);

    return $this;
  }

  public function setMainEntityOfPage(WebPageEntity $mainEntityOfPage)
  {
    $this->set('mainEntityOfPage', $mainEntityOfPage);
    return $this;
  }

  public function setAuthor(PersonEntity $author)
  {
    $this->set('author', $author);
    return $this;
  }

  public function setPublisher(OrganizationEntity $publisher)
  {
    $this->set('publisher', $publisher);
    return $this;
  }
}
