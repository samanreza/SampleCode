<?php

namespace App\Contract\Repository;
use App\Http\Requests\DefineTaskForUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface CustomTaskModelInterface
{
    public function index();

    public function storeTask(array $data);

    public function getAllUsersTask();

    public function updateTask(Task $task,array $data);

    public function mentionAdminInTask(Task $task);

    /**
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task): void;

    /**
     * @param Task $task
     * @return array
     */
    public function checkWhoCreatedTaskThenDelete(Task $task): array;

    /**
     * @param DefineTaskForUser $request
     * @return void
     */
    public function addUsersToTask(DefineTaskForUser $request): void;

    /**
     * @param DefineTaskForUser $request
     * @return \Illuminate\Database\Eloquent\Collection|array|null
     */
    public function findTask(DefineTaskForUser $request): \Illuminate\Database\Eloquent\Collection|array|null;

    /**
     * @param ?Task $task
     * @param DefineTaskForUser $request
     * @return bool
     */
    public function checkTaskIdAndUserIdInUserTaskTable(?Task $task,DefineTaskForUser $request):bool;

    /**
     * @param array $data
     */
    public function filter(array $data);
}
