<?php

namespace App\Repositories\Contracts;


use App\Task;

interface TaskRepositoryInterface
{
    public function __construct(Task $model);

    public function get(int $id): Task;

    public function create(array $data): Task;

    public function getAll(int $pagination);

    public function getTasksWithEmptyResult(int $pagination);
}