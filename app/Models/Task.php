<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


/**
 * @property ?Task $userTasks
 * @property string $title
 */
class Task extends Model
{
    use HasFactory;

    const COLUMN_ID = 'id';
    const COLUMN_TITLE = 'title';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_UPDATED_AT = 'updated_at';

    /**
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value):self
    {
        $this->{self::COLUMN_TITLE} = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDescription(string $value):self
    {
        $this->{self::COLUMN_DESCRIPTION} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle():string
    {
        return $this->{self::COLUMN_TITLE};
    }

    /**
     * @return string
     */
    public function getDescription():string
    {
        return $this->{self::COLUMN_DESCRIPTION};
    }

    public function getId():int
    {
        return $this->{self::COLUMN_ID};
    }

    /**
     * @param array $data
     * @return static
     */
    static public function storeValue(array $data): self
    {
        $newTask = new self;
        $newTask->setTitle($data[self::COLUMN_TITLE])
                ->setDescription($data[self::COLUMN_DESCRIPTION])
                ->save();

         return $newTask;
    }

    /**
     * @param $data
     */
    static public function filterTask($data)
    {
            //
    }

    /**
     * @param Builder $query
     * @return Builder
     */
   public function scopeFilterByDate(Builder $query,array $filter):Builder
    {
        $query->when($filter['start_date'] ?? false , fn ($query,$start_date) =>
        $query
            ->whereDate('created_at','>=',$start_date)
        );
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    /*    public function scopeFilterByDescription(Builder $query):Builder
    {
        //
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userTasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,UserTask::class,'task_id','user_id');
    }

}
