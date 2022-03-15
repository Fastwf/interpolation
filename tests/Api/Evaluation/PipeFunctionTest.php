<?php

namespace Fastwf\Tests\Api\Evaluation;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\Api\Evaluation\PipeFunction;

class PipeFunctionTest extends TestCase
{

    public function myTransform($value, $format)
    {
        return sprintf($format, $value);
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\PipeFunction
     */
    public function testTransform()
    {
        $p = new PipeFunction([$this, 'myTransform']);

        $this->assertEquals('007', $p->transform(7, ['%03d']));
    }

}
