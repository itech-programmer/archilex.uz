# Dictionary App — Laravel API + Android

Клиент-серверное приложение словаря: Laravel REST API и Android приложение (Jetpack Compose, Kotlin).

## Структура проекта

```
Dictionary/
├── api/              # Laravel REST API (Docker: PHP-FPM, Nginx, PostgreSQL, Redis)
├── android/          # Android приложение (Kotlin, Compose)
└── Makefile          # Команды для Docker
```

## Быстрый старт (Docker)

### 1. Запуск backend

```bash
# Первый раз — инициализация (требует Git Bash, WSL или Linux/Mac)
make init

# Запуск контейнеров
make up
```

**Windows (PowerShell):** если `make` недоступен:
```powershell
cd api
copy .env.docker.example .env
docker compose build
docker compose run --rm app composer install
docker compose run --rm app php artisan key:generate
docker compose run --rm app php artisan migrate --force
docker compose run --rm app php artisan db:seed --force
docker compose up -d
```

**Сервисы:**
- API: http://localhost:8000
- PostgreSQL: localhost:5432
- Redis: localhost:6379
- Queue worker: фоновый контейнер `dictionary-queue`

### 2. Команды Makefile

| Команда | Описание |
|---------|----------|
| `make build` | Сборка образов |
| `make up` | Запуск контейнеров |
| `make down` | Остановка |
| `make init` | Первый запуск (composer, migrate, seed) |
| `make migrate` | Миграции |
| `make seed` | Сидеры |
| `make migrate-fresh` | Полный сброс БД + seed |
| `make shell` | Shell в контейнер app |
| `make logs` | Логи |
| `make test` | Тесты |

### 3. Без Docker (локально)

```bash
cd api
# PostgreSQL + Redis должны быть запущены
cp .env.example .env
# Отредактировать .env: DB_*, REDIS_*, QUEUE_CONNECTION=redis, CACHE_STORE=redis
php artisan migrate
php artisan db:seed
php artisan serve
# В отдельном терминале: php artisan queue:work redis
```

**Эндпоинт:** `GET /api/v2/entries/en/{word}`

Примеры слов в сидере: `architecture`, `beam`, `foundation`, `hello`.

### 2. Android

Откройте проект в Android Studio и запустите на эмуляторе или устройстве.

**Настройка BASE_URL** в `Constants.kt`:
- **Эмулятор:** `http://10.0.2.2:8000` (уже настроено)
- **Реальное устройство:** `http://ВАШ_IP:8000` (узнать IP: `ipconfig` в Windows)

### 3. Добавление своих словарей

Словарь можно заполнять через:
- `php artisan tinker` и создание Word/Meaning/Definition
- Импорт из PDF (скрипт или вручную)
- API для администрирования (можно добавить)

## API Response Format

Совместим с форматом [api.dictionaryapi.dev](https://dictionaryapi.dev/):

```json
[
  {
    "word": "architecture",
    "phonetic": "/ˈɑːkɪtɛktʃə/",
    "sourceUrls": [],
    "meanings": [
      {
        "partOfSpeech": "noun",
        "definitions": [
          {
            "definition": "The art or practice of designing...",
            "example": "The architecture of the cathedral is stunning."
          }
        ],
        "synonyms": ["design", "structure", "construction"]
      }
    ]
  }
]
```

## Стек (Docker)

- **PHP 8.2-FPM** — приложение
- **Nginx** — веб-сервер
- **PostgreSQL 16** — БД
- **Redis 7** — кеш, сессии, очереди
- **Queue worker** — обработка jobs через Redis
