<?php

namespace App\classes;

use App\Contract\Services\CustomTaskServiceInterface;
use App\Models\Task;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterTaskStartDate
{

    /**
     * @param Builder $query
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $query, Closure $next): mixed
    {

        if (request()->has('start_date')) {
            $query->where('created_at','>=', request('start_date'));
        }

        return $next($query);
    }
}
