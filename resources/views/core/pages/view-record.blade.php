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
        <li><strong>OP No:</strong> {{ $patient->op_no }}</li>
        <li><strong>Age:</strong> {{ $patient->age }} years old</li>
        <li><strong>Gender:</strong> {{ $patient->gender }}</li>
        <li><strong>Phone:</strong> {{ $patient->phone }}</li>
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
                        @if($clinical->complaint)
                        <h5 style="padding-top: 25px;"><strong>Complaints</strong></h5>
                        <p class="padded-full">
                            {{$clinical->complaint}}
                        </p>
                        @else   
                        <h5><strong>There were no complaints.</strong></h5>
                        @endif

                        @if($clinical->lab_test)
                        <h5><strong>Lab Test</strong></h5>
                        <p class="padded-full">
                            {{$clinical->lab_test}}
                        </p>
                        @else   
                        <h5><strong>There were no lab tests.</strong></h5>
                        @endif

                        @if($clinical->treatment)
                        <h5><strong>Treatment</strong></h5>
                        <p class="padded-full">
                            {{$clinical->treatment}}
                        </p>
                        @else   
                        <h5><strong>There were no lab tests.</strong></h5>
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