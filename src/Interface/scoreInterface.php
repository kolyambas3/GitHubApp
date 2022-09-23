<?php

namespace App\Interface;

interface scoreInterface
{
    public function searchData(string $param):float|bool;

    public function calcScore(int $positive, int $negative):float|bool;
}