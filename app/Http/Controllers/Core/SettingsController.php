<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Setting;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;

class SettingsController extends Controller
{
    public function settings()
    {
    	$page = 'Settings';

    	return view('core.pages.settings', compact('page'));
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

        return redirect('main-settings')->with('success', 'The settings have been updated successfully.');
    }

    public function mainsettings()
    {
        $page = 'Main Settings';

        $setting = Setting::first();

        return view('core.pages.main-settings', compact('page', 'setting'));
    }

    public function aboutchealth()
    {
        $page = 'About cHealth';

        $time_now = Carbon::now();

        $year = $time_now->year;


        return view('core.pages.about-chealth', compact('page', 'year'));
    }

    public function chealthlicense()
    {
        $page = 'Software License';

        return view('core.pages.chealth-license', compact('page'));
    }

    public function upgradechealth()
    {
        $page = 'Upgrade cHealth';

        return view('core.pages.upgrade', compact('page'));
    }
    
    public function updatechealth()
    {   
        $response = null;

        system("ping -c 1 google.com", $response);

        if($response == 0)
        {
            $process = new Process('git pull && php artisan migrate --seed --force');

            $process->setWorkingDirectory(base_path());
            
            $process->run();

            if ($process->isSuccessful()) {

                $data = 'cHealth was successfully updated.';

            } else {

                $data = 'Sorry, the update was not successful.';
                //return dd($process->getErrorOutput());
            }

        } else {

            $data = 'Please check your internet connection.'; 
        
        }

        return redirect('update-chealth')->with('info', $data);
    }   
}
