<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\ShowTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * @var TaskServiceInterface
     */
    private $taskService;

    /**
     * TaskController constructor.
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * GET total resources list of tasks
     *
     * @param Request $request
     * @return TaskResourceCollection
     */
    public function index(Request $request)
    {
        return new TaskResourceCollection(
            $this->taskService->getAll($request)
        );
    }

    /**
     * GET specified Task
     *
     * @param ShowTaskRequest $request
     * @return TaskResource
     */
    public function show(ShowTaskRequest $request)
    {
        return new TaskResource(
            $this->taskService->get($request->id)
        );
    }

    /**
     * POST create new Task
     *
     * @param CreateTaskRequest $request
     * @return TaskResource
     */
    public function create(CreateTaskRequest $request)
    {
        $result = $this->taskService->create($request);
        return $result['status']
            ? new TaskResource($result['model']) : $result;
    }
}
