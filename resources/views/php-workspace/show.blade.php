@extends('layouts.livewire-app')

@section('title', 'PHP Workbench')
@section('body_class', 'app-shell php-page')

@section('content')
    <section class="demo-header">
        <a class="back-link" href="{{ route('landing') }}">
            Back to landing
        </a>

        <p class="eyebrow">PHP-only workspace</p>

        <h1>PHP Data Workbench</h1>

        <p class="demo-intro">
            This workspace is intentionally PHP-driven. Laravel controls the route and view,
            while Livewire provides server-side interactivity without a full page refresh.
        </p>
    </section>

    <section class="php-workspace-shell" aria-label="PHP-only workbench">
        <livewire:interview-demo.php-workspace />
    </section>
@endsection
