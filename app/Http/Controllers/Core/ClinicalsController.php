<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use DB;
use cHealth\Patient;
use cHealth\Clinical;
use cHealth\Waiting;
use cHealth\Lab;
use cHealth\DiseaseCount;
use cHealth\Tag;
use cHealth\Attendance;
use cHealth\Referral;
use cHealth\Disease;
use Session;
use Phpml\Classification\NaiveBayes;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\Dataset\ArrayDataset;
use Phpml\Metric\Accuracy;

class ClinicalsController extends Controller
{
    public function index()
    {	
        $labs                   = Lab::get();

        $referrals              = Referral::get();

        $all_referrals          = ['From Other Health Facilities', 'To Other Health Facilities', 'From Community Unit', 'To Community Unit'];

        $no_of_patients         = count(Patient::get());

        $patients               = Patient::get();

        $page                   = 'Medical Records';

    	return view('core.pages.records', compact('page', 'no_of_patients', 'labs', 'referrals', 'all_referrals', 'patients'));
    }

    public function search(Request $request)
    {	
    	$this->validate($request, [
          'search'              => 'required|min:1'
        ],
        [
          'search.required'     => 'You need to search a patient.',
        ]);

    	$query                  = $request->input('search');

        $patients = DB::table('patients')->where('name', 'LIKE', '%' . $query . '%')
            ->orwhere('op_no', 'LIKE', '%' . $query . '%')
            ->orWhere('age', 'LIKE', '%' . $query . '%')
            ->orWhere('gender', 'LIKE', '%' . $query . '%')
            ->orWhere('phone', 'LIKE', '%' . $query . '%')
            ->get();

        if(count($patients)==1)
        {
            $tense              = 'is';
            $result             = 'result.';
        }
        else
        {
            $tense              = 'are';
            $result             = 'results.';
        }

        $message                = 'There '. $tense . ' ' . count($patients) . ' patient '. $result;

        $page                   = 'Medical Records';

        $allpatients            = Patient::get();
 
        $no_of_patients         = count($allpatients);


        return view('core.pages.records', compact('patients', 'page', 'no_of_patients'));

    }

    public function history($id)
    {
        $patient                = Patient::where('id', $id)->first();

        $page                   = $patient->name;

        $diseases               = Disease::get();

        return view('core.pages.new-history', compact('page', 'patient', 'new-history', 'diseases'));
    }


    public function new(Request $request)
    {
        $this->validate($request, [
                'patient_id'       => 'required|numeric|min:1',
                'classify_disease' => 'required'
        ]);

        $patient_id             = $request->input('patient_id');
        $chief_complaint        = $request->input('chief_complaint');
        $review_of_system       = $request->input('review_of_system');
        $pmshx                  = $request->input('pmshx');
        $investigations         = $request->input('investigations');
        $diagnosis              = $request->input('diagnosis');
        $management             = $request->input('management');
        $reattendance           = $request->input('reattendance');
        $classify_disease       = $request->input('classify_disease');

        $clinical               = Clinical::create([
            'patient_id'        => $patient_id,
            'chief_complaint'   => $chief_complaint,
            'review_of_system'  => $review_of_system,
            'pmshx'             => $pmshx,
            'investigations'    => $investigations,
            'diagnosis'         => $diagnosis,
            'management'        => $management
        ]);

        if($reattendance=="1")
        {
            Attendance::create([
                'patient_id'              => $patient_id,
                'clinical_id'             => $clinical->id,
                'status'                  => 1
            ]);
        } else {
            Attendance::create([
                'patient_id'              => $patient_id,
                'clinical_id'             => $clinical->id,
                'status'                  => 0
            ]);
        }


         // Count Diseases
        $diagnosis_input = $clinical->diagnosis;

        $diseases_tags = Tag::get();

        $count_diseases_tags = count($diseases_tags);


        $diagnosis = strtolower($diagnosis);



        //php machine learning naive bayes algorithm to add diagnosis to disease classification tag


        //for samples
        $samples = [];

        foreach ($diseases_tags as $diseases_tag) {

            $samples[] = strtolower($diseases_tag->name);
        }


        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

        $vectorizer->fit($samples);

        $vectorizer->transform($samples);



        $tfIdfTransformer = new TfIdfTransformer();

        $tfIdfTransformer->fit($samples);
        
        $tfIdfTransformer->transform($samples);



        //for labels

        $labels = [];

        foreach ($diseases_tags as $diseases_tag) {

            $labels[] = $diseases_tag->disease_id;
        }


        $dataset = new ArrayDataset($samples, $labels);

        $randomSplit = new StratifiedRandomSplit($dataset, 0.1);

        $trainingSamples = $randomSplit->getTrainSamples();
        
        $trainingLabels  = $randomSplit->getTrainLabels();

        $testSamples = $randomSplit->getTestSamples();
        
        $testLabels  = $randomSplit->getTestLabels();


        //train data

        $classifier = new NaiveBayes;

        $classifier->train($testSamples, $testLabels);


        //get diagnosis input, vectorize and transform

        $diagnosis_collection = [];

        $diagnosis_collection[] = $diagnosis;


        $vectorizer->fit($diagnosis_collection);

        $vectorizer->transform($diagnosis_collection);


        $predictedLabels = $classifier->predict($diagnosis_collection);

        $accuracy = Accuracy::score($testSamples, $testLabels);

        //count no of disease, check whether all have tags similar to input 
        //if not create a tag, if yes use its tag to create a disease count.


        $classify_disease_tag = Tag::where('name', $diagnosis)->first();

        if(!$classify_disease_tag)
        {
            $tag = Tag::create([
                    'disease_id' => $classify_disease,
                    'name'       => $diagnosis
                ]);

            $latest_tag = $tag->id;
        } else {

            $latest_tag = $classify_disease_tag->id;
        }

        //Disease count
        $classify_disease = DiseaseCount::create([
            'disease_id' => $classify_disease,
            'patient_id' => $patient_id,                
            'tag_id'     => $latest_tag,
            'from_user'  => 1
        ]);


        Waiting::where('patient_id', $patient_id)
            ->update([
                'status'            => 0
            ]);

        $patient                = Patient::whereId($patient_id)->first();

        $patient_id             = $patient->id;

        $page                   = $patient->name;

        $clinicals              = Clinical::where('patient_id', $patient_id)->get();

        return redirect()->route('consult', [$patient_id])->with('success', 'Clinical history saved successfully.');
    }


