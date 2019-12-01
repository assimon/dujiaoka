<?php

namespace Encore\Admin\Widgets;

class StepForm extends Form
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
    protected $url;

    /**
     * @var array
     */
    protected $buttons = [];

    /**
     * @param array $data
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function next($data = [])
    {
        $this->remember($data);

        return $this->redirectToNextStep();
    }

    protected function prev()
    {
        return back()->withInput();
    }

    /**
     * @param array $data
     */
    protected function remember($data)
    {
        session()->put("steps.{$this->current}", $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectToNextStep()
    {
        $index = array_search($this->current, $this->steps);

        $step = $this->steps[$index + 1];

        $nextUrl = $this->url.'?'.http_build_query(compact('step'));

        return redirect($nextUrl);
    }

    /**
     * Get all data from steps.
     *
     * @return array
     */
    protected function all()
    {
        $prev = session()->get('steps', []);

        return array_merge($prev, [$this->current => request()->all()]);
    }

    /**
     * Clear all data from steps.
     */
    protected function clear()
    {
        session()->remove('steps');
    }

    /**
     * @param array $steps
     *
     * @return $this
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * @param string|int $current
     *
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    protected function prepareForm()
    {
        parent::prepareForm();

        $url = request()->url();

        $this->hidden('_url')->default($url);
        $this->hidden('_current')->default($this->current);
        $this->hidden('_steps')->default(implode(',', $this->steps));

        $this->divider();

        $this->addFooter();
    }

    protected function addFooter()
    {
        $footer = '';

        $index = array_search($this->current, $this->steps);

        $trans = [
            'prev'   => __('admin.prev'),
            'next'   => __('admin.next'),
            'submit' => __('admin.submit'),
        ];

        if ($index !== 0) {
            $step = $this->steps[$index - 1];
            $prevUrl = request()->fullUrlWithQuery(compact('step'));
            $footer .= "<a href=\"{$prevUrl}\" class=\"btn btn-warning pull-left\">{$trans['prev']}</a>";
        }

        if ($index !== count($this->steps) - 1) {
            $footer .= "<button class=\"btn btn-info pull-right\">{$trans['next']}</button>";
        }

        if ($index === count($this->steps) - 1) {
            $footer .= "<button class=\"btn btn-info pull-right\">{$trans['submit']}</button>";
        }

        $this->html($footer);
    }

    /**
     * @return $this
     */
    public function sanitize()
    {
        $this->setUrl(request('_url'))
            ->setCurrent(request('_current'))
            ->setSteps(explode(',', request('_steps')));

        foreach (['_form_', '_token', '_url', '_current', '_steps'] as $key) {
            request()->request->remove($key);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return session()->get('steps.'.$this->current, []);
    }
}
