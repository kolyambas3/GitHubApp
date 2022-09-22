<?php

namespace App\Service;

use App\Interface\scoreInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubService implements scoreInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $param
     * @return float|bool
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function searchData(string $param): float|bool
    {
        $positive = $this->client->request(
            'GET',
            sprintf('https://api.github.com/search/issues?&q=%s+rocks', $param)
        )->toArray();

        $negative = $this->client->request(
            'GET',
            sprintf('https://api.github.com/search/issues?&q=%s+sucks', $param)
        )->toArray();

        if ($positive['total_count'] === 0 && $negative['total_count'] === 0) {
            return false;
        }

        return $this->calcScore($positive['total_count'], $negative['total_count']);
    }

    /**
     * @param string $positive
     * @param string $negative
     * @return float
     */
    public function calcScore(string $positive, string $negative): float
    {
        return round($positive / (($positive + $negative) / 10), 2);
    }
}