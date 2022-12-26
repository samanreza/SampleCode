<?php

namespace App\classes;

use Closure;
use Exception;

class RemoveBadWords
{
    /**
     * @param array $content
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(array $content, Closure $next): mixed
    {
        if ($content['title'] != 'sdakajsdfh')
        {
            return $next($content);
        }
        throw new Exception('Do not use This word');
    }
}
