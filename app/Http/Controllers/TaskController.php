<?php

namespace App\Http\Controllers;

use App\classes\FilterTaskDescription;
use App\classes\FilterTaskEndDate;
use App\classes\FilterTaskStartDate;
use App\classes\RemoveBadWords;
use App\Contract\Services\CustomTaskServiceInterface;
use App\Http\Requests\DefineTaskForUser;
use App\Http\Requests\FilterTask;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;

class TaskController extends Controller
{
    private CustomTaskServiceInterface $customTaskService;

    public function __construct(CustomTaskServiceInterface $customTaskService)
    {
       $this->customTaskService = $customTaskService;
    }

    public function index()
    {
        $list = $this->customTaskService->index();

        return TaskResource::collection($list);
    }

    /**
     * @param TaskRequest $taskRequest
     * @return TaskResource
     */
    public function store(TaskRequest $taskRequest): TaskResource
    {
        $data = $this->_datasizeData($taskRequest);

        return new TaskResource($this->customTaskService->storeTask($data));
       /* return response()->json([
            'data' => $this->customTaskService->storeTask($data)
        ],Response::HTTP_CREATED);*/
    }

    /**
     * @param TaskRequest $taskRequest
     * @param Task $task
     * @return TaskResource
     */
    public function update(TaskRequest $taskRequest,Task $task): TaskResource
    {
        $data = $this->_datasizeData($taskRequest);

        return new TaskResource($this->customTaskService->updateTask($task,$data));
        /*return response()->json([
            'data' => $this->customTaskService->updateTask($task,$data)
        ]);*/
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task): \Illuminate\Http\JsonResponse
    {
        $this->customTaskService->deleteTask($task);

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function mentionInTask(Task $task): \Illuminate\Http\JsonResponse
    {
         $this->customTaskService->mentionTask($task);

         return \response()->json(['message' => 'you succeeded mention on that task']);
    }


    /**
     * @param DefineTaskForUser $request
     * @return JsonResponse
     */
    public function defineTaskForUsers(DefineTaskForUser $request): JsonResponse
    {
        $this->customTaskService->addUsersToTask($request);

        return \response()->json(['message' => 'successful bind']);
    }

    public function getTaskListByEachUser()
    {
        return $this->customTaskService->getTaskListByUser();
    }

    /**
     * @param FilterTask $request
     * @return JsonResponse
     */
    public function filterable(FilterTask $request): JsonResponse
    {
        //$data = $this->sanitizeTaskFilterData($request);

        $query = Task::query();

        $pipes = [
            FilterTaskStartDate::class,
            FilterTaskEndDate::class,
            FilterTaskDescription::class
        ];

        $value = app(Pipeline::class)
            ->send($query)
            ->through($pipes)
            ->thenReturn()
            ->get();

        return \response()->json(['message' => $value]);
    }

    /**
     * @param TaskRequest $taskRequest
     * @return array
     */
    private function _datasizeData(TaskRequest $taskRequest): array
    {
        return [
           Task::COLUMN_TITLE => $taskRequest->{Task::COLUMN_TITLE},
           Task::COLUMN_DESCRIPTION =>$taskRequest->{Task::COLUMN_DESCRIPTION},
        ];
    }

    /**
     * @param FilterTask $request
     * @return array
     */
    private function sanitizeTaskFilterData(FilterTask $request): array
    {
        return [
            'start_date'     => $request->get('start_date'),
            'end_date'       => $request->get('end_date'),
            'description'    => $request->get('description'),
        ];
    }
}
