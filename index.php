<?php

// Require Composer's autoloader.
require __DIR__ . "/vendor/autoload.php";

use App\Classes\TemplateRender;
use App\Services\QuotesService;

// load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiEndpoint = getenv('QUOTES_API_ENDPOINT');
$quotesService = new QuotesService(getenv('QUOTES_CACHE_EXPIRE_MINUTES'), getenv('QUOTES_MAX_ALLOWED'));
$quotesService->setQuotesSource(getenv('QUOTES_SOURCE_FILE'));
$authors = $quotesService->getAuthorsForList();

$header = new TemplateRender('header');
$header->setVars(array('apiEndpoint' => $apiEndpoint));
print $header->output();

$main = new TemplateRender('main');
$main->setVars(array('authors' => $authors));
print $main->output();

$footer = new TemplateRender('footer');
print $footer->output();