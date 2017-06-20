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
        <li><strong>Outpatient No:</strong> {{ $patient->op_no }}</li>
        <li><strong>Age:</strong> {{ $patient->age }} years old</li>
        <li><strong>Gender:</strong> {{ $patient->gender }}</li>
        @if($patient->phone)
        <li><strong>Phone:</strong> {{ $patient->phone }}</li>
        @endif

        @if($patient->physical_address)
        <li><strong>Physical Address:</strong> {{ $patient->physical_address }}</li>
        @endif
    </ul>
    @if($clinicals)
    <ul class="list">
        <li class="divider text-center">Clinical Histories</li>
    </ul>
    @foreach($clinicals->reverse() as $clinical)
    <ul class="list">
        <li>
            <i class="pull-right icon icon-expand-more"></i>
            <a href="#" class="padded-list">Clinical History for {{ \Carbon\Carbon::parse($clinical->created_at)->diffForHumans() }}</a>
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
                </div>
            </div>
        </li>
    </ul>
    @endforeach

    @else

    <p class="padded-full text-center">
        <i>Patient has no clinical history.</i>
    </p>

    @endif
    <br><br>
</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection