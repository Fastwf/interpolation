<?php

namespace Fastwf\Tests\Api\Evaluation;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\InterpolationException;
use Fastwf\Interpolation\Api\Evaluation\Environment;
use Fastwf\Interpolation\Api\Evaluation\PipeFunction;

class EnvironmentTest extends TestCase
{

    /** @var Environment */
    private $env;

    protected function setUp(): void
    {
        $this->env = new Environment();
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     */
    public function testSetGetVariables()
    {
        $this->env->setVariables(['test' => 'test']);

        $this->assertEquals('test', $this->env->getVariable('test'));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     */
    public function testGetVariableError()
    {
        $this->expectException(InterpolationException::class);

        $this->env->getVariable('test');
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     */
    public function testHasVariable()
    {
        $this->env->setVariables(['test' => 'test']);

        $this->assertTrue($this->env->hasVariable('test'));
        $this->assertFalse($this->env->hasVariable('test2'));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     * @covers Fastwf\Interpolation\Api\Evaluation\PipeFunction
     */
    public function testSetGetPipe()
    {
        $this->env->setPipe('null', new PipeFunction(null));

        $this->assertNotNull($this->env->getPipe('null'));
    }

    /**
     * @covers Fastwf\Interpolation\Api\Evaluation\Environment
     * @covers Fastwf\Interpolation\Api\Evaluation\PipeFunction
     */
    public function testGetPipeError()
    {
        $this->expectException(InterpolationException::class);

        $this->env->setPipe('null', new PipeFunction(null));
        $this->env->setPipe('null', null);

        $this->env->getPipe('null');
    }

}
