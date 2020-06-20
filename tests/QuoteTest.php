<?php

use PHPUnit\Framework\TestCase;
use App\Services\QuotesService;

final class QuoteTest extends TestCase
{
    protected $expireMinutes = 1;
    protected $quoteLimit = 5;
    protected $author = 'Mark Twain';

    protected function getQuotes($num) {
        $quoteService = new QuotesService($this->expireMinutes, $this->quoteLimit);
        $quoteService->setQuotesSource('./resources/quotes/quotes.json');
        return $quoteService->getShoutedQuotes($this->author, $num);
    }

    public function testReturnLimitedNumberOfQuotes(): void
    {
        $quotes = $this->getQuotes($this->quoteLimit);
        $this->assertArrayHasKey('quotes', $quotes, 'Result has no quotes!');

        $quotes = $this->getQuotes($this->quoteLimit * 2);
        $this->assertArrayHasKey('error', $quotes, 'Result should return error!');
    }

    public function testCountShoutedQuotes(): void
    {
        $quotes = $this->getQuotes(1);
        $this->assertNotEmpty($quotes['quotes'], 'Result has no quotes!');
        $this->assertCount(1, $quotes['quotes'], 'Quotes count is wrong!');

        $quotes = $this->getQuotes(2);
        $this->assertLessThanOrEqual(2, count($quotes));
    }

    public function testAreQuotesShouted(): void
    {
        $quotes = $this->getQuotes(2);
        $this->assertNotEmpty($quotes['quotes'], 'Result has no quotes!');

        foreach ($quotes['quotes'] as $quote) {
            $this->assertNotRegExp('/[a-z]/', $quote, 'Shouted quote contains lowercase characters!');
            $this->assertStringEndsWith('!', $quote, 'Quote does not end with exclamation mark!');
        }
    }
}