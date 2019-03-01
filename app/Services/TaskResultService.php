<?php


namespace App\Services;


use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskResultServiceInterface;
use App\TaskResult;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaskResultService
 * @package App\Services
 */
class TaskResultService extends AbstractService implements TaskResultServiceInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $getTaskResultEndpoint = 'https://api.dataforseo.com/v2/rnk_tasks_get';

    /**
     * TaskResultService constructor.
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(TaskRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Search all users with unchecked results
     *
     * @return mixed
     */
    public function checkAllResults()
    {
        $tasks = $this->repository->getTasksWithEmptyResult();
        foreach ($tasks as $task) {
            $result = $this->grabTaskResult($task->task_id);
            if ($result && $result->save()) {
                $task->status = true;
                $task->save();
                $task->result();
            }
        }
        return $tasks;
    }

    /**
     * Call API endpoint
     *
     * @param $id
     * @return TaskResult|bool
     */
    private function grabTaskResult($id)
    {
        $httpClient = new Client();
        try {
            $response = $httpClient->request(
                'GET',
                $this->getTaskResultEndpoint . '/' . $id,
                ['headers' => $this->defaultHeaders]);

        } catch (GuzzleException $ex) {
            return false;
        }
        $result = json_decode((string)$response->getBody(), true);
        return ($result['status'] === 'ok'
            && $this->validateResponseStructure($result['results']))
            ? $this->fillResultByApiData($result['results']['organic'][0])
            : false;
    }

    /**
     * Validates response JSON structure
     *
     * @param $structure
     * @return mixed
     */
    private function validateResponseStructure($structure)
    {
        $rules = [
            'organic' => 'required|array',
        ];
        return Validator::make($structure, $rules)->passes();
    }

    /**
     * Prepare new TaskResult by data
     *
     * @param $result
     * @return TaskResult
     */
    private function fillResultByApiData($result)
    {
        $taskResult = new TaskResult();
        $taskResult->task_id = $result['task_id'];
        $taskResult->ended = true;
        $taskResult->date_time = $result['result_datetime'];
        $taskResult->position = $result['result_position'];
        $taskResult->url = $result['result_url'];
        $taskResult->title = $result['result_title'];
        $taskResult->snippet_extra = $result['result_snippet_extra'];
        $taskResult->snippet = $result['result_snippet'];
        $taskResult->count = $result['results_count'];
        $taskResult->extra = $result['result_extra'];
        $taskResult->se_check_url = $result['result_se_check_url'];
        return $taskResult;
    }
}