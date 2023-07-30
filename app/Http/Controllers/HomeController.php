<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * setting home page location depending if user is authenticated or not
     *
     * @return void
     */
    public function home()
    {
        if(auth()->guest()) {
            return redirect(route('login'));
        }

        return redirect(route('messages.index'));
    }
}
