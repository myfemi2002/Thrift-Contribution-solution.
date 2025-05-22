<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    /**
     * Get testimonials from JSON file
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = $this->getTestimonials();
        $assetBase = asset('');
        
        return view('frontend.testimonials', compact('testimonials', 'assetBase'));
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

    /**
     * Update the JSON file with new testimonials
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateTestimonials(Request $request)
    {
        // This would be used in an admin area to update testimonials
        $validator = Validator::make($request->all(), [
            'testimonials' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid testimonial data')->with('alert-type', 'error');
        }

        $path = public_path('data/testimonials.json');
        
        // Create directory if it doesn't exist
        $directory = public_path('data');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        // Save the JSON file
        File::put($path, $request->testimonials);
        
        return redirect()->back()->with('message', 'Testimonials updated successfully')->with('alert-type', 'success');
    }
}
