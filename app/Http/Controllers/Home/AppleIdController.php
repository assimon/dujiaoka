<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AppleIdController extends BaseController
{
    /**
     * Display the Apple ID landing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->render('static_pages/appleid', [], __('dujiaoka.page-title.appleid'));
    }

    /**
     * Handle Apple ID retrieve form submission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retrieve(Request $request)
    {
        // This is a placeholder for processing submitted data.
        return back()->with('success', 'submitted');
    }
}
