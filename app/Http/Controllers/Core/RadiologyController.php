<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Patient;
use cHealth\Radio;
use cHealth\Lab;

class RadiologyController extends Controller
{
    public function createradiology($id)
    {
    	$page                       = 'Radiology Investigation';

        $patient                    = Patient::whereId($id)->first();

        $radios                     = Radio::get();

        return view('core.pages.new-radiology', compact('page', 'patient', 'radios'));
    }


    public function postradiology(Request $request, $id)
    {
    	$this->validate($request, [
                'investigation_request'             => 'required',
        ]);

        $investigation_request      = $request->input('investigation_request');

        $lab = Lab::create([
            'patient_id'                 => $id,
            'investigation_request'      => $investigation_request,
            'status'                     => 0,
            'from_user'                  => 1
        ]);

        $radio                      = $request->input('radiology',[]);  

        for($i=0; $i<count($radio); $i++)
    	{
    		$selected_radio  = Radio::whereId($radio[$i])->first();

    		$lab->assignRadio($selected_radio);
    		
    	}

        $patient_id = $lab->patient->id;

        return redirect()->route('consult', [$patient_id])->with('success', 'Lab investigation requested successfully.');
    }


    public function removeradiology($lab_id, $radio_id)
    {
        $page                       = 'Remove Radiology';

        $lab                        = Lab::whereId($lab_id)->first();

        return view('core.pages.remove-radiology', compact('page', 'lab', 'radio_id'));
    }

    public function postremoveradiology(Request $request, $lab_id , $radio_id)
    {
        $lab                        = Lab::whereId($lab_id)->first();

        $selected_radio             = Radio::whereId($radio_id)->first();

        $lab->removeRadio($selected_radio);

        return redirect()->route('labs.edit', [$lab_id])->with('success', 'Radiology removed successfully.');

    }

    public function addradiology($lab_id)
    {
        $page                       = 'Add Radiology';

        $radios                     = Radio::get();

        return view('core.pages.add-radiology', compact('page', 'radios', 'lab_id'));
    }

    public function postaddradiology(Request $request, $lab_id)
    {   
        $lab                        = Lab::whereId($lab_id)->first();

        $radio                      = $request->input('radiology',[]);

        for($i=0; $i<count($radio); $i++)
        {
            $selected_radio  = Radio::whereId($radio[$i])->first();

            $lab->assignRadio($selected_radio);
            
        }

        return redirect()->route('labs.edit', [$lab_id])->with('success', 'Radiology removed successfully.');
    }
}
