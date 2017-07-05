@extends('layouts.app')

@section('partials')

@if (Session::has('info'))
@include('core.partials.info')
@endif

@if (Session::has('success'))
@include('core.partials.success')
@endif

@if (Session::has('error'))
@include('core.partials.error')
@endif

@if (Session::has('errors'))
@include('core.partials.errors')
@endif

@endsection


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

    <ul class="list">
        <li class="divider text-center"><p><strong>Medical Information</strong></p> </li>
    </ul>
    
    <a href="{{ url('history', $patient->id) }}">
        <button class="btn fit-parent primary" style="margin-top: 10px;">Create New History</button>
    </a>

    @if($clinicals)


    @foreach($clinicals->reverse() as $clinical)
    <ul class="list">
        <li>
            <i class="pull-right icon icon-expand-more"></i>
            <a href="#" class="padded-list">Clinical History for {{ \Carbon\Carbon::parse($clinical->created_at)->toFormattedDateString() }}</a>
            <div class="accordion-content bd-clinical">
                <div class="padded-top">

                    @if($clinical->chief_complaint)
                    <h5 style="padding-top: 25px;"><strong>Chief Complaint:</strong></h5>
                    <p class="padded-full">
                        {{$clinical->chief_complaint}}
                    </p>
                    @endif

                    @if($clinical->review_of_system)
                    <h5 style="padding-top: 25px;"><strong>Review of System:</strong></h5>
                    <p class="padded-full">
                        {{$clinical->review_of_system}}
                    </p>
                    @endif

                    @if($clinical->pmshx)
                    <h5><strong>PMSHx:</strong></h5>
                    <p class="padded-full">
                        {{$clinical->pmshx}}
                    </p>
                    @endif

                    @if($clinical->investigations)
                    <h5><strong>Investigations (Lab/X-ray):</strong></h5>
                    <p class="padded-full">
                        {{$clinical->investigations}}
                    </p>
                    @endif

                    @if($clinical->diagnosis)
                    <h5><strong>Diagnosis:</strong></h5>
                    <p class="padded-full">
                        {{$clinical->diagnosis}}
                    </p>
                    @endif

                    @if($clinical->management)
                    <h5><strong>Management:</strong></h5>
                    <p class="padded-full">
                        {{$clinical->management}}
                    </p>
                    @endif

                    @if(count($medications)>0)
                        <h5><strong>Medications:</strong></h5>
                        <ul>
                            @foreach($medications->where('clinical_id',$clinical->id) as $medication)
                            <li class="padded-full">
                                {{ $medication->drug->name }} 
                                ({{ $medication->quantity }} x {{ $medication->times_a_day }} x {{ $medication->no_of_days }})
                                <a href="{{ url('delete-medication', $medication->id) }}" class="btn pull-right icon icon-close"></a>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <ul class="list">
                    <li class="text-center">
                        <a href="{{ url('update-history', $clinical->id) }}" class="btn pull-left icon icon-edit"></a>
                        <a href="{{ url('confirm-history', $clinical->id) }}" class="btn pull-right icon icon-close"></a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    @endforeach

    @else
    <p class="padded-full text-center">
        <i>Patient has no clinical history.</i>
    </p>
    @endif
    
    <a href="{{ url('investigations', $patient->id) }}">
        <button class="btn fit-parent primary" style="margin-top: 10px;">Request Investigation</button>
    </a>

    @if($labs)


    @foreach($labs->reverse() as $lab)
    <ul class="list">
        <li>
            <i class="pull-right icon icon-expand-more"></i>
            <a href="#" class="padded-list">Lab Investigation for {{ \Carbon\Carbon::parse($lab->created_at)->toFormattedDateString() }}</a>
            <div class="accordion-content bd-clinical">
                <div class="padded-top">
                    <ul class="list">
                        @if($lab->status==0)
                        <p style="color: green;">Lab Investigation Pending...</p>
                        @endif
                    </ul>
                    @if(count($lab->radios)>0)
                    <h5 style="padding-top: 25px;"><strong>Radiology:</strong></h5>
                    @foreach($lab->radios as $radio)
                    <p class="padded-full">
                        {{$radio->name}}
                    </p>
                    @endforeach
                    @endif

                    @if($lab->investigation_request)
                    <h5 style="padding-top: 25px;"><strong>Investigation Request:</strong></h5>
                    <p class="padded-full">
                        {{$lab->investigation_request}}
                    </p>
                    @endif

                    @if($lab->specimen)
                    <h5 style="padding-top: 25px;"><strong>Specimen:</strong></h5>
                    <p class="padded-full">
                        {{$lab->specimen}}
                    </p>
                    @endif

                    @if($lab->report)
                    <h5 style="padding-top: 25px;"><strong>Report:</strong></h5>
                    <p class="padded-full">
                        {{$lab->report}}
                    </p>
                    @endif
                </div>
                <ul class="list">
                    <li class="text-center">
                        <a href="{{ route('labs.edit', $lab->id) }}" class="btn pull-left icon icon-edit"></a>
                        <a href="{{ url('confirm-lab', $lab->id) }}" class="btn pull-right icon icon-close"></a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
    @endforeach

    @else
    <p class="padded-full text-center">
        <i>Patient has no Lab history.</i>
    </p>
    @endif

    <a href="{{ url('referrals', $patient->id) }}">
        <button class="btn fit-parent primary" style="margin-top: 10px;">Create New Referral</button>
    </a>

    @if($referrals)


    @foreach($referrals->reverse() as $referral)
    <ul class="list">
        <li>
            <i class="pull-right icon icon-expand-more"></i>
            <a href="#" class="padded-list">Referral for {{ \Carbon\Carbon::parse($referral->created_at)->toFormattedDateString() }}</a>
            <div class="accordion-content bd-clinical">
                <div class="padded-top">
                    <h5 style="padding-top: 25px;"><strong>Referral:</strong></h5>
                    <p class="padded-full">
                        {{ $all_referrals[$referral->referral_id]}}
                    </p>
                </div>
            </div>
        </li>
    </ul>
    @endforeach

    @endif

    <a href="{{ url('update-patient', $patient->id) }}">
        <button class="btn fit-parent primary" style="margin-top: 10px;">Update Patient Details</button>
    </a>

    <a href="{{ url('confirm-patient', $patient->id) }}"><button style="margin-top: 10px;" class="btn fit-parent negative">Delete Medical Record</button></a>
</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection