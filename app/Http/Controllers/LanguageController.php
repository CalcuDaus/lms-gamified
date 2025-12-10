<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            $locale = 'en';
        }
        
        // Store in session
        Session::put('locale', $locale);
        
        // Set application locale
        App::setLocale($locale);
        
        return redirect()->back();
    }
}
