<?php

namespace App\classes;

use App\Models\Task;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterTaskEndDate
{

    /**
     * @param Builder $query
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $query, Closure $next): mixed
    {
        if (request()->has('end_date')) {
            $query->where('created_at', '<=',request('end_date'));
        }
        return $next($query);
    }
}
