<?php

/**
 * @author    Joffrey Demetz <joffrey.demetz@gmail.com>
 * @license   MIT License; <https://opensource.org/licenses/MIT>
 */

namespace JDZ\JsonLd;

use JDZ\JsonLd\Entity;

class EducationalOccupationalProgramEntity extends Entity
{
  protected string $type = 'EducationalOccupationalProgram';

  public function make(string $url)
  {
    $this->set('@id', $url);
    return $this;
  }

  public function setApplicationStartDate(string $applicationStartDate)
  {
    $this->set('applicationStartDate', $applicationStartDate);
    return $this;
  }

  public function setApplicationDeadline(string $applicationDeadline)
  {
    $this->set('applicationDeadline', $applicationDeadline);
    return $this;
  }
}
