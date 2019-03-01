<?php

namespace App\Repositories;


use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Task;

/**
 * Class TaskRepository
 * @package App\Repositories
 */
class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var Task
     */
    private $model;

    /**
     * TaskRepository constructor.
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Selects Task by APi-generated id
     *
     * @param int $id
     * @return Task
     */
    public function get(int $id): Task
    {
        return $this->model
            ->where('task_id', $id)
            ->first();
    }

    /**
     * Inserts new Task by selected data
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return $this->model->create($data);
    }

    /**
     * Selects all tasks paginated
     *
     * @param int $pagination
     * @return mixed
     */
    public function getAll(int $pagination = 50)
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);
    }

    /**
     * Get unactivated tasks
     *
     * @param int $pagination
     * @return mixed
     */
    public function getTasksWithEmptyResult(int $pagination = 50)
    {
        return $this->model
            ->where('status', false)
            ->paginate($pagination);
    }
}