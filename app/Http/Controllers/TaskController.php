<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\ShowTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        return new TaskResourceCollection(
            $this->taskService->getAll($request)
        );
    }

    public function show(ShowTaskRequest $request)
    {
        return new TaskResource(
            $this->taskService->get($request->id)
        );
    }

    public function create(CreateTaskRequest $request)
    {
        $result = $this->taskService->create($request);
        return $result['status']
            ? new TaskResource($result['model']) : $result;
    }
}
