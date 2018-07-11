<?php

namespace QuadStudio\Service\Site\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class UserViewComposer
{
    public function compose(View $view)
    {
        $user = request()->user();
        $view->with('current_user', $user);
    }
}