<?php

namespace App\Http\Controllers;

use App\Models\InspectionPackage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $packages = InspectionPackage::where('is_active', true)
            ->withCount('bookings')
            ->get();

        return view('home', compact('packages'));
    }

    public function packages(): View
    {
        $packages = InspectionPackage::where('is_active', true)
            ->with('checklistItems')
            ->get();

        return view('packages', compact('packages'));
    }
}
