<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Setting;

class SettingsController extends Controller
{
    public function settings()
    {
    	$page = 'cHealth Settings';

    	$setting = Setting::first();

    	return view('core.pages.settings', compact('page', 'setting'));
    }

    public function updatesettings(Request $request)
    {
    	$this->validate($request, [
                'facility_name'       => 'required|min:1',
                'ward'                => 'required|min:1',
                'sub_county'          => 'required|min:1',
                'county'              => 'required|min:1'
        ]);

        $facility_name               = $request->input('facility_name');
        $ward                        = $request->input('ward');
        $sub_county                  = $request->input('sub_county');
        $county                      = $request->input('county');

        $setting = Setting::first()->update([
        	'facility_name'         => $facility_name,
        	'ward'					=> $ward,
        	'sub_county'			=> $sub_county,
        	'county'				=> $county
        ]);

        return redirect('settings')->with('success', 'The settings have been updated successfully.');
    }
}
