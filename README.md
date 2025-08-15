# howToMongoDB

A tiny OOP PHP project that shows basic CRUD and Mongo-specific features (UPSERT with upsert: true, regex search, GridFS file storage, array membership, aggregation “latest per group”) using Docker + Composer.

---

## 1) Requirements

1. Docker
2. Docker Compose
3. (Windows) WSL2 enabled

## 2) Installation / Run

1. Start MongoDB
```
docker compose up -d mongo
```

2. Build the PHP container
```
docker compose build php
```

3. Install PHP deps (for GridFS Bucket)
```
docker compose run --rm php composer install
```

4. Run the demo script (then remove the container)
```
docker compose run --rm php php bin/run.php
```

---

## 3) MongoDB reminder (what this project shows)

- **UPSERT** : Insert or update in one shot.
- **Regex search (case-insensitive)** — LIKE, but with regex.
- **GridFS (file storage in DB)** — Store files directly in MongoDB.
- **Arrays membership** — Is a value in an array field?
- **Aggregation “latest per group”** — Mongo’s DISTINCT-ON-like pattern..