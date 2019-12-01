<?php

namespace Encore\Admin\Widgets;

trait ContainsForms
{
    protected $activeName = 'active';

    public static function forms($forms, $active = null)
    {
        $tab = new static();

        return $tab->buildTabbedForms($forms, $active);
    }

    protected function buildTabbedForms($forms, $active = null)
    {
        $active = $active ?: request($this->activeName);

        if (!isset($forms[$active])) {
            $active = key($forms);
        }

        foreach ($forms as $name => $class) {
            if (!is_subclass_of($class, Form::class)) {
                admin_error("Class [{$class}] must be a sub-class of [Encore\Admin\Widgets\Form].");
                continue;
            }

            /** @var Form $form */
            $form = app()->make($class);

            if ($name == $active) {
                $this->add($form->title, $form->unbox(), true);
            } else {
                $this->addLink($form->title, $this->getTabUrl($name));
            }
        }

        return $this;
    }

    protected function getTabUrl($name)
    {
        $query = [$this->activeName => $name];

        return request()->fullUrlWithQuery($query);
    }
}
