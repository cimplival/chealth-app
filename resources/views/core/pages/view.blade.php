@extends('layouts.app')

@section('body')
    <div class="padded-full">

        <ul class="list">
            <li><strong>Outpatient/Inpatient No:</strong> {{ $patient->op_no }}</li>
            <li><strong>Age:</strong> {{ $patient->age }} years old</li>
            <li><strong>Gender:</strong> {{ $patient->gender }}</li>
            
            @if($patient->phone)
                <li><strong>Phone:</strong> {{ $patient->phone }}</li>
            @endif

            @if($patient->physical_address)
                <li><strong>Physical Address:</strong> {{ $patient->physical_address }}</li>
            @endif

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

        @if(!$waitlist)
            <a href="{{ url('waitlist', $patient->id) }}">
                <button class="btn fit-parent" style="margin-top: 15px;">Add to Patient Waitlist</button>
            </a>
        @else
            <a href="{{ url('consult', $patient->id) }}">
                <button class="btn fit-parent primary" style="margin-top: 15px;">Consult Patient</button>
            </a>
        @endif

    </div>
@endsection