    public function update($id)
    {   
        $clinical               = Clinical::whereId($id)->first();

        $page                   = 'Update Clinical History';

        return view('core.pages.update-history', compact('page', 'clinical'));
    }

    public function updatehistory(Request $request)
    {   
        $this->validate($request, [
            'clinical_id'       => 'required|numeric|min:1',
        ]);

        $clinical_id            = $request->input('clinical_id');
        $chief_complaint        = $request->input('chief_complaint');
        $review_of_system       = $request->input('review_of_system');
        $pmshx                  = $request->input('pmshx');
        $investigations         = $request->input('investigations');
        $diagnosis              = $request->input('diagnosis');
        $management             = $request->input('management');

        Clinical::whereId($clinical_id)->update([
            'chief_complaint'   => $chief_complaint,
            'review_of_system'  => $review_of_system,
            'pmshx'             => $pmshx,
            'investigations'    => $investigations,
            'diagnosis'         => $diagnosis,
            'management'        => $management
        ]);

        $patient_id = Clinical::where('id', $clinical_id)->value('patient_id');

        return redirect()->route('consult', [$patient_id])->with('success', 'Clinical history updated successfully.');
    }

    public function deletehistory($id)
    {
        $clinical               = Clinical::whereId($id)->first();

        $page                   = 'Delete Clinical History';

        return view('core.pages.delete-history', compact('page', 'clinical'));
    }

    public function postdeletehistory(Request $request)
    {   
        $this->validate($request, [
            'clinical_id'       => 'required|numeric|min:1',
        ]);

        $clinical_id            = $request->input('clinical_id');
 
        $patient_id             = Clinical::where('id', $clinical_id)->value('patient_id');

        $page                   = 'Clinical History';

        $patient                = Patient::whereId($patient_id)->first();

        Clinical::whereId($clinical_id)->delete();

        $clinicals              = Clinical::where('patient_id', $patient->id)->get();

        return view('core.pages.clinical', compact('page', 'clinicals', 'patient'))->with('success', 'Clinical history deleted successfully.');
    }

    public function referrals($id)
    {
        $page                   = 'Add Referrals';

        $patient                = Patient::whereId($id)->first();

        return view('core.pages.referrals', compact('page', 'patient'));
    }

    public function postreferral($id, $referral)
    {
        $page                   = 'Confirm Referral';

        $patient                = Patient::whereId($id)->first();

        $referrals = ['From Other Health Facilities', 'To Other Health Facilities', 'From Community Unit', 'To Community Unit'];

        $selected_referral = $referrals[$referral];

        return view('core.pages.confirm-referral', compact('page', 'patient', 'selected_referral', 'referral'));
    }

    public function addreferral(Request $request, $id, $referral)
    {      
        $this->validate($request, [
            'institution'       => 'required|min:1',
        ]);

        $institution =  $request->input('institution');

        Referral::create([
            'patient_id' => $id,
            'referral_id' => $referral,
            'institution' => $institution
        ]);

        $patient_id = $id;

        return redirect()->route('consult', [$patient_id])->with('success', 'Referral added successfully.');
    }
}
