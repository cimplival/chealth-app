<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Patient;
use cHealth\Waiting;
use cHealth\Clinical;

class PatientsController extends Controller
{
   	public function create()
   	{
   		$page = 'Register';
   		return view('core.pages.register', compact('page'));
   	}

    public function store(Request $request)
    {
    	$this->validate($request, [
                'name'         => 'required|min:1|max:256',
                'age'          => 'required|min:0|max:125',
                'gender'       => 'required',
        ]);


        $name     = $request->input('name');
        $age      = $request->input('age');
        $gender   = $request->input('gender');
        $phone    = $request->input('phone');

        $patient = Patient::create([
            'name'       => $name,
            'age'        => $age,
            'gender'     => $gender,
            'phone'      => $phone
        ]);

        $register_only = $request->input('register_only');

        if($register_only==1)
        {   
        	return redirect('register')->with('success', 'Patient registered successfully.');
        } else {
        	$waiting = Waiting::create([
	            'patient_id' => $patient->id,
	            'status'     => 1,
	        ]);

        	return redirect('waiting')->with('success', 'Patient registered successfully.');
        }
    }

    public function consult($id)
    {   
        Waiting::where('patient_id', $id)
            ->update([
                'status'     => 0
            ]);

        $page = 'Clinical History';

        $clinicals = Clinical::where('patient_id', $id)->get();

        $patient = Patient::whereId($id)->first();

        return view('core.pages.clinical', compact('page', 'clinicals', 'patient'));
    }

    public function view($id)
    {

        $patient = Patient::where('id', $id)->first();

        $page = 'Medical Records';

        $clinical = Clinical::where('patient_id', $id)->first();

        $waitlist = Waiting::where('patient_id', $id)->where('status', 1)->first();

        return view('core.pages.view', compact('page', 'clinical', 'patient', 'waitlist'));
    }

    public function viewrecord($id)
    {
        $page = 'Clinical History';

        $clinicals = Clinical::where('patient_id', $id)->get();

        $patient = Patient::whereId($id)->first();

        return view('core.pages.view-record', compact('page', 'clinicals', 'patient'));
    }

    public function updatepatient($id)
    {
        $patient = Patient::where('id', $id)->first();

        $page = 'Medical Records';

        return view('core.pages.update-patient', compact('page', 'patient'));
    }

    public function postupdatepatient(Request $request)
    {
        $this->validate($request, [
                'patient_id'   => 'required|min:1',
                'name'         => 'required|min:1|max:256',
                'age'          => 'required|min:0|max:125',
                'gender'       => 'required',
        ]);

        $patient_id  = $request->input('patient_id');
        $name        = $request->input('name');
        $age         = $request->input('age');
        $gender      = $request->input('gender');
        $phone       = $request->input('phone');

        $patient = Patient::where('id', $patient_id)->update([
            'name'       => $name,
            'age'        => $age,
            'gender'     => $gender,
            'phone'      => $phone
        ]);

        return redirect()->route('consult', [$patient_id])->with('success', 'Patient details updated successfully.');
    }

    public function deletepatient($id)
    {
        $patient = Patient::whereId($id)->first();

        $page = 'Delete Clinical History';

        return view('core.pages.delete-patient', compact('page', 'patient'));
    }

    public function postdeletepatient(Request $request)
    {
        $this->validate($request, [
            'patient_id'  => 'required|numeric|min:1'
        ]);

        $patient_id   = $request->input('patient_id');

        Clinical::where('patient_id', $patient_id)->delete();

        Patient::whereId($patient_id)->delete();

        return redirect('/')->with('success', 'Patient deleted successfully.');
    }
}
