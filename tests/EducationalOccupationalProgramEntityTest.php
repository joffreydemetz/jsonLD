<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\EducationalOccupationalProgramEntity;

class EducationalOccupationalProgramEntityTest extends TestCase
{
    public function testType(): void
    {
        $program = new EducationalOccupationalProgramEntity();

        $this->assertEquals('EducationalOccupationalProgram', $program->get('@type'));
    }

    public function testMake(): void
    {
        $program = new EducationalOccupationalProgramEntity();
        $result = $program->make('https://example.com/program');

        $this->assertEquals('https://example.com/program', $program->get('@id'));
        $this->assertSame($program, $result);
    }

    public function testSetApplicationStartDate(): void
    {
        $program = new EducationalOccupationalProgramEntity();
        $result = $program->setApplicationStartDate('2024-09-01');

        $this->assertEquals('2024-09-01', $program->get('applicationStartDate'));
        $this->assertSame($program, $result);
    }

    public function testSetApplicationDeadline(): void
    {
        $program = new EducationalOccupationalProgramEntity();
        $result = $program->setApplicationDeadline('2024-06-30');

        $this->assertEquals('2024-06-30', $program->get('applicationDeadline'));
        $this->assertSame($program, $result);
    }
}
