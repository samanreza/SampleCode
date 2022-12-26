<?php

namespace App\Contract\Services;

use App\Http\Requests\DefineTaskForUser;
use App\Models\Task;
use App\Models\User;

interface CustomTaskServiceInterface
{
    public function index();

    public function storeTask(array $data);

    public function updateTask(Task $task,array $data);

    public function mentionTask(Task $task);

    public function deleteTask(Task $task);

    public function getTaskListByUser();

    /**
     * @param DefineTaskForUser $request
     */
    public function addUsersToTask(DefineTaskForUser $request);

    public function filterTask();
}
