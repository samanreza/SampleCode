<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    protected $table = 'user_task';

    const COLUMN_USER_ID = 'user_id';
    const COLUMN_TASK_ID = 'task_id';


    public function getUserId(): string
    {
        $userId = $this->{self::COLUMN_USER_ID};

        return $userId;
    }
 }
