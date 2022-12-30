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
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\HigherOrderWhenProxy|mixed
     */
    static public function filterTask(array $data)
    {
           return self::query()->select([
                self::COLUMN_TITLE,
                self::COLUMN_DESCRIPTION,
                self::COLUMN_CREATED_AT]
            )->when($data['start_date'] ?? false,fn($query) => $query->filterByStartDate($data))
            ->when($data['end_date'] ?? false,fn($query) => $query->filterByEndDate($data))
            ->when($data['description'] ?? false,fn($query) => $query->filterByDescription($data));
    }

    /**
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
   public function scopeFilterByStartDate(Builder $query,array $filter):Builder
    {
        /*$query->when($filter['start_date'] ?? false , fn ($query,$start_date) =>
        $query
            ->whereDate('created_at','>=',$start_date)
        );*/
        return $query->where('created_at','>=',$filter['start_date']);
    }

    /**
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    public function scopeFilterByEndDate(Builder $query,array $filter):Builder
    {
        return $query->where('created_at', '<=',$filter['end_date']);
    }

    /**
     * @param Builder $query
     * @param array $filter
     * @return Builder
     */
    public function scopeFilterByDescription(Builder $query,array $filter):Builder
    {
        return $query->where('description','like' ,'%'.$filter['description'].'%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userTasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class,UserTask::class,'task_id','user_id');
    }

}
