<?php

namespace Fastwf\Interpolation;

use Fastwf\Interpolation\Utils\RegexUtil;
use Fastwf\Interpolation\InterpolatorInterface;

/**
 * String interpolator that use PCRE engine to inject values in the template.
 */
class StringInterpolator implements InterpolatorInterface
{

    private $mark;
    private $start;
    private $end;
    private $strict;

    private $pattern;

    private $parameters;

    public function __construct($strict = false, $mark = "%", $start = "{", $end = "}")
    {
        $this->strict = $strict;
        $this->mark = RegexUtil::escape($mark);
        $this->start = RegexUtil::escape($start);
        $this->end = RegexUtil::escape($end);

        $this->pattern = "/(^|\\\\?{$this->mark})({$this->start}([^{$this->mark}{$this->start}{$this->end}]+){$this->end})/m";
    }

    public function interpolate($template, $parameters)
    {
        // Save the parameters to use them in the $this->replace method.
        $this->parameters = $parameters;

        return \preg_replace_callback(
            $this->pattern,
            [$this, 'replace'],
            $template,
        );
    }

    /**
     * Callback to provide to the preg_replace_callback call.
     *
     * @param array $matches the matching groups
     * @return string the replacement string
     */
    public function replace($matches)
    {
        $marks = $matches[1];

        if ($marks[0] == '\\')
        {
            // Escape char is found in front of $mark
            $replacement = \substr($matches[0], 1, \strlen($matches[0]) - 1);
        }
        else
        {
            // Can interpolate the value
            $name = $matches[3];

            if (isset($this->parameters[$name]))
            {
                // Replace by recomposing the group with injected value
                $replacement = (string) $this->parameters[$name];
            }
            else if ($this->strict)
            {
                throw new InterpolationException("Missing value for key '$name'");
            }
            else
            {
                // No parameter provided, do not interpolate the sequence and return the original
                $replacement = $this->mark . $matches[2];
            }
        }

        return $replacement;
    }

}
