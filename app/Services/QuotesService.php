<?php

namespace App\Services;

use App\Classes\QuotesFileCache;
use App\Entities\Quote;

class QuotesService {
    protected $source;
    protected $cache;
    protected $expireMinutes;
    protected $quoteLimit;

	public function __construct($expireMinutes, $quoteLimit) {
	    $this->expireMinutes = $expireMinutes;
	    $this->quoteLimit = $quoteLimit;

	    $this->setCache();
	}

	protected function setCache() {
	    $this->cache = new QuotesFileCache($this->expireMinutes);
	}

	public function setQuotesSource($file) {
	    $this->source = $file;
	}

	public function getQuotes($author, $num) {
	    $quotes = $this->loadQuotes($author);

	    // randomize author's quotes and select requested count
	    shuffle($quotes);
	    return array_slice($quotes, 0, $num);
	}

	protected function loadQuotes($author) {
	    // load author's quotes from cache
	    $quotes = $this->cache->getAuthorQuotes($author);

	    // if quotes are empty, load quotes from source and update cache
	    if (is_null($quotes)) {
	        $quotes = $this->getAuthorQuotesFromSource($author);
	        $this->cache->setAuthorQuotes($author, $quotes);
	    }

	    $result = array();
	    foreach ($quotes as $quote) {
	        $result[] = new Quote($quote['quote'], $quote['author']);
	    }
	    return $result;
	}

	protected function getQuotesFromSource() {
	    $data = file_get_contents($this->source);
	    return json_decode($data, TRUE);
	}

	protected function getAuthorQuotesFromSource($author) {
	    $data = $this->getQuotesFromSource();

	    $result = array();
	    foreach ($data['quotes'] as $quote) {
	        if (mb_strtolower(trim($quote['author'])) == mb_strtolower(trim($author))) $result[] = $quote;
	    }
	    return $result;
	}
	
	protected function shoutQuote($quote) {
	    return $quote->shout();
	}

	public function getAuthorsForList() {
	    $data = $this->getQuotesFromSource();

	    $authors = array();
	    foreach ($data['quotes'] as $quote) {
	        $key = mb_strtolower($quote['author']);
	        if (!array_key_exists($key, $authors)) $authors[$key] = $quote['author'];
	    }
	    ksort($authors);
	    return $authors;
	}

	public function getShoutedQuotes($author, $num) {
	    if ($num > $this->quoteLimit) return array('error' => 'You cannot request more than ' .$this->quoteLimit. ' quotes!');

	    $quotes = $this->getQuotes($author, $num);

	    $result = array();
	    foreach ($quotes as $quote) {
	        $result[] = $quote->shout();
	    }
	    return array('quotes' => $result);
	}
}