@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">Are you sure you want to delete this drug <strong>{{ $drug->name}} ({{$drug->formulation->name}})</strong>?</p>
    </div>
    <form method="POST" action="{{ url('delete-drug', $drug->id) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Delete Drug</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('drug', $drug->id) }}"><button class="btn fit-parent primary">No, Go Back</button></a>
    </div>
@endsection