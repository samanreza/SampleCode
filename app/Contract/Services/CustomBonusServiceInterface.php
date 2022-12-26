<?php

namespace App\Contract\Services;

interface CustomBonusServiceInterface
{
    /**
     * @return array
     */
    public function plans(): array;

    /**
     * @param array $values
     * @param array $weights
     * @return mixed
     */
    public function result(array $values,array $weights): mixed;

    /**
     * @return mixed
     */
    public function getPercentageOfEachPlans(): mixed;

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public function generateNum(int $min,int $max): int;
}
