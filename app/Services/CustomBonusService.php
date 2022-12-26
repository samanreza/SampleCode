<?php

namespace App\Services;

use App\Contract\Services\CustomBonusServiceInterface;

class CustomBonusService implements CustomBonusServiceInterface
{
    /**
     * @return array[]
     */
    public function plans(): array
    {
        return [
            ['Number' => 27, 'Value' =>     0 , 'CostOfEach100Game' => 0       ,  'symbol' => 'Empty'],// 9 + 9 + 9 pooch
            ['Number' => 8 , 'Value' => 17500 , 'CostOfEach100Game' => 140000  ,  'symbol' => '50 Hezar Shiba'],
            ['Number' => 5 , 'Value' => 30500 , 'CostOfEach100Game' => 152000  ,  'symbol' => '100 Digi Byte'],
            ['Number' => 5 , 'Value' => 25000 , 'CostOfEach100Game' => 125000  ,  'symbol' => '200 Verj'],
            ['Number' => 5 , 'Value' => 20000 , 'CostOfEach100Game' => 100000  ,  'symbol' => '5 hezar vink'],
            ['Number' => 8 , 'Value' => 16900 , 'CostOfEach100Game' => 135000  ,  'symbol' => '2 million Doj'],
            ['Number' => 4 , 'Value' => 67000 , 'CostOfEach100Game' => 268000  ,  'symbol' => '2 teter'],
            ['Number' => 5 , 'Value' => 38500 , 'CostOfEach100Game' => 192000  ,  'symbol' => '200 jasemi'],
            ['Number' => 5 , 'Value' => 21200 , 'CostOfEach100Game' => 106000  ,  'symbol' => '200 belagtopia'],
            ['Number' => 5 , 'Value' => 40700 , 'CostOfEach100Game' => 204000  ,  'symbol' => '20 doj'],
            ['Number' => 5 , 'Value' => 53000 , 'CostOfEach100Game' => 265000  ,  'symbol' => '25 teron'],
            ['Number' => 9 , 'Value' => 9700  , 'CostOfEach100Game' => 87500   ,  'symbol' => '1000 lona classic'],
            ['Number' => 9 , 'Value' => 14400 , 'CostOfEach100Game' => 130000  ,  'symbol' => '500 hezar bit torent jadid']
        ];
    }

    public function getPercentageOfEachPlans(): mixed
    {
        $percentage = $this->plans();

        $weight = [];

        $value = [];

        foreach ($percentage as $item){

            $weight[] = $item['Number'];

            $value[] = $item['symbol'];
        }

        return $this->result($value,$weight);
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public function generateNum(int $min, int $max): int
    {
        return mt_rand($min,$max);
    }

    public function result(array $values, array $weights): mixed
    {
        $count = count($values);
        $i = 0;
        $n = 0;
        $num = $this->generateNum(1, array_sum($weights));
        while($i < $count){
            $n += $weights[$i];
            if($n >= $num){
                break;
            }
            $i++;
        }
        return $values[$i];
    }
}
