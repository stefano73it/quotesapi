<?php

use App\Services\QuotesService;

// Require Composer's autoloader.
require __DIR__ . "/vendor/autoload.php";

// load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// init quotes service
$quotesService = new QuotesService(getenv('QUOTES_CACHE_EXPIRE_MINUTES'), getenv('QUOTES_MAX_ALLOWED'));
$quotesService->setQuotesSource(getenv('QUOTES_SOURCE_FILE'));

if (empty($_REQUEST)) {
    // CLI
    if ($argc != 3) die('Use this command: php shout.php <author> <limit>'."\n");
    $res = $quotesService->getShoutedQuotes($argv[1], $argv[2]);
    if (isset($res['error'])) {
        print $res['error'];
    }
    else {
        foreach ($res['quotes'] as $quote) {
            print $quote."\n\n";
        }
    }
}
else {
    // API
    print json_encode($quotesService->getShoutedQuotes($_REQUEST['author'], $_REQUEST['limit']));
}