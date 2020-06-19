<?php

namespace App\Entities;

class Quote {
    private $quote;
    private $author;

	public function __construct($quote, $author) {
	    $this->quote = $quote;
	    $this->author = $author;
	}

	public function getQuote() {
	    return $this->quote;
	}

	public function shout() {
	    return mb_strtoupper(trim($this->quote, '.!')) . '!';
	}

	public function getAuthor() {
	    return $this->author;
	}	
}