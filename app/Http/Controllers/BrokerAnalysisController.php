<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrokerAnalysisController extends Controller
{
    
    public function brokerAnalysis(){
        return view('frontend.pages.broker-analysis.index');
    }
}

