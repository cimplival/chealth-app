@extends('layouts.app')

@section('partials')

    @if (Session::get('message'))
        @include('core.partials.info')
    @endif

    @if (Session::get('success'))
        @include('core.partials.success')
    @endif

    @if (Session::get('error'))
        @include('core.partials.error')
    @endif

    @if (Session::get('errors'))
        @include('core.partials.errors')
    @endif

@endsection

@section('body')
    <form method="POST" action="{{ url('/') }}">
    {{ csrf_field() }}
        <div class="padded-full">
            <input type="text" name="search" placeholder="Search patient here...(out of {{ $no_of_patients }} patients)" autofocus>
        </div>
        <div class="padded-full">
            <button type="submit" class="btn fit-parent primary">Search</button>
        </div>
    </form>
    
    <div class="padded-full">
        <ul class="list">
            @if($patients)
                @foreach($patients as $patient)
                <li>
                    <a class="padded-list" href="{{ url('view', $patient->id)}}">{{$patient->name}}</a>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection

@section('partials-script')
    @if(Session::get('errors') || Session::get('error') || Session::get('info') || Session::get('success'))
        @include('core.partials.notify-script')
    @endif
@endsection