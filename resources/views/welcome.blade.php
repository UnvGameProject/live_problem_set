@extends('layouts.app')

@section('title', 'Fullbay Interview Demo')
@section('body_class', 'app-shell landing-page')

@section('content')
    <section class="landing-hero">
        <div class="landing-hero__content">
            <p class="eyebrow">Fullbay technical interview preparation</p>

            <h1>Service Order Triage Demo</h1>

            <p class="hero-copy">
                A small Laravel and React workspace for walking through AI-assisted
                problem solving, clean business logic, visible UI changes, and testable code.
            </p>

            <div class="hero-actions">
                <a class="primary-action" href="{{ route('interview-demo.show') }}">
                    Open demo workspace
                </a>
            </div>
        </div>

        <aside class="landing-card" aria-label="Demo goals">
            <h2>Demo focus</h2>

            <ul>
                <li>Laravel-controlled routing and page structure</li>
                <li>React-controlled interactive workspace</li>
                <li>SCSS-only styling</li>
                <li>PHPUnit and Vitest coverage</li>
                <li>Vite HMR for fast visual feedback</li>
            </ul>
        </aside>
    </section>
@endsection
