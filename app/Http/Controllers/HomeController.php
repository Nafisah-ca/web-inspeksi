<?php

namespace App\Http\Controllers;

use App\Models\InspectionPackage;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $packages = InspectionPackage::where('is_active', true)->get();

        $hero    = SiteContent::section('hero');
        $stats   = SiteContent::section('stats');
        $why_us  = SiteContent::section('why_us');
        $how     = SiteContent::section('how');
        $cta     = SiteContent::section('cta');
        $contact = SiteContent::section('contact');
        $footer  = SiteContent::section('footer');

        return view('home', compact(
            'packages', 'hero', 'stats', 'why_us', 'how', 'cta', 'contact', 'footer'
        ));
    }

    public function packages(): View
    {
        $packages = InspectionPackage::where('is_active', true)
            ->with('checklistItems')
            ->get();

        $why_us = SiteContent::section('why_us');

        return view('packages', compact('packages', 'why_us'));
    }
}
