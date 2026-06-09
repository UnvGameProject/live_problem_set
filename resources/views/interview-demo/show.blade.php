@extends('layouts.app')

@section('title', 'Service Order Demo')
@section('body_class', 'app-shell demo-page')

@push('vite')
    @vite('resources/js/interview-demo/index.jsx')
@endpush

@section('content')
    <section class="demo-header">
        <a class="back-link" href="{{ route('landing') }}">
            Back to landing
        </a>

        <p class="eyebrow">Interactive workspace</p>

        <h1>Service Order Triage Dashboard</h1>

        <p class="demo-intro">
            This page is intentionally separated from the landing page. Laravel controls
            the route and view, while React controls the interactive demo island below.
        </p>
    </section>

    <section class="demo-workspace" aria-label="Service order demo workspace">
        <div id="service-order-demo-root"></div>
    </section>
@endsection
