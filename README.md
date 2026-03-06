# Project Name

> Replace this line with a short description of your project.

A Laravel + Livewire application with a Dockerized development environment featuring PHP 8.3, PostgreSQL, Redis, Nginx, and Vite with Hot Module Replacement (HMR).

---

## Stack

| Layer         | Technology      |
| ------------- | --------------- |
| Language      | PHP 8.3 (FPM)   |
| Framework     | Laravel         |
| Frontend      | Livewire + Vite |
| Database      | PostgreSQL 15   |
| Cache / Queue | Redis           |
| Web Server    | Nginx           |
| Dev Server    | Vite with HMR   |

---

## Getting Started

### 1. Clone the repo

```bash
git clone git@github.com:YOURUSERNAME/your-new-repo.git
cd your-new-repo
```

---

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

---

### 3. Update your hosts file

**WSL2 / Linux / Mac** — add to `/etc/hosts`:

```bash
sudo nano /etc/hosts
```

```
127.0.0.1   yourapp.localhost
```

**Windows** — if accessing from a Windows browser while running in WSL2, also add to:

`C:\Windows\System32\drivers\etc\hosts`

```
127.0.0.1   yourapp.localhost
```

---

### 4. Replace the template placeholder

This template uses the placeholder:

```
project_name
```

Replace it with your project name.

Example:

```
project_name → yourapp
```

Files that contain the placeholder:

| File                        | What to update                                   |
| --------------------------- | ------------------------------------------------ |
| `docker-compose.yml`        | container names, DB names, network name, APP_URL |
| `docker/nginx/default.conf` | `server_name` and PHP upstream                   |
| `vite.config.js`            | `hmr.host`                                       |

Helpful command to locate any remaining placeholders:

```bash
grep -r "project_name" --include="*.yml" --include="*.conf" --include="*.js" --include="*.env*" .
```

---

### 5. Build and start containers

```bash
docker compose build --no-cache
docker compose up -d
```

---

### 6. Generate application key

```bash
docker exec -it project_name-app php artisan key:generate
```

---

### 7. Run migrations

```bash
docker exec -it project_name-app php artisan migrate
```

Optionally seed the database:

```bash
docker exec -it project_name-app php artisan db:seed
```

---

### 8. Verify everything is running

```bash
docker ps
```

You should see five containers running:

```
project_name-app
project_name-web
project_name-postgres
project_name-redis
project_name-vite
```

Visit your application:

```
http://yourapp.localhost
```

Vite HMR runs on:

```
http://yourapp.localhost:5173
```

---

## Daily Development

| Task                | Command                                                  |
| ------------------- | -------------------------------------------------------- |
| Start stack         | `docker compose up -d`                                   |
| Stop stack          | `docker compose down`                                    |
| Restart Vite        | `docker compose restart vite`                            |
| Tail Vite logs      | `docker logs project_name-vite --follow`                 |
| Tail Laravel logs   | `docker logs project_name-app --follow`                  |
| Run Artisan         | `docker exec -it project_name-app php artisan <command>` |
| Run Composer        | `docker exec -it project_name-app composer <command>`    |
| Rebuild a container | `docker compose up -d --build vite`                      |

---

## HMR Troubleshooting

If Hot Module Replacement stops working (common on **WSL2** due to filesystem watch limitations), ensure polling is enabled in `vite.config.js`:

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
├── docker-compose.override.yml     # Local overrides (optional)
├── docker-entrypoint.sh            # Laravel container startup logic
├── Dockerfile                      # Multi-stage build (Node + PHP)
├── vite.config.js                  # Vite + Laravel + Livewire config
└── ...                             # Standard Laravel project structure
```

---

## New Project Checklist

* [ ] Update `APP_NAME` and `APP_URL` in `.env`
* [ ] Replace all `project_name` placeholders in the repository
* [ ] Update `server_name` in `docker/nginx/default.conf`
* [ ] Update `hmr.host` in `vite.config.js`
* [ ] Add your local domain to `/etc/hosts`
* [ ] Run `docker compose build --no-cache && docker compose up -d`
* [ ] Run `docker exec -it project_name-app php artisan key:generate`
* [ ] Run `docker exec -it project_name-app php artisan migrate`

---

## License

Repo - MIT

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
