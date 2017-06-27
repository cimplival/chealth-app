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

    <a href="{{ url('referral/ ' . $patient->id . '/' . 0) }}">
        <button class="btn fit-parent" style="margin-top: 10px;">From Other Health Facilities</button>
    </a>

    <a href="{{ url('referral/ ' . $patient->id . '/' . 1) }}">
        <button class="btn fit-parent" style="margin-top: 10px;">To Other Health Facilities</button>
    </a>

    <a href="{{ url('referral/ ' . $patient->id . '/' . 2) }}">
        <button class="btn fit-parent" style="margin-top: 10px;">From Community Unit</button>
    </a>

    <a href="{{ url('referral/ ' . $patient->id . '/' . 3) }}">
        <button class="btn fit-parent" style="margin:10px 0px 10px 0px;">To Community Unit</button>
    </a>

    <a href="{{ url('consult/', $patient->id) }}" style="margin-top: 10px;">
        <button class="btn fit-parent primary">No, Go Back</button>
    </a>
    
</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection