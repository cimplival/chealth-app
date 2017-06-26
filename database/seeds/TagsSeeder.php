<?php

use Illuminate\Database\Seeder;
use cHealth\Tag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('tags')->delete(); 

    	$diseases = [
	    	'Diarrhoea',
	    	'Tuberculosis',
	    	'Dysentery (Bloody Diarrhoea)',
	    	'Cholera',
	    	'Meningococcal Meningitis',
	    	'Other Meningitis',
	    	'Tetanus',
	    	'Poliomyelitis (AFP)',
	    	'Chicken Pox',
	    	'Measles',
	    	'Hepatitis',
	    	'Mumps',
	    	'Fevers',
	    	'Suspected Malaria',
	    	'Confirmed Malaria',
	    	'Malaria in Pregnancy',
	    	'Typhoid Fever',
	    	'Sexually Transmitted Infections',
	    	'Urinary Tract Infection',
	    	'Bilhazia',
	    	'Intenstinal Worms',
	    	'Malnutrition',
	    	'Anaemia',
	    	'Eye Infections',
	    	'Other Eye Conditions',
	    	'Ear Infections/ Conditions',
	    	'Upper Respiratory Tract Infections',
	    	'Asthma',
	    	'Pneumonia',
	    	'Other Diseases of Respiratory System',
	    	'Abortion',
	    	'Diseases of Puerperium and Childbirth',
	    	'Hypertension',
	    	'Mental Disorders',
	    	'Dental Disorders',
	    	'Jiggers Infestation',
	    	'Diseases of the Skin',
	    	'Anthritis, Joint Pains etc',
	    	'Poisoning',
	    	'Road Traffic Injuries',
	    	'Other Injuries',
	    	'Sexual Assult',
	    	'Violence Related Injuries',
	    	'Burns',
	    	'Snake Bites',
	    	'Dog Bites',
	    	'Other Bites',
	    	'Diabetes',
	    	'Epilepsy',
	    	'Newly Diagnosed HIV',
	    	'Brucellosis',
	    	'Cardiovascular Conditions',
	    	'Central Nervous System Conditions',
	    	'Overweight (BMI>25)',
	    	'Muscular Skeletal Conditions',
	    	'Fistula (Birth Related)',
	    	'Neoplams',
	    	'Physical Disability',
	    	'Typonosomiasis',
	    	'Kalazar (Leishmaniaisis)',
	    	'Dracunculosis',
	    	'Yellow Fever',
	    	'Viral Haemorrhagic Fever',
	    	'Plague',
	    	'Deaths due to Road Traffic Injuries',
	    	'All Other Diseases'
    	];

    	for($i=0; $i<count($diseases); $i++)
    	{	
    		Tag::create([
    			'disease_id'    => $i+1,
    			'name'          => strtolower($diseases[$i])
    			]);
    	}
    }
}
