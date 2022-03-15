<?php

namespace Fastwf\Interpolation;

/**
 * Interpolator interface.
 * 
 * The interface define method to implement to have a generic interpolator implementation.
 */
interface InterpolatorInterface
{

    /**
     * Interpolate the given string using parameters for injection.
     *
     * @param string $template the template to interpolate.
     * @param array<string,mixed> $parameters the parameters to inject in the template.
     * @return string the template interpolated.
     */
    public function interpolate($template, $parameters);

}
