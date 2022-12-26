<?php

namespace App\Services;
use App\Contract\Repository\CustomTaskModelInterface;
use App\Contract\Services\CustomTaskServiceInterface;
use App\Http\Requests\DefineTaskForUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;

class CustomTaskService implements CustomTaskServiceInterface
{
    private CustomTaskModelInterface $customTaskModel;
    public function __construct(CustomTaskModelInterface $customTaskModel)
    {
        $this->customTaskModel = $customTaskModel;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        if (Gate::allows('admin')){
            return $this->customTaskModel->index();
        }else{
            throw new \Exception(['Message' => 'Access Denied']);
        }
    }

    public function storeTask($data)
    {
        return $this->customTaskModel->storeTask($data);
    }

    public function updateTask(Task $task, array $data)
    {
        if (Gate::allows('admin')) {
            return $this->customTaskModel->updateTask($task, $data);
        }
    }

    public function mentionTask(Task $task)
    {
        if (Gate::allows('admin')) {
            return $this->customTaskModel->mentionAdminInTask($task);
        }
    }

    public function getTaskListByUser()
    {
        return $this->customTaskModel->getAllUsersTask();
    }

    /**
     * @param DefineTaskForUser $request
     */
    public function addUsersToTask(DefineTaskForUser $request)
    {
        return $this->customTaskModel->addUsersToTask($request);
    }

    public function filterTask()
    {

    }

    public function deleteTask(Task $task)
    {
        if (Gate::allows('admin')){
            return $this->customTaskModel->deleteTask($task);
        }
        $value = $this->customTaskModel->checkWhoCreatedTaskThenDelete($task);

        if (in_array($task['id'],$value))
        {
            return $this->customTaskModel->deleteTask($task);
        }
    }
}
