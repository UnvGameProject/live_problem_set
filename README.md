# Fullbay Live Problem Set

A Dockerized Laravel and React interview demo workspace prepared for a technical interview with Fullbay.

The goal of this project is to provide a clean, reproducible environment for demonstrating:

* AI-assisted technical problem solving
* Laravel routing and controller structure
* A visually clear browser-based demo workspace
* React-driven interactive UI
* SCSS-based styling with separation of concerns
* PHPUnit backend tests
* Vitest and React Testing Library frontend tests
* Vite HMR during local development

This repository is intentionally small and self-contained. It does not contain private client code, proprietary business logic, or production application secrets.

## Project Purpose

The demo is built around a service-order-style problem space.

The landing page introduces the workspace and links to a dedicated demo route. The demo route is controlled by a Laravel controller and renders a Blade view that mounts a React demo island.

The intended next feature is a Service Order Triage Dashboard that can normalize messy service order data, validate records, flag invalid inputs, and summarize operational metrics.

## Stack

| Layer                   | Technology                    |
| ----------------------- | ----------------------------- |
| Language                | PHP 8.3                       |
| Backend Framework       | Laravel 12                    |
| Frontend                | React                         |
| Asset Pipeline          | Vite                          |
| Styling                 | SCSS                          |
| Database                | PostgreSQL 15                 |
| Cache                   | Redis                         |
| Web Server              | Nginx                         |
| Backend Tests           | PHPUnit                       |
| Frontend Tests          | Vitest, React Testing Library |
| Local Runtime           | Docker Compose                |
| Development Environment | WSL2-friendly Docker setup    |

## Local Domain

The local app is configured to run at:

```text
http://fullbaydemo.localhost
```

Vite runs on:

```text
http://fullbaydemo.localhost:5173
```

## Prerequisites

Install or configure the following before running the project:

* Docker Desktop
* WSL2
* Git
* SSH access to GitHub if cloning over SSH
* A local hosts entry for `fullbaydemo.localhost`

## Hosts File Setup

Inside WSL2, add:

```text
127.0.0.1 fullbaydemo.localhost
```

Command:

```bash
grep -q "fullbaydemo.localhost" /etc/hosts || echo "127.0.0.1 fullbaydemo.localhost" | sudo tee -a /etc/hosts
```

If using a Windows browser, also add the same line to the Windows hosts file:

```text
C:\Windows\System32\drivers\etc\hosts
```

Line to add:

```text
127.0.0.1 fullbaydemo.localhost
```

## Getting Started

Clone the repository:

```bash
git clone git@github.com:UnvGameProject/live_problem_set.git
cd live_problem_set
```

Copy the environment file:

```bash
cp .env.example .env
```

For this demo, the local environment should use:

```env
APP_NAME=FullbayInterviewDemo
APP_ENV=local
APP_DEBUG=true
APP_URL=http://fullbaydemo.localhost

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=fullbaydemo
DB_USERNAME=fullbaydemo
DB_PASSWORD=secret

SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file

REDIS_HOST=redis
```

The project also supports WSL2 UID/GID mapping:

```env
HOST_UID=1000
HOST_GID=1000
```

Use your actual WSL2 values if different:

```bash
id -u
id -g
```

## Build and Start Containers

Build the app and Vite images:

```bash
docker compose build --no-cache
```

Start the stack:

```bash
docker compose up -d
```

Verify containers:

```bash
docker compose ps
```

Expected containers:

```text
fullbaydemo-app
fullbaydemo-web
fullbaydemo-postgres
fullbaydemo-redis
fullbaydemo-vite
```

## Prepare Laravel

Install PHP dependencies if needed:

```bash
docker exec -it fullbaydemo-app composer install
```

Generate the application key:

```bash
docker exec -it fullbaydemo-app php artisan key:generate
```

Run migrations:

```bash
docker exec -it fullbaydemo-app php artisan migrate
```

## Development Commands

Start the stack:

```bash
docker compose up -d
```

Stop the stack:

```bash
docker compose down
```

View app logs:

