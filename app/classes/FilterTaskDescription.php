<?php

namespace App\classes;

use App\Models\Task;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterTaskDescription
{
    /**
     * @param Builder $query
     * @param Closure $next
     * @return mixed
     */
    public function handle(Builder $query, Closure $next): mixed
    {
        if (request()->has('description')) {
            $query->where('description','like' ,'%'.request('description').'%');
        }

        return $next($query);
    }
}
