@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <ul class="list">
            <li><strong>Name:</strong> {{ $patient->name }}</li>
            <li><strong>Age:</strong> {{ $patient->age }} years old</li>
            <li><strong>Gender:</strong> {{ $patient->gender }}</li>
            <li><strong>Phone:</strong> {{ $patient->phone }}</li>
            
        </ul>
        @if($clinical)
            <h6 class="pull-right"><strong></strong></h6>
            <a href="{{ url('view-record', $patient->id) }}">
                <button class="btn fit-parent" style="margin-top: 15px;">View Medical Record</button>
            </a>
        @else
            <p class="padded-full text-center">
                <i>Patient has no clinical history.</i>
            </p>
        @endif
            <a href="{{ url('consult', $patient->id) }}">
                <button class="btn fit-parent primary" style="margin-top: 15px;">Consult Patient</button>
            </a>
    </div>
@endsection