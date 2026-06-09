@extends('layouts.app')

@section('title', 'Fullbay Interview Demo')
@section('body_class', 'app-shell landing-page')

@section('content')
    <section class="landing-hero">
        <div class="landing-hero__content">
            <p class="eyebrow">Fullbay technical interview 1</p>

            <h1>Service Order Triage Demo</h1>

            <p class="hero-copy">
                A focused Laravel workspace for walking through technical problems,
                validating assumptions, writing clean code, and verifying behavior with tests.
            </p>

            <div class="hero-actions">
                <a class="primary-action" href="{{ route('interview-demo.show') }}">
                    Open React demo
                </a>

                <a class="secondary-action" href="{{ route('php-workspace.show') }}">
                    Open PHP workbench
                </a>
            </div>
        </div>

        <aside class="landing-card" aria-label="Demo goals">
            <h2>Workspace focus</h2>

            <ul>
                <li>Laravel-controlled routing and page structure</li>
                <li>React island for frontend-focused work</li>
                <li>PHP-only workspace for backend-focused work</li>
                <li>SCSS-only styling</li>
                <li>PHPUnit and Vitest coverage</li>
                <li>Vite HMR for fast feedback during development</li>
            </ul>
        </aside>
    </section>
@endsection
