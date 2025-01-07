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

class BlogPostingEntity extends Entity
{
  protected string $type = 'BlogPosting';

  public function make(string $url, string $headline, string $abstract, string $datePublished, string $image, string $author = '', string $dateModified = '', string $publisher = '')
  {
    $this->setMainEntityOfPage(
      (new WebPageEntity())
        ->make($url)
    );

    $this->set('headline', $headline);
    $this->set('abstract', $abstract);
    $this->set('image', $image);
    $this->set('datePublished', $datePublished);
    $this->set('dateModified', $dateModified);

    if ('' !== $author) {
      $this->setAuthor(
        (new PersonEntity())
          ->make($author)
      );
    }

    if ('' !== $publisher) {
      $this->setPublisher(
        (new OrganizationEntity())
          ->make($publisher, '', '')
      );
    }

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
