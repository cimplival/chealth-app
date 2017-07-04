@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">Are you sure you want to remove this radiology from the lab?</p>
    </div>
    <form method="POST" action="{{ url('remove-radiology/'. $lab->id . '/' . $radio_id) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Remove Radiology</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ route('labs.edit', $lab->id) }}"><button class="btn fit-parent primary">No, Go Back</button></a>
    </div>
@endsection