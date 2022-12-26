<?php

namespace App\Http\Resources;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            Task::COLUMN_ID => $this->{Task::COLUMN_ID},
            Task::COLUMN_TITLE => $this->{Task::COLUMN_TITLE},
            Task::COLUMN_DESCRIPTION => $this->{Task::COLUMN_DESCRIPTION},
            Task::COLUMN_CREATED_AT => (string) $this->{Task::COLUMN_CREATED_AT},
            Task::COLUMN_UPDATED_AT => (string) $this->{Task::COLUMN_UPDATED_AT},
            'user'                  => UserResource::collection($this->resource->userTasks)
        ];
    }
}
