<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradingSolutionsController extends Controller
{
    public function tradingSolutions(){
        return view('frontend.pages.trading-solutions.index');
    }
}