```bash
docker compose logs --tail=120 app
```

View webserver logs:

```bash
docker compose logs --tail=120 webserver
```

View Vite logs:

```bash
docker compose logs --tail=120 vite
```

Run Artisan commands:

```bash
docker exec -it fullbaydemo-app php artisan <command>
```

Run Composer commands:

```bash
docker exec -it fullbaydemo-app composer <command>
```

Run npm commands:

```bash
docker exec -it fullbaydemo-vite npm <command>
```

## Testing

Run backend tests:

```bash
docker exec -it fullbaydemo-app php artisan test
```

Run frontend tests:

```bash
docker exec -it fullbaydemo-vite npm run test
```

Run frontend production build:

```bash
docker exec -it fullbaydemo-vite npm run build
```

Run npm audit:

```bash
docker exec -it fullbaydemo-vite npm audit
```

## Vite and HMR

The Vite container runs:

```bash
npm install && npm run dev -- --host 0.0.0.0
```

This provides local HMR for JavaScript, React, Blade refreshes, and SCSS changes.

To test React HMR, edit:

```text
resources/js/interview-demo/ServiceOrderDemo.jsx
```

To test SCSS HMR, edit:

```text
resources/scss/interview-demo/_demo.scss
```

The browser should update without manually restarting the containers.

## Project Structure

Important application files:

```text
app/Http/Controllers/InterviewDemo/
resources/views/layouts/
resources/views/welcome.blade.php
resources/views/interview-demo/
resources/js/interview-demo/
resources/js/test/
resources/scss/interview-demo/
tests/Feature/InterviewDemoRoutesTest.php
```

The intended separation of concerns is:

```text
Laravel routes: route ownership and URL structure
Laravel controllers: page-level request handling
Blade views: server-rendered page shell and React mount points
React components: interactive demo workspace
SCSS files: all styling
PHPUnit tests: backend and route confidence
Vitest tests: React component confidence
```

## Current Demo Flow

The current browser flow is:

```text
Landing page
    ↓
Open demo workspace
    ↓
Service Order Triage Dashboard route
    ↓
React demo island
```

The landing page is intentionally separate from the demo workspace so the interview can show clean Laravel routing, a controller-backed page, and a focused React workspace.

## Security Notes

Axios was intentionally removed from this demo. The project uses browser-native `fetch()` for any future small API calls.

This keeps the frontend dependency surface smaller and avoids unnecessary supply-chain risk for an interview environment.

Run this before important demo sessions:

```bash
docker exec -it fullbaydemo-vite npm audit
```

## Conventional Commits

Use Conventional Commits for changes going forward.

Common examples:

```text
feat(interview-demo): add service order normalization workflow
feat(ui): add landing page and demo workspace styling
fix(docker): prevent entrypoint ownership repair as non-root user
test(interview-demo): add route and React component coverage
docs(readme): document setup and demo workflow
refactor(service-orders): separate normalization from aggregation
chore(deps): update frontend test dependencies
```

Suggested commit types:

| Type     | Use For                                               |
| -------- | ----------------------------------------------------- |
| feat     | New user-facing or developer-facing functionality     |
| fix      | Bug fixes                                             |
| test     | Adding or correcting tests                            |
| docs     | Documentation-only changes                            |
| refactor | Code changes that do not alter behavior               |
| chore    | Maintenance tasks, dependency updates, config cleanup |
| style    | Formatting-only changes                               |
| build    | Build system or dependency changes                    |
| ci       | CI-related changes                                    |

## Interview Usage Notes

This project is intended to support a technical conversation, not replace problem solving.

A good interview flow is:

1. Restate the problem.
2. Clarify assumptions.
3. Use AI to generate or compare a first-pass approach.
4. Review the output critically.
5. Adjust code for correctness, readability, and maintainability.
6. Run tests.
7. Show the result in the browser.

The key message is:

```text
AI accelerates the workflow, but the engineer owns the reasoning, review, edge cases, and verification.
```

## License

This project is prepared as a public interview demo repository.

The Laravel framework is open-sourced software licensed under the MIT license.
