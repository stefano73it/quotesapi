<?php

namespace App\Interfaces;

Interface QuotesCache {
    function setCache($cache);
    function setExpireMinutes($minutes);
    function getAuthorQuotes($author);
    function setAuthorQuotes($author, $quotes);
    function addAuthorQuote($author, $quote);
}