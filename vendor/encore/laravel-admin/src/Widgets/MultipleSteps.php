<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class MultipleSteps implements Renderable
{
    /**
     * @var int|string
     */
    protected $current;

    /**
     * @var array
     */
    protected $steps = [];

    /**
     * @var string
     */
    protected $stepName = 'step';

    /**
     * MultipleSteps constructor.
     *
     * @param array $steps
     * @param null  $current
     */
    public function __construct($steps = [], $current = null)
    {
        $this->steps = $steps;

        $this->current = $this->resolveCurrentStep($steps, $current);
    }

    /**
     * @param array $steps
     * @param null  $current
     *
     * @return static
     */
    public static function make($steps, $current = null): self
    {
        return new static($steps, $current);
    }

    /**
     * @param array      $steps
     * @param string|int $current
     *
     * @return string|int
     */
    protected function resolveCurrentStep($steps, $current)
    {
        $current = $current ?: request($this->stepName, 0);

        if (!isset($steps[$current])) {
            $current = key($steps);
        }

        return $current;
    }

    /**
     * @return string|null
     */
    public function render()
    {
        $class = $this->steps[$this->current];

        if (!is_subclass_of($class, StepForm::class)) {
            admin_error("Class [{$class}] must be a sub-class of [Encore\Admin\Widgets\StepForm].");

            return;
        }

        /** @var StepForm $step */
        $step = new $class();

        return $step
            ->setSteps(array_keys($this->steps))
            ->setCurrent($this->current)
            ->render();
    }
}
