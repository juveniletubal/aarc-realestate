<?php
// Always use absolute paths so includes work from anywhere
require_once __DIR__ . '/../classes/AssetManager.php';
require_once __DIR__ . '/../classes/PageManager.php';
require_once __DIR__ . '/../config/config.php';

// Initialize core objects
$assets = new AssetManager();
$page   = new PageManager();
