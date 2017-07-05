<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Drug;
use cHealth\Formulation;
use DB;

class DrugsController extends Controller
{
    public function getpharmacy()
    {
    	$page = 'Pharmacy';

    	$drugs = Drug::get();

    	$no_of_drugs         = count($drugs);

        return view('core.pages.pharmacy', compact('page', 'drugs', 'no_of_drugs'));
    }

    public function getmedications()
    {
    	
    }

    public function postmedication()
    {
    	
    }

    public function deletemedication()
    {
    	
    }

    public function postsearchdrug(Request $request)
    {
    	$this->validate($request, [
          'search'              => 'required|min:1'
        ],
        [
          'search.required'     => 'You need to search a drug.',
        ]);

    	$query                  = $request->input('search');


        $drugs = Drug::where('name', 'LIKE', '%' . $query . '%')
            ->orwhere('stock', 'LIKE', '%' . $query . '%')
            ->orWhereHas('formulation', function ($term) use($query) {
	            $term->where('name','LIKE', '%' . $query . '%');
	        })
            ->get();

        if(count($drugs)==1)
        {
            $tense              = 'is';
            $result             = 'result.';
        }
        else
        {
            $tense              = 'are';
            $result             = 'results.';
        }

        $message                = 'There '. $tense . ' ' . count($drugs) . ' drug '. $result;

        $page                   = 'Pharmacy';

        $alldrugs               = Drug::get();
 
        $no_of_drugs         = count($alldrugs);


        return view('core.pages.pharmacy', compact('drugs', 'page', 'no_of_drugs'));
    }

    public function adddrug()
    {
    	$page = 'Add New Drug';

    	$formulations = Formulation::get();

    	return view('core.pages.new-drug', compact('page', 'formulations'));
    }

    public function postadddrug(Request $request)
    {
    	$this->validate($request, [
                'drug_name'     => 'required',
                'formulation'   => 'required',
                'stock'         => 'required|numeric',
        ]); 

        $drug_name   = $request->input('drug_name');
        $formulation = $request->input('formulation');
        $stock       = $request->input('stock');

        $drug = Drug::create([
        	'name'           => $drug_name,
        	'formulation_id' => $formulation,
        	'stock'          => $stock
        ]);

        return redirect('pharmacy')->with('success', 'New Drug added successfully!');
    }
    
    public function deletedrug($id)
    {	

    	$drug = Drug::whereId($id)->first();

    	$page = 'Delete Drug';

        return view('core.pages.delete-drug', compact('page', 'drug'));
    }

    public function postdeletedrug($id)
    {	

    	$drug = Drug::whereId($id)->first();

        $drug->delete();

        return redirect('pharmacy')->with('success', 'The drug has been deleted successfully!');
    }

    public function getdrug($id)
    {
    	$drug = Drug::whereId($id)->first();

    	$page = $drug->name;

        return view('core.pages.view-drug', compact('page', 'drug'));
    }

    public function addstock(Request $request, $id)
    {
    	$this->validate($request, [
                'quantity'   => 'required|numeric'
        ]); 

        $quantity = $request->input('quantity');

        $stock = Drug::whereId($id)->value('stock'); 

        $new_stock = $stock + $quantity;

        $drug = Drug::whereId($id)->update([
        	'stock' => $new_stock
        ]);

        return redirect()->route('drug', [$id])->with('success', 'Quantity added to stock successfully!');
    }

    public function removestock(Request $request, $id)
    {
    	$this->validate($request, [
                'quantity'   => 'required|numeric'
        ]); 

        $quantity = $request->input('quantity');

        $stock = Drug::whereId($id)->value('stock'); 

        $new_stock = $stock - $quantity;

        if($new_stock<0)
        {
        	$message = "Sorry, Cannot remove quantity more than in stock.";
        } else {
        	$drug = Drug::whereId($id)->update([
	        	'stock' => $new_stock
	        ]);

	        $message = "Quantity removed from stock successfully!";
        }
        
        return redirect()->route('drug', [$id])->with('success', $message);
    }
}
