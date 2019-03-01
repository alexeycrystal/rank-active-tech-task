<?php


namespace App\Services;


use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaskService
 * @package App\Services
 */
class TaskService extends AbstractService implements TaskServiceInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $postTaskEndpoint = 'https://api.dataforseo.com/v2/rnk_tasks_post';

    /**
     * TaskService constructor.
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(TaskRepositoryInterface $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * List all tasks
     *
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request)
    {
        return $this->repository->getAll();
    }

    /**
     * Creates a Task
     *
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $result = [
            'model' => null,
            'status' => false,
        ];
        $apiResponse = $this->createApiTask($request->task);
        if ($apiResponse['status'] === 'ok'
            && $this->validateResponseStructure($apiResponse['results'])) {
            $taskData = $this->fetchTaskByApiResult(
                $apiResponse['results'][$request->task['identifier']],
                $request->task['identifier']
            );
            $result['model'] = $this->repository->create($taskData);
            $result['status'] = !is_null($result['model']);
        } else {
            $result['error'] =
                $apiResponse['error']
                ?? 'Task: Task Service - Error occurs due connection.';
        }
        return $result;
    }

    /**
     * Get Task by API-generated task id
     *
     * @param int $id
     * @return mixed
     */
    public function get(int $id){
        return $this->repository
            ->get($id);
    }

    /**
     * Call remote API and created a task
     *
     * @param $task
     * @return array|mixed
     */
    private function createApiTask($task)
    {
        $httpClient = new Client();
        try {
            $response = $httpClient->request('POST', $this->postTaskEndpoint, [
                'headers' => $this->defaultHeaders,
                'json' => [
                    'data' => [
                        $task['identifier'] => [
                            'priority' => 1,
                            'site' => $task['site'],
                            'se_name' => $task['se_name'],
                            'se_language' => $task['se_language'],
                            'loc_name_canonical' => $task['loc_name_canonical'],
                            'key' => $task['key'],
                        ],
                    ],
                ]
            ]);
        } catch (GuzzleException $ex) {
            return $this->handleResponseException($ex);
        }
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Default error handler
     *
     * @param GuzzleException $exception
     * @return array
     */
    private function handleResponseException(GuzzleException $exception)
    {
        $result = [];
        if ($exception->hasResponse()) {
            $exception = (string) $exception->getResponse()->getBody();
            $exception = json_decode($exception);
            $result['error'] = $exception->error;
            $result['code'] = $exception->error->code;
        } else {
            $result['error'] = $exception->getMessage();
            $result['code'] = 503;
        }
        $result['status'] = false;
        return $result;
    }

    /**
     * @param $structure
     * @return mixed
     */
    private function validateResponseStructure($structure)
    {
        $rules = [
            '*.task_id' => 'required',
            '*.post_id' => 'required',
            '*.post_key' => 'required',
            '*.post_site' => 'required',
            '*.se_id' => 'required',
            '*.loc_id' => 'required',
            '*.key_id' => 'required',
            '*.status' => 'required'
        ];
        return Validator::make($structure, $rules)->passes();
    }

    /**
     * @param $result
     * @param $identifier
     * @return array
     */
    private function fetchTaskByApiResult($result, $identifier)
    {
        return [
            'task_identifier' => $identifier,
            'task_id' => $result['task_id'],
            'post_id' => $result['post_id'],
            'post_key' => $result['post_key'],
            'post_site' => $result['post_site'],
            'se_id' => $result['se_id'],
            'loc_id' => $result['loc_id'],
            'key_id' => $result['key_id'],
        ];
    }

}