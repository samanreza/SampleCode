<?php

namespace App\Http\Controllers;

use App\Contract\Services\CustomBonusServiceInterface;
use Illuminate\Http\Request;
use \Illuminate\Support\Collection;

class AllocatedBonusForUser extends Controller
{
    public CustomBonusServiceInterface $bonusService;

    public function __construct(CustomBonusServiceInterface $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    public function getUsersBonus()
    {
        return $this->bonusService->getPercentageOfEachPlans();
    }
}
