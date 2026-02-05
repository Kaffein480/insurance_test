<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Session;
use URL;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        /*
        if ( ! Auth::check()) {
            Session::put('url.intended', URL::full());

            return redirect()->route('login')
                             ->with('status', 'Please log in to view that page');
        }
        */

        return view('dashboard');
    }
}
