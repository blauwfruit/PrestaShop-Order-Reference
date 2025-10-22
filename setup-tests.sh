#!/bin/bash
# Setup script to install Composer and PHPUnit dependencies

set -e

echo "=== Setting up test environment ==="

echo "1. Installing Composer in container..."
docker compose exec apache bash -c "curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer"

echo "2. Verifying Composer installation..."
docker compose exec apache composer --version

echo "3. Installing Composer dependencies..."
docker compose exec apache bash -c "cd modules/orderreference && composer install --no-interaction --prefer-dist"

echo ""
echo "✓ Setup complete! You can now run tests:"
echo ""
echo "  # Run all tests:"
echo "  docker compose exec apache bash -c \"cd modules/orderreference && ./vendor/bin/phpunit\""
echo ""
echo "  # Run specific test:"
echo "  docker compose exec apache bash -c \"cd modules/orderreference && ./vendor/bin/phpunit --filter testDefaultOrderReference\""
echo ""

