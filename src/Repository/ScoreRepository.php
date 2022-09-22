<?php

namespace App\Repository;

use App\Interface\scoreInterface;

class ScoreRepository
{
    private $source;

    /**
     * @param scoreInterface $source
     * @return void
     */
    public function setService(scoreInterface $source)
    {
        $this->source = $source;
    }

    public function searchData(string $param)
    {
        return $this->source->searchData($param);
    }
}