#!/bin/bash

echo "🚀 Running deploy script"

echo "[1/5] 📥 Pulling latest code from GitHub"
git pull origin main

echo "[2/5] 🗃️ Creating database if one isn't found"
touch database/database.sqlite

echo "[3/5] 📦 Installing packages using composer"
composer install

echo "[4/5] ⚙️ Publishing API Platform assets"
php artisan api-platform:install

echo "[5/5] 🛠️ Migrating database"
php artisan migrate --force

echo "✅ The app has been built successfully!"
