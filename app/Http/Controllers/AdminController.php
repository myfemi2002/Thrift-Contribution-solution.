<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Counter;
use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        // Property metrics
        // $totalProperties = Property::count();
        // $propertiesForSale = Property::where('status', 'For Sale')->count();
        // $propertiesForRent = Property::where('status', 'For Rent')->count();
        
        
        // All data to pass to view
        $data = [
            // Property stats
            // 'totalProperties' => $totalProperties,
            // 'propertiesForSale' => $propertiesForSale,
            // 'propertiesForRent' => $propertiesForRent,
        ];
        
        return view('admin.index', $data);
    }

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        ];
        
        return redirect('/login')->with($notification);
    }
}