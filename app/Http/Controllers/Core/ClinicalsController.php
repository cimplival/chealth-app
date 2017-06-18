<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use DB;
use cHealth\Patient;
use cHealth\Clinical;
use Session;

class ClinicalsController extends Controller
{
    public function index()
    {	
        $patients = Patient::get();

        $no_of_patients = count($patients);

        $page = 'cHealth';

    	return view('core.pages.records', compact('page', 'patients', 'no_of_patients'));
    }

    public function search(Request $request)
    {	
    	$this->validate($request, [
                'search'            => 'required|min:1'
        ],
        [
                'search.required'   => 'You need to search a patient.',
        ]);

    	$query = $request->input('search');

        $patients = DB::table('patients')->where('name', 'LIKE', '%' . $query . '%')
        ->orWhere('age', 'LIKE', '%' . $query . '%')
        ->orWhere('gender', 'LIKE', '%' . $query . '%')
        ->orWhere('phone', 'LIKE', '%' . $query . '%')
        ->get();

        if(count($patients)==1)
        {
            $tense = 'is';
            $result = 'result.';
        }
        else
        {
            $tense = 'are';
            $result = 'results.';
        }

        $message = 'There '. $tense . ' ' . count($patients) . ' patient '. $result;

        $page = 'Medical Records';

        $allpatients = Patient::get();

        $no_of_patients = count($allpatients);


        return view('core.pages.records', compact('patients', 'page', 'no_of_patients'));

    }

    public function history($id)
    {
        $patient = Patient::where('id', $id)->first();

        $page = $patient->name;

        return view('core.pages.new-history', compact('page', 'patient', 'new-history'));
    }

    public function new(Request $request)
    {
        $this->validate($request, [
                'patient_id'       => 'required|numeric|min:1',
        ]);

        $patient_id    = $request->input('patient_id');
        $complaint     = $request->input('complaint');
        $lab_test      = $request->input('lab_test');
        $treatment     = $request->input('treatment');

        Clinical::create([
            'patient_id'      => $patient_id,
            'complaint'       => $complaint,
            'lab_test'        => $lab_test,
            'treatment'       => $treatment
        ]);

        $patient = Patient::whereId($patient_id)->first();

        $patient_id = $patient->id;

        $page = $patient->name;

        $clinicals = Clinical::where('patient_id', $patient_id)->get();

        return redirect()->route('consult', [$patient_id])->with('success', 'Clinical history saved successfully.');
    }

    public function update($id)
    {   
        $clinical = Clinical::whereId($id)->first();

        $page = 'Update Clinical History';

        return view('core.pages.update-history', compact('page', 'clinical'));
    }

    public function updatehistory(Request $request)
    {   
        $this->validate($request, [
            'clinical_id'  => 'required|numeric|min:1',
        ]);

        $clinical_id   = $request->input('clinical_id');
        $complaint     = $request->input('complaint');
        $lab_test      = $request->input('lab_test');
        $treatment     = $request->input('treatment');

        Clinical::whereId($clinical_id)->update([
            'complaint'       => $complaint,
            'lab_test'        => $lab_test,
            'treatment'       => $treatment
        ]);

        $patient_id = Clinical::where('id', $clinical_id)->value('patient_id');

        return redirect()->route('consult', [$patient_id])->with('success', 'Clinical history updated successfully.');
    }

    public function deletehistory($id)
    {
        $clinical = Clinical::whereId($id)->first();

        $page = 'Delete Clinical History';

        return view('core.pages.delete-history', compact('page', 'clinical'));
    }

    public function postdeletehistory(Request $request)
    {   
        $this->validate($request, [
            'clinical_id'  => 'required|numeric|min:1',
        ]);

        $clinical_id   = $request->input('clinical_id');

        $patient_id = Clinical::where('id', $clinical_id)->value('patient_id');

        $page = 'Clinical History';

        $patient = Patient::whereId($patient_id)->first();

        Clinical::whereId($clinical_id)->delete();

        $clinicals = Clinical::where('patient_id', $patient->id)->get();

        return view('core.pages.clinical', compact('page', 'clinicals', 'patient'))->with('success', 'Clinical history deleted successfully.');
    }
}
