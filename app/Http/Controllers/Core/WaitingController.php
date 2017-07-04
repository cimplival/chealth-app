<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Waiting;

class WaitingController extends Controller
{
    public function index()
    {	
    	$page = 'Patient Waitlist';
    	$waitings = Waiting::whereStatus(1)->get();

        $past_waitings = Waiting::whereStatus(0)->latest()->limit(10)->get();

    	if(count($waitings)==1)
        {
            $message = 'There is 1 waiting patient.';
        }
        else
        {
            $message = 'There are ' . count($waitings) . ' waiting patients.';
        }

        //session info to be fixed

    	return view('core.pages.waiting', compact('page', 'waitings', 'past_waitings'));
    }

    public function waitlist(Request $request, $id)
    {
        $waiting = Waiting::create([
                'patient_id' => $id,
                'status'     => 1,
            ]);

        return redirect('waiting')->with('success', 'Patient added to waitlist.');
    }
}
