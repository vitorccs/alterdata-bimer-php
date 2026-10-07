<?php
declare(strict_types=1);

namespace Bimer\Test\Integration;

use Bimer\Http\Bimer;
use PHPUnit\Framework\TestCase;

/**
 * Base class for tests that perform real requests to the Bimer API.
 * They are skipped while BIMER_API_URL does not contain a valid URL.
 */
abstract class IntegrationTestCase extends TestCase
{
    /** @var class-string<\Bimer\Http\Resource> */
    protected string $resource;

    protected function setUp(): void
    {
        if (!$this->isApiConfigured()) {
            $this->markTestSkipped('Bimer API not configured: set BIMER_API_URL and credentials in phpunit.xml');
        }
    }

    private function isApiConfigured(): bool
    {
        $url = getenv(Bimer::BIMER_API_URL) ?: '';

        return filter_var($url, FILTER_VALIDATE_URL) !== false
            && preg_match('#^https?://#i', $url) === 1;
    }
}
