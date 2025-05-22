<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialInsightsController extends Controller
{
    public function financialInsights(){
        return view('frontend.pages.financial-insights.index');
    }
}
