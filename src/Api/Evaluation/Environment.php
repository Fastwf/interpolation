<?php

namespace Fastwf\Interpolation\Api\Evaluation;

use Fastwf\Interpolation\InterpolationException;
use Fastwf\Interpolation\Evaluation\PipeInterface;

/**
 * Environment class that contains all declaration for node evaluation.
 */
class Environment
{

    /**
     * The variable context.
     *
     * @var array<string,mixed>
     */
    protected $variables = [];

    /**
     * The pipes registered.
     *
     * @var array<string,PipeInterface>
     */
    protected $pipes = [];

    /**
     * Register a new variables context.
     *
     * @param array<string,mixed> $variables the new variable context.
     * @return void
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    /**
     * Try to return the variable with given name.
     *
     * @param string $name the variable name.
     * @return mixed the value associated to the variable name.
     * @throws InterpolationException when the variable name not exists.
     */
    public function getVariable($name)
    {
        if (!\array_key_exists($name, $this->variables))
        {
            throw new InterpolationException("Missing value for key '$name'");
        }

        return $this->variables[$name];
    }

    /**
     * Verify if the variable exists in the environment context.
     *
     * @param string $name the variable name.
     * @return boolean true when the variable is found, false otherwise.
     */
    public function hasVariable($name)
    {
        return \array_key_exists($name, $this->variables);
    }

    /**
     * Set the pipe associated to the name in parameter.
     *
     * @param string $name the pipe name.
     * @param PipeInterface|null $pipe the pipe implementation or null to remove the pipe.
     * @return void
     */
    public function setPipe($name, $pipe)
    {
        if ($pipe !== null)
        {
            // Add the defined pipe
            $this->pipes[$name] = $pipe;
        }
        else if (isset($this->pipes[$name]))
        {
            // Remove the previous pipe
            unset($this->pipes[$name]);
        }
        // Else nothing to perform (the previous pipe was not set)
    }

    /**
     * Try to find the pipe by name.
     *
     * @param string $name the pipe name to search.
     * @return PipeInterface the pipe implementation associated to the name.
     * @throws InterpolationException when the pipe not exists.
     */
    public function getPipe($name)
    {
        if (!\array_key_exists($name, $this->pipes))
        {
            throw new InterpolationException("Pipe '$name' not defined");
        }

        return $this->pipes[$name];
    }

}
