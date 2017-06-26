<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Disease;
use cHealth\DiseaseCount;
use Excel;

class ReportsController extends Controller
{
    public function index()
    {	
    	$page = 'Reports';

    	return view('core.pages.reports', compact('page'));
    }

    public function diseasesreports()
    {
    	$page = 'Diseases Reports';

    	return view('core.pages.diseases-reports', compact('page'));
    }

    public function outpatientreports()
    {
    	$page = 'Outpatient Reports';

    	return view('core.pages.outpatient-reports', compact('page'));
    }

    public function postdiseases(Request $request)
    {
    	$this->validate($request, [
                'month'             => 'required',
                'year'              => 'required',
                'period'            => 'required'
        ],
        [
          'period.required'     => 'You need to choose the age set for the report.',
        ]);

        $month                      = $request->input('month');
        $year                       = $request->input('year');
        $period                     = $request->input('period');

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        if($period=='under5')
        {
        	$form = 'MOH 705A';
        	$age_test = '<=';
        } else {
        	$form = 'MOH 705B';
        	$age_test = '>';
        }
        
        $diseases = Disease::get();

        Excel::create('Disease Report', function($excel) use($diseases, $year, $month, $months, $form, $age_test){


		    $excel->sheet('Disease Reports', function($sheet) use($diseases, $year, $month, $months, $form, $age_test) {
		    	
		    	$sheet->setOrientation('landscape');

		    	$count_diseases = count($diseases)+11;

		    	$sheet->setBorder('B4:AI'. $count_diseases, 'thin');

		    	$sheet->setWidth(array(
				    'A'     =>  5,
				    'B'     =>  45,
				    'C'		=>  5,
				    'D'		=>  5,
				    'E'		=>  5,
				    'F'		=>  5,
				    'G'		=>  5,
				    'H'		=>  5,
				    'I'		=>  5,
				    'J'		=>  5,
				    'K'		=>  5,
				    'L'		=>  5,
				    'M'		=>  5,
				    'N'		=>  5,
				    'O'		=>  5,
				    'P'		=>  5,
				    'Q'		=>  5,
				    'R'		=>  5,
				    'S'		=>  5,
				    'T'		=>  5,
				    'U'		=>  5,
				    'V'		=>  5,
				    'W'		=>  5,
				    'X'		=>  5,
				    'Y'		=>  5,
				    'Z'		=>  5,
				    'AA'	=>  5,
				    'AB'	=>  5,
				    'AC'	=>  5,
				    'AD'	=>  5,
				    'AE'	=>  5,
				    'AF'	=>  5,
				    'AG'	=>  5,
				    'AF'	=>  5,
				    'AH'	=>  5,
				    'AI'	=>  3,
				));

		    	$sheet->cell('B2', function($cell) {
				    $cell->setValue('Facility Name:');
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('C2', function($cell) {
				    $cell->setValue('Ward: ');
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('J2', function($cell) {
				    $cell->setValue('Sub-county: ');
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('P2', function($cell) {
				    $cell->setValue('County:');
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('U2', function($cell) use($month, $months){
				    $cell->setValue('Month: '. $months[$month]);
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('Z2', function($cell) use($year){
				    $cell->setValue('Year: '.$year);
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('AG2', function($cell) use($form){
				    $cell->setValue($form);
				    $cell->setFontWeight('bold');
				    $cell->setBorder('solid', 'solid', 'solid', 'solid');
				});



				$count_numbers = count($diseases) + 7;
				//Disease Numbers right column
				for($i=1; $i<=$count_numbers; $i++)
		    	{	
		    		$p = 4+$i;
		    		$j = 'AI'.$p;
					$sheet->cell($j, function($cell) use($i) {
					    $cell->setValue($i);
					});
		    	}

				$days = array('', '');

		    	for($i=1; $i<32; $i++)
		    	{	
		    		$days[] = $i;
					$sheet->row(4, $days);
		    	}

		    	//Make bold cells C4 to AG4
		    	$sheet->cells('C4:AG4', function($cells) {
					$cells->setFontWeight('bold');
				});

		    	$sheet->cell('B4', function($cell) {
				    $cell->setValue('Diseases (New Cases Only)');
				    $cell->setFontWeight('bold');
				});

				$sheet->cell('AH4', function($cell) {
				    $cell->setValue('Total');
				    $cell->setFontWeight('bold');
				});

		    	for($i=1; $i<=count($diseases); $i++)
		    	{
		    		$disease = Disease::whereId($i)->first();
		    		
		    		$count_cells =[$i,$disease->name];

		    		//for cells count
		    		for($j=1; $j<=31; $j++)
		    		{
		    			$disease_day = count(DiseaseCount::where('disease_id', $disease->id)
		    			->whereYear('created_at', $year)
		    			->whereMonth('created_at', $month+1)
		    			->whereDay('created_at', $j)
		    			->whereHas('patient', function($q) use($age_test) {
						    $q->where('age', $age_test , 5);
						})->get());

		    			$count_cells[]= $disease_day;
		    		}

		    		//for total
		    		$disease_month = count(DiseaseCount::where('disease_id', $disease->id)
		    			->whereYear('created_at', $year)
		    			->whereMonth('created_at', $month+1)
		    			->whereHas('patient', function($q) use($age_test) {
						    $q->where('age', $age_test , 5);
						})->get());

		    		$count_cells[]= $disease_month;

					$sheet->row($i+4, $count_cells);
		    	}


		    	$summary = array('No. of first attendances', 'Re-attendances', 'Referrals from other health facilities', 'Referrals to other health facilities', 'Referral from community unit', 'Referalls to community unit');

		    	for($i=0; $i<count($summary); $i++)
		    	{	
					$p = count($diseases)+5+$i;
		    		$j = 'B'.$p;
		    		$summary_item = $summary[$i];

					$sheet->cell($j, function($cell) use($summary_item) {
					    $cell->setValue($summary_item);
					    $cell->setFontWeight('bold');
					});

					$k = 'A'.$p;

					$p = $p-4;
					$sheet->cell($k, function($cell) use($p) {
					    $cell->setValue($p);
					    $cell->setFontWeight('bold');
					});

		    	}

		    });

		})->export('xlsx');
    }

    public function postoutpatient(Request $request)
    {
    	$this->validate($request, [
                'op_no'             => 'required|unique:patients',
                'name'              => 'required|min:1|max:256',
                'age'               => 'required|min:0|max:125',
                'gender'            => 'required'
        ]);
    }
}	
