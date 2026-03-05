# Project Name

> Replace this line with a short description of your project.

A Laravel + Livewire application with a Dockerized development environment featuring PHP 8.3, PostgreSQL, Redis, and Vite HMR.

---

## Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3 (FPM) |
| Framework | Laravel 11 |
| Frontend | Livewire + Vite |
| Database | PostgreSQL 15 |
| Cache / Queue | Redis |
| Web Server | Nginx |
| Dev Server | Vite with HMR |

---

## Getting Started

### 1. Clone the repo

```bash
git clone git@github.com:YOURUSERNAME/your-new-repo.git
cd your-new-repo
```

### 2. Set up your environment file

```bash
cp .env.example .env
```

Open `.env` and update the following at minimum:

```env
APP_NAME=YourAppName
APP_URL=http://yourapp.localhost

DB_HOST=db
DB_DATABASE=yourapp
DB_USERNAME=yourapp
DB_PASSWORD=secret

REDIS_HOST=redis
```

### 3. Update your hosts file

**WSL2 / Linux / Mac** — add to `/etc/hosts`:

```bash
sudo nano /etc/hosts
```

```
127.0.0.1   yourapp.localhost
```

**Windows** — if accessing from a Windows browser while running in WSL2, also add to `C:\Windows\System32\drivers\etc\hosts`:

```
127.0.0.1   yourapp.localhost
```

### 4. Find and replace the skeleton name

Replace all references to the skeleton app name across the following files:

| File | What to change |
|---|---|
| `docker-compose.yml` | `container_name`, network name, `DB_DATABASE`, `DB_USERNAME`, `APP_URL` |
| `docker/nginx/default.conf` | `server_name` |
| `vite.config.js` | `hmr.host` |

Quick find to catch anything missed:

```bash
grep -r "nlffitness" --include="*.yml" --include="*.conf" --include="*.js" --include="*.env*" .
```

### 5. Build and start containers

```bash
docker compose build --no-cache
docker compose up -d
```

### 6. Generate application key

```bash
docker exec -it your-app-app php artisan key:generate
```

### 7. Run migrations

```bash
docker exec -it your-app-app php artisan migrate
```

Optionally seed the database:

```bash
docker exec -it your-app-app php artisan db:seed
```

### 8. Verify everything is running

```bash
docker ps
```

You should see five containers running: `app`, `webserver`, `db`, `redis`, `vite`.

Visit `http://yourapp.localhost` in your browser. Vite HMR is served on port `5173` directly.

---

## Daily Development

| Task | Command |
|---|---|
| Start | `docker compose up -d` |
| Stop | `docker compose down` |
| Tail Vite logs | `docker logs your-app-vite --follow` |
| Tail app logs | `docker logs your-app-app --follow` |
| Artisan | `docker exec -it your-app-app php artisan <command>` |
| Composer | `docker exec -it your-app-app composer <command>` |
| Rebuild single container | `docker compose up -d --build vite` |

---

## HMR Troubleshooting

If hot module replacement stops working (common on WSL2 due to inotify / Windows filesystem interaction), add polling to `vite.config.js`:

```js
server: {
    host: '0.0.0.0',
    port: 5173,
    hmr: {
        host: 'yourapp.localhost',
        protocol: 'ws'
    },
    watch: {
        usePolling: true,
        interval: 1000
    }
}
```

Then restart the Vite container:

```bash
docker compose restart vite
```

---

## Folder Structure

```
.
├── docker/
│   └── nginx/
│       └── default.conf            # Nginx server config
├── docker-compose.yml              # Container orchestration
├── docker-compose.override.yml     # Local volume overrides
├── docker-entrypoint.sh            # Container startup logic
├── Dockerfile                      # Multi-stage build (Node + PHP)
├── vite.config.js                  # Vite + Laravel + Livewire config
└── ...                             # Standard Laravel project structure
```

---

## New Project Checklist

- [ ] Update `APP_NAME` and `APP_URL` in `.env`
- [ ] Replace all `nlffitness` references in `docker-compose.yml`
- [ ] Update `server_name` in `docker/nginx/default.conf`
- [ ] Update `hmr.host` in `vite.config.js`
- [ ] Add your local domain to `/etc/hosts`
- [ ] Run `docker compose build --no-cache && docker compose up -d`
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate`

---

## License
Repo - MIT
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).\
