<?php

namespace Developmint\NpmStats\Test;

use Developmint\NpmStats\NpmStats;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class NpmStatsTest extends TestCase
{
    /** @var \Developmint\NpmStats\NpmStats */
    protected $npmStats;

    public function setUp()
    {
        $client = new Client();

        $this->npmStats = new NpmStats($client);

        parent::setUp();
    }

    public function testItCanRetrievePointStats()
    {
        $packageName = 'jquery';

        $result = $this->npmStats->getStats($packageName, NpmStats::LAST_DAY);

        $this->assertArrayHasKey('downloads', $result);
        $this->assertArrayHasKey('start', $result);
        $this->assertArrayHasKey('end', $result);
        $this->assertEquals('jquery', $result["package"]);
    }

    public function testItCanRetrievePointBulkStats()
    {
        $packageNames = 'vuejs,express';

        $result = $this->npmStats->getStats($packageNames, NpmStats::LAST_DAY);

        $this->assertArrayHasKey('vuejs', $result);
        $this->assertArrayHasKey('express', $result);
    }

    public function testItCanRetrieveRangeStats()
    {
        $packageName = 'jquery';

        $result = $this->npmStats->getStats($packageName, NpmStats::LAST_WEEK, true);

        $this->assertArrayHasKey('start', $result);
        $this->assertArrayHasKey('end', $result);
        $this->assertEquals('jquery', $result["package"]);
        $this->assertArrayHasKey('downloads', $result);
        $this->assertArrayHasKey('downloads', $result["downloads"][0]);
        $this->assertArrayHasKey('day', $result["downloads"][0]);
    }
}