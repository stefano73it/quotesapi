<?php

namespace App\Classes;

use App\Interfaces\QuotesCache;
use Wruczek\PhpFileCache\PhpFileCache;

class QuotesFileCache implements QuotesCache {
    protected $cache;
    protected $expireMinutes;

    public function __construct($expireMinutes) {
        $cache = new PhpFileCache(__DIR__ . '/../../storage/cache/');
        $this->setCache($cache);

        $this->setExpireMinutes($expireMinutes);
    }

    public function setCache($cache) {
        $this->cache = $cache;
    }

    public function setExpireMinutes($expireMinutes) {
        $this->expireMinutes = $expireMinutes;
    }

    protected function getCacheKey($author) {
        return mb_strtolower(trim($author));
    }

    public function getAuthorQuotes($author) {
        $key = $this->getCacheKey($author);
        if (!$this->cache->isExpired($key)) return $this->cache->retrieve($key);
    }

    public function setAuthorQuotes($author, $quotes) {
        $key = $this->getCacheKey($author);
        $this->cache->store($key, $quotes, $this->expireMinutes * 60);
    }

    public function addAuthorQuote($author, $quote) {
        $quotes = $this->getAuthorQuotes($author);

        if (!in_array($quote, $quotes)) {
            $quotes[] = $quote;
            $this->setAuthorQuotes($author, $quotes);
        }
    }
}