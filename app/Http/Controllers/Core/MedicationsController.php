<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Drug;
use cHealth\Medication;
use cHealth\Clinical;

class MedicationsController extends Controller
{	
	public function confirmadminister($id)
	{
		$page = 'Administer Medication';

		$clinical = Clinical::whereId($id)->first();

		return view('core.pages.confirm-administer', compact('page', 'clinical'));
	}

	public function newmedication(Request $request, $id)
	{
		$drugs        = Drug::get();

		$clinical     = Clinical::whereId($id)->first();

		$page         = $clinical->patient->name;

		$medications  = Medication::whereClinicalId($clinical->id)->get();

		return view('core.pages.new-medication', compact('page', 'drugs', 'clinical', 'medications'));
	}

    public function addmedication(Request $request, $id)
    {
    	$this->validate($request, [
    			'drug_id'       => 'required',
                'quantity'      => 'required|min:0|numeric',
                'times_a_day'   => 'required|min:0',
                'no_of_days'    => 'required|min:0|numeric'
        ]);

    	$drug_id                = $request->input('drug_id');
        $quantity               = $request->input('quantity');
        $times_a_day            = $request->input('times_a_day');
        $no_of_days             = $request->input('no_of_days');

        $administered           = $quantity * $times_a_day * $no_of_days;

        $in_stock               = Drug::whereId($drug_id)->value('stock');

        $new_stock              = $in_stock - $administered;

        if($new_stock<0)
        {
        	$message = 'Sorry there isn\'t enough medication in stock! There is only ' . $in_stock . ' in stock but you tried to administer ' . $administered . ' Please try again.';

        	return back()->with('error', $message);
        } else {

        	$clinical = Clinical::whereId($id)->first();

        	$drug = Drug::whereId($drug_id)->update([
        		'stock'      => $new_stock
        	]);

        	$medication = Medication::create([
        		'drug_id'      => $drug_id,
        		'clinical_id'  => $clinical->id,
        		'quantity'     => $quantity,
        		'times_a_day'  => $times_a_day, 
        		'no_of_days'   => $no_of_days
        	]);

        	$message = 'The medication has been administered successfully! You can administer another medication if needed.';

        	return redirect()->route('new-medication', [$id])->with('success', $message);
        }
    }

    public function getmedications()
    {
    	$page = 'Medications';

        $medications = Medication::get();

        $no_of_medications = count($medications);

        return view('core.pages.medications.index', compact('page', 'medications', 'no_of_medications'));
    }

    public function getdispensemedication($id)
    {
        $page = 'Confirm Dispensation';

        $medication = Medication::whereId($id)->first();

        return view('core.pages.medications.confirm-dispense', compact('page', 'medication'));
    }

    public function postdispensemedication($id)
    {
        $medication = Medication::whereId($id)->update([
            'status' => 1
        ]);

        return redirect('medications')->with('success', 'Medication dispensed successfully!');
    }

    public function deletemedication($id)
    {
    	$page = 'Delete Medication';

        $medication = Medication::whereId($id)->first();

        return view('core.pages.medications.confirm-delete', compact('page', 'medication'));
    }

    public function postdeletemedication($id)
    {   
        $medication = Medication::whereId($id)->first();

        $patient_id = $medication->clinical->patient->id;

        $medication->delete();

        return redirect()->route('consult', [$patient_id])->with('success', 'Medication deleted successfully!');
    }

    public function searchmedication(Request $request)
    {
        $this->validate($request, [
          'search'              => 'required|min:1'
        ],
        [
          'search.required'     => 'You need to search a medication.',
        ]);

        $query                  = $request->input('search');

        $medications = Medication::where('quantity', 'LIKE', '%' . $query . '%')
            ->orwhere('times_a_day', 'LIKE', '%' . $query . '%')
            ->orwhere('no_of_days', 'LIKE', '%' . $query . '%')
            ->orWhereHas('drug', function ($term) use($query) {
                $term->where('name','LIKE', '%' . $query . '%');
            })->get();


        if(count($medications)==1)
        {
            $tense              = 'is';
            $result             = 'result.';
        }
        else
        {
            $tense              = 'are';
            $result             = 'results.';
        }

        $message                = 'There '. $tense . ' ' . count($medications) . ' medication '. $result;

        $page                   = 'Medications';

        $allmedications         = Medication::get();
 
        $no_of_medications      = count($allmedications);

        return view('core.pages.medications.index', compact('medications', 'page', 'no_of_medications'));
    }
}
