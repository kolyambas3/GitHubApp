<?php

namespace App\Tests;

use App\Service\GitHubService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubServiceTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCalcScore($input, $expected):void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $gitHubService = new GitHubService($client);
        $positive = $gitHubService->calcScore($input[0], $input[1]);
        $this->assertEquals($positive, $expected);
    }

    public function dataProvider(): iterable
    {
        yield [
            [
                4000, 0
            ],
            10.00
        ];
        yield [
            [
                0, 4000
            ],
             0
        ];
        yield [
            [
                0, 0
            ],
            false
        ];
        yield [
            [
                4000, 4000
            ],
            5.00
        ];
    }
}
