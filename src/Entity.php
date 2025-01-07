<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\ImageObjectEntity;

class Entity implements \JsonSerializable
{
  public array $json = [];
  protected string $type;
  protected bool $inContext;

  public function __construct(bool $inContext = false)
  {
    $this->inContext = $inContext;

    if (true === $this->inContext) {
      $this->set('@context', 'https://schema.org');
    }

    $this->set('@type', $this->type);
  }

  public function validate()
  {
    foreach ($this->json as $key => $value) {
      if ($value instanceof Entity) {
        $this->json[$key]->validate();
      }
    }

    return $this;
  }

  public function export(bool $pretty = true): string
  {
    $str = '';

    if (true === $this->inContext) {
      if (true === $pretty) {
        $mask = \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PARTIAL_OUTPUT_ON_ERROR;
      } else {
        $mask = \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PARTIAL_OUTPUT_ON_ERROR;
      }

      $str  = '<script type="application/ld+json">' . \PHP_EOL;
      $str .= \json_encode($this->json, $mask) . \PHP_EOL;
      $str .= '</script>' . \PHP_EOL;
    }

    return $str;
  }

  public function jsonSerialize(): mixed
  {
    foreach ($this->json as $key => $value) {
      if ($value instanceof Entity) {
        $value = $value->json;
      }
    }

    return $this->json;
  }

  public function get(string $key, mixed $default = null)
  {
    if (isset($this->json[$key])) {
      return $this->json[$key];
    }
    return $default;
  }

  public function set(string $key, mixed $value)
  {
    if ($value) {
      $this->json[$key] = $value;
    }
    return $this;
  }

  public function has(string $key): bool
  {
    return isset($this->json[$key]);
  }

  public function clear(string $key)
  {
    if (true === $this->has($key)) {
      unset($this->json[$key]);
    }
    return $this;
  }

  public function urlToImageObjectEntity(string $url): ImageObjectEntity
  {
    return (new ImageObjectEntity())
      ->make($url);
  }
}
