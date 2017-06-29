<?php

namespace cHealth\Http\Controllers\Core;

use Illuminate\Http\Request;
use cHealth\Http\Controllers\Controller;
use cHealth\Disease;
use cHealth\DiseaseCount;
use Excel;
use cHealth\Setting;
use cHealth\Attendance;
use cHealth\Referral;

class ReportsController extends Controller
{
	public function index()
	{	
		$page = 'Reports';

		return view('core.pages.reports', compact('page'));
	}

	public function diseasesreports()
	{
		$page = 'Diseases Report';

		return view('core.pages.diseases-reports', compact('page'));
	}

	public function outpatientreports()
	{
		$page = 'Outpatient Report';

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


			$excel->sheet('Disease Report', function($sheet) use($diseases, $year, $month, $months, $form, $age_test) {

				$sheet->setOrientation('landscape');

				$count_diseases = count($diseases)+10;

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

				$setting = Setting::first();

				$sheet->cell('B2', function($cell) use($setting) {
					$cell->setValue('Facility Name: '. $setting->facility_name );
					$cell->setFontWeight('bold');
				});

				$sheet->cell('C2', function($cell) use($setting) {
					$cell->setValue('Ward: '. $setting->ward);
					$cell->setFontWeight('bold');
				});

				$sheet->cell('J2', function($cell) use($setting) {
					$cell->setValue('Sub-county: '. $setting->sub_county);
					$cell->setFontWeight('bold');
				});

				$sheet->cell('P2', function($cell) use($setting) {
					$cell->setValue('County: ' .$setting->county);
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



				$count_numbers = count($diseases) + 6;
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

		    	//Make bold and center cells C4 to AG4
				$sheet->cells('C4:AG4', function($cells) {
					$cells->setFontWeight('bold');
					$cells->setAlignment('center');
				});

				//Make bold and center cells C4 to AG4
				$sheet->cells('C5:AH76', function($cells) {
					$cells->setAlignment('center');
				});

				//Make bold and center cells C4 to AG4
				$sheet->cells('C4:AG4', function($cells) {
					$cells->setFontWeight('bold');
					$cells->setAlignment('center');
				});

				$sheet->cell('B4', function($cell) {
					$cell->setValue('Diseases (New Cases Only)');
					$cell->setFontWeight('bold');
					$cell->setAlignment('center');
				});

				$sheet->cell('AH4', function($cell) {
					$cell->setValue('Total');
					$cell->setFontWeight('bold');
					$cell->setAlignment('center');
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


				

				//no of first attendances
				$first_reattendances = ['67', 'No. of first attendances'];

				for($i=1; $i<32; $i++)
				{	
					
					$first_reattendance = count(Attendance::whereYear('created_at', $year)
						->whereMonth('created_at', $month+1)
						->whereDay('created_at', $i)
						->whereStatus(0)
						->get());

					$first_reattendances[] = $first_reattendance;


					$sheet->row(71, $first_reattendances);
				}

				//total first attendances for month
				$total_first_attendance = count(Attendance::whereYear('created_at', $year)
						->whereMonth('created_at', $month+1)
						->whereStatus(0)
						->get());

				$sheet->cell('AH71', function($cell) use($total_first_attendance){
					$cell->setValue($total_first_attendance);
				});

				//no of reattendances
				$no_reattendances = ['68', 'Re-attendances'];

				for($i=1; $i<32; $i++)
				{	
					
					$no_reattendance = count(Attendance::whereYear('created_at', $year)
						->whereMonth('created_at', $month+1)
						->whereDay('created_at', $i)
						->whereStatus(1)
						->get());

					$no_reattendances[] = $no_reattendance;


					$sheet->row(72, $no_reattendances);
				}

				//total reattendances for month
				$total_month_reattendance = count(Attendance::whereYear('created_at', $year)
						->whereMonth('created_at', $month+1)
						->whereStatus(1)
						->get());

				$sheet->cell('AH72', function($cell) use($total_month_reattendance){
					$cell->setValue($total_month_reattendance);
				});

				//referalls
				for($t=0; $t<4; $t++)
				{	
					$referrals = ['', ''];

					for($i=1; $i<32; $i++)
					{	
						$referral = count(Referral::whereYear('created_at', $year)
							->whereMonth('created_at', $month+1)
							->whereDay('created_at', $i)
							->where('referral_id', $t)
						->get());

						$referrals[] = $referral;

						$sheet->row(73+$t, $referrals);
					}


					//total referrals
					$total_referrals = count(Referral::whereYear('created_at', $year)
							->whereMonth('created_at', $month+1)
							->where('referral_id', $t)
							->get());

					$g = 73 + $t;
					
					$sheet->cell('AH' . $g, function($cell) use($total_referrals){
						$cell->setValue($total_referrals);
					});
				}

				$summary = array('No. of first attendances', 'Re-attendances', 'Referrals from other health facilities', 'Referrals to other health facilities', 'Referrals from community unit', 'Referrals to community unit');

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

})->download('xlsx');
}

public function postoutpatient(Request $request)
{
	$this->validate($request, [
		'month'             => 'required',
		'year'              => 'required'
		]);

	$month                      = $request->input('month');
	$year                       = $request->input('year');

	$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


	Excel::create('Outpatient Report', function($excel) use($year, $month, $months){


		$excel->sheet('Outpatient Report', function($sheet) use($year, $month, $months) {

			$sheet->setPageMargin(array(
			    1.0, 0.35, 0.35, 0.50
			));

			$sheet->mergeCells('A1:I2');

			$sheet->mergeCells('A3:I3');

			$sheet->mergeCells('A4:I4');

			$sheet->mergeCells('A5:I5');

			$sheet->mergeCells('A6:I6');

			$sheet->mergeCells('C8:D8');

			$sheet->mergeCells('E8:F8');

			$sheet->setWidth(array(
				'A'         =>  12,
				'B'         =>  12,
				'C'		    =>  12,
				'D'		    =>  12,
				'E'		    =>  12,
				'F'		    =>  12,
				'G'		    =>  12
				));

			$setting = Setting::first();

			$sheet->cell('A1', function($cell) use($setting) {
				$cell->setValue($setting->facility_name);
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
				$cell->setFontSize(15);
			});

			$sheet->cell('A3', function($cell) use($setting) {
				$cell->setValue($setting->ward);
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('A4', function($cell) use($setting) {
				$cell->setValue($setting->sub_county . ', '. $setting->county);
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('A5', function($cell) use($month, $months, $year){
				$cell->setValue('Month: '. $months[$month] .', Year: '. $year);
				$cell->setAlignment('right');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});


		    	//Make bold cells C4 to AG4
			$sheet->cells('C4:AG4', function($cells) {
				$cells->setFontWeight('bold');
			});

			$sheet->cell('A6', function($cell) {
				$cell->setValue('Outpatient Attendance Report');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('B8', function($cell) {
				$cell->setValue('Date');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('C8', function($cell) {
				$cell->setValue('Males');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('E8', function($cell) {
				$cell->setValue('Females');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('G8', function($cell) {
				$cell->setValue('Totals');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('C9', function($cell) {
				$cell->setValue('New');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('D9', function($cell) {
				$cell->setValue('Reatt');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('E9', function($cell) {
				$cell->setValue('New');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('F9', function($cell) {
				$cell->setValue('Reatt');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('B41', function($cell) {
				$cell->setValue('Totals');
				$cell->setFontWeight('bold');
				$cell->setAlignment('center');
			});

			$sheet->cell('B42', function($cell) {
				$cell->setValue('Grand Totals');
				$cell->setFontWeight('bold');
			});

			$sheet->cell('C48', function($cell) {
				$cell->setValue('Prepared by:');
				$cell->setFontWeight('bold');
			});

			$sheet->cell('F48', function($cell) {
				$cell->setValue('Date: ');
				$cell->setFontWeight('bold');
			});


			$sheet->setBorder('B8:G42', 'thin');


			for($i=1; $i<=31; $i++)
			{
				$count_cells =['',$i];
				$sheet->row($i+9, $count_cells);
				$c = $i+9;
				$sheet->cell('B'.$c, function($cell) {
					$cell->setAlignment('center');
				});
			}

			//for male attendance
			for($j=1; $j<=31; $j++)
			{
				$male_attendance = count(Attendance::whereYear('created_at', $year)
					->whereMonth('created_at', $month+1)
					->whereDay('created_at', $j)
					->whereStatus(0)
					->whereHas('patient', function($q) {
						$q->where('gender','=','Male');
					})->get());

				$t=9+$j;

				$sheet->cell('C'.$t, function($cell) use($male_attendance) {
					$cell->setValue($male_attendance);
					$cell->setAlignment('center');
				});
			}

			//for female attendance
			for($j=1; $j<=31; $j++)
			{
				$female_attendance = count(Attendance::whereYear('created_at', $year)
					->whereMonth('created_at', $month+1)
					->whereDay('created_at', $j)
					->whereStatus(0)
					->whereHas('patient', function($q) {
						$q->where('gender','=','Female');
					})->get());

				$t=9+$j;

				$sheet->cell('E'.$t, function($cell) use($female_attendance) {
					$cell->setValue($female_attendance);
					$cell->setAlignment('center');
				});
			}


		    //for male reattendance
			for($j=1; $j<=31; $j++)
			{
				$male_reattendance = count(Attendance::whereYear('created_at', $year)
					->whereMonth('created_at', $month+1)
					->whereDay('created_at', $j)
					->whereStatus(1)
					->whereHas('patient', function($q) {
						$q->where('gender','=','Male');
					})->get());

				$t=9+$j;

				$sheet->cell('D'.$t, function($cell) use($male_reattendance) {
					$cell->setValue($male_reattendance);
					$cell->setAlignment('center');
				});
			}

			//for female reattendance
			for($j=1; $j<=31; $j++)
			{
				$female_reattendance = count(Attendance::whereYear('created_at', $year)
					->whereMonth('created_at', $month+1)
					->whereDay('created_at', $j)
					->whereStatus(1)
					->whereHas('patient', function($q) {
						$q->where('gender','=','Female');
					})->get());

				$t=9+$j;

				$sheet->cell('F'.$t, function($cell) use($female_reattendance) {
					$cell->setValue($female_reattendance);
					$cell->setAlignment('center');
				});
			}

			//for total of attendances and reattendance (right column)
			for($j=1; $j<=31; $j++)
			{
				$female_reattendance = count(Attendance::whereYear('created_at', $year)
					->whereMonth('created_at', $month+1)
					->whereDay('created_at', $j)
					->get());

				$t=9+$j;

				$sheet->cell('G'.$t, function($cell) use($female_reattendance) {
					$cell->setValue($female_reattendance);
					$cell->setAlignment('center');
				});
			}

			//for totals male attendance
			$total_male_attendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(0)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Male');
				})->get());

			$sheet->cell('C41', function($cell) use($total_male_attendance) {
				$cell->setValue($total_male_attendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for totals male reattendance
			$total_male_reattendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(1)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Male');
				})->get());

			$sheet->cell('D41', function($cell) use($total_male_reattendance) {
				$cell->setValue($total_male_reattendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for totals female attendance
			$total_female_attendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(0)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Female');
				})->get());

			$sheet->cell('E41', function($cell) use($total_female_attendance) {
				$cell->setValue($total_female_attendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for totals female reattendance
			$total_female_reattendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(1)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Female');
				})->get());

			$sheet->cell('F41', function($cell) use($total_female_reattendance) {
				$cell->setValue($total_female_reattendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for totals totals
			$outpatient_totals= count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)->get());

			$sheet->cell('G41', function($cell) use($outpatient_totals) {
				$cell->setValue($outpatient_totals);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});



			//for grand totals male attendance
			$total_male_attendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(0)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Male');
				})->get());

			$sheet->cell('C42', function($cell) use($total_male_attendance) {
				$cell->setValue($total_male_attendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for grand totals male reattendance
			$total_male_reattendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(1)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Male');
				})->get());

			$sheet->cell('D42', function($cell) use($total_male_reattendance) {
				$cell->setValue($total_male_reattendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for grand totals female attendance
			$total_female_attendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(0)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Female');
				})->get());

			$sheet->cell('E42', function($cell) use($total_female_attendance) {
				$cell->setValue($total_female_attendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for grand totals female reattendance
			$total_female_reattendance = count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)
				->whereStatus(1)
				->whereHas('patient', function($q) {
					$q->where('gender','=','Female');
				})->get());

			$sheet->cell('F42', function($cell) use($total_female_reattendance) {
				$cell->setValue($total_female_reattendance);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

			//for grand totals totals
			$outpatient_totals= count(Attendance::whereYear('created_at', $year)
				->whereMonth('created_at', $month+1)->get());

			$sheet->cell('G42', function($cell) use($outpatient_totals) {
				$cell->setValue($outpatient_totals);
				$cell->setAlignment('center');
				$cell->setFontWeight('bold');
			});

		});

})->download('xlsx');
}
}	
