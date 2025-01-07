@extends('layout')
@section('title')
    Jobs list
@endsection
@section('content')
    @forelse ($jobs as $job)
        <li>
            <a href="{{ route('jobs.show', $loop->iteration) }}">{{ $loop->iteration }} - {{ $job }}</a>
        </li>
    @empty
        <li>No jobs...</li>
    @endforelse
@endsection
