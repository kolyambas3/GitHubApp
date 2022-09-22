<?php

namespace App\Interface;

interface scoreInterface
{
    public function searchData(string $param):float|bool;

    public function calcScore(string $positive, string $negative):float;
}