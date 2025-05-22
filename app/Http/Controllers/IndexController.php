<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class IndexController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        
        $testimonials = $this->getTestimonials();
        $assetBase = asset('');
        
        return view('frontend.index', compact('testimonials', 'assetBase'));
    }

    /**
     * Get testimonials for a specific page section
     *
     * @return array
     */
    public function getTestimonials()
    {
        $path = public_path('data/testimonials.json');
        
        if (!File::exists($path)) {
            return [];
        }
        
        $testimonials = json_decode(File::get($path), true);
        
        return $testimonials;
    }




}
