<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Waiting;

class WaitingController extends Controller
{
    public function index()
    {	
    	$page = 'Queing Patients';
    	$waitings = Waiting::whereStatus(1)->get();

    	if(count($waitings)==0)
        {
            $page = 'No Queing Patients';
        }elseif(count($waitings)==1)
        {
            $message = 'There is 1 queing patient.';
        }
        else
        {
            $message = 'There are ' . count($waitings) . ' queing patients.';
        }

        //session info to be fixed

    	return view('core.pages.waiting', compact('page', 'waitings'));
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
