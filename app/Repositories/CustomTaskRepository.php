<?php

namespace App\Repositories;
use App\Http\Requests\DefineTaskForUser;
use \App\Models\Task;
use App\Models\User;
use \App\Models\UserTask;
use App\Contract\Repository\CustomTaskModelInterface;
use Illuminate\Database\Eloquent\Builder;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class CustomTaskRepository implements CustomTaskModelInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return Task::query()->with(['userTasks'])->select([
            Task::COLUMN_ID,
            Task::COLUMN_TITLE,
            Task::COLUMN_DESCRIPTION,
            Task::COLUMN_CREATED_AT,
            Task::COLUMN_UPDATED_AT
        ])->paginate();
    }



    public function getAllUsersTask()
    {
        return User::query()->find(auth('api')->user()['id'])->taskUser;
    }

    /**
     * @param array $data
     * @return Task|Throwable
     */
    public function storeTask(array $data): Task|Throwable
    {
        try {
            DB::beginTransaction();
                $newTask = new Task();
                $newTask->setTitle($data[Task::COLUMN_TITLE]);
                $newTask->setDescription($data[Task::COLUMN_DESCRIPTION]);
                $newTask->save();

                $newTask->userTasks()->attach($newTask,[
                    UserTask::COLUMN_USER_ID => auth('api')->user()['id']
                ]);

            DB::commit();
                return $newTask;
        }catch (Throwable $exception){
            DB::rollBack();

            return $exception;
        }
    }

    /**
     * @param Task $task
     * @param array $data
     * @return Task|Throwable
     */
    public function updateTask(Task $task,array $data):task|Throwable
    {
        try {
            DB::beginTransaction();
                $task->setTitle($data[Task::COLUMN_TITLE])

                     ->setDescription($data[Task::COLUMN_DESCRIPTION])

                     ->update();

                $task->userTasks()->updateExistingPivot($task,[
                    UserTask::COLUMN_TASK_ID => $task->getId(),
                ]);
            DB::commit();
                return $task;
        }catch (\Throwable $exception){
            DB::rollBack();

            return $exception;
        }
    }

    /**
     * @param Task $task
     * @return void
     */
    public function mentionAdminInTask(Task $task): void
    {
        DB::transaction(function () use($task){
           $task->userTasks()->attach($task,[
               UserTask::COLUMN_USER_ID => auth('api')->user()['id']
           ]);
        });
    }

    /**
     * @param Task $task
     * @param DefineTaskForUser $request
     * @return void
     */
    public function addUsersToTask(DefineTaskForUser $request): void
    {
        DB::transaction(function () use($request){
            /** @var User $user */
            $user = User::find($request->request->get('user'));
            $user->tasks()->syncWithoutDetaching($request->get('task'));
        });
    }

    /**
     * @param DefineTaskForUser $request
     * @return \Illuminate\Database\Eloquent\Collection|array|null
     */
    public function findTask(DefineTaskForUser $request): \Illuminate\Database\Eloquent\Collection|array|null
    {
        return Task::query()->whereIn('id',$request->task)->get();
    }

    /**
     * @param ?Task $task
     * @param DefineTaskForUser $request
     * @return bool
     */
    public function checkTaskIdAndUserIdInUserTaskTable(?Task $task,DefineTaskForUser $request): bool
    {
        return $task->userTasks->contains($request->user);
    }

    public function filter(array $data)
    {
        //return Task::filterTask($data);
    }

    /**
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task): void
    {
        DB::transaction(function () use($task){

            $task->userTasks()->detach();

            $task->delete();
        });
    }

    /**
     * @param Task $task
     * @return array
     */
    public function checkWhoCreatedTaskThenDelete(Task $task): array
    {
        $data = $this->getAllUsersTask();
        return $data->pluck('id')->toArray();
    }
}
