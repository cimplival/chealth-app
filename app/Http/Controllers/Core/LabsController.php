<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Lab;
use cHealth\Patient;

class LabsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page                       = 'Lab Investigations';

        $labs                       = Lab::whereStatus(0)->get();

        $past_labs                  = Lab::whereStatus(1)->get();

        return view('core.pages.view-labs', compact('page', 'labs', 'past_labs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $page                       = 'Request Investigation';

        $patient                    = Patient::whereId($id)->first();

        return view('core.pages.new-lab', compact('page', 'patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $id)
    {   
        $this->validate($request, [
                'investigation_request'   => 'required|min:1|max:256'
        ]); 

        $investigation_request = $request->input('investigation_request');

        $lab = Lab::create([
            'patient_id'                 => $id,
            'investigation_request'      => $investigation_request,
            'status'                     => 0,
            'from_user'                  => 1
        ]);

        $patient_id = $lab->patient->id;

        return redirect()->route('consult', [$patient_id])->with('success', 'Lab investigation requested successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page                       = 'Update Lab Investigation';

        $lab                        = Lab::whereId($id)->first();

        return view('core.pages.update-lab', compact('page', 'lab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'specimen'                => 'required|min:1',
                'investigation_request'   => 'required|min:1|max:256'
        ]);

        $specimen                         = $request->input('specimen');
        $investigation_request            = $request->input('investigation_request');

        $patient                          = Lab::whereId($id)->update([
            'specimen'                    => $specimen,
            'investigation_request'       => $investigation_request,
            'status'                      => 1,
            'from_user'                   => 1
        ]);

        return redirect()->back()->with('success', 'Lab investigation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function confirmdestroy($id)
    {
        $lab                              = Lab::whereId($id)->first();

        $page                             = 'Delete Lab Record';

        return view('core.pages.delete-lab', compact('page', 'lab'));
    }

    public function postdeletelab($id)
    {
        $lab = Lab::whereId($id)->first();

        $patient_id = $lab->patient->id;

        $lab->delete();

        return redirect()->route('consult', [$patient_id])->with('success', 'Lab record deleted successfully.');
    }
}
