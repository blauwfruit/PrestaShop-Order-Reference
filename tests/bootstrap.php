<?php
/**
 * PHPUnit Bootstrap file
 */

// Load PrestaShop configuration
if (file_exists('/var/www/html/config/config.inc.php')) {
    require_once '/var/www/html/config/config.inc.php';
} else {
    throw new Exception('PrestaShop config.inc.php not found. Please ensure PrestaShop is installed.');
}

// Initialize minimal context for CLI testing
if (!Context::getContext()->shop) {
    Context::getContext()->shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
}
if (!Context::getContext()->currency) {
    Context::getContext()->currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
}
if (!Context::getContext()->language) {
    Context::getContext()->language = new Language(Configuration::get('PS_LANG_DEFAULT'));
}

// Load composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

