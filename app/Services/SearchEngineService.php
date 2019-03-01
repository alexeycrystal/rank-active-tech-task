<?php


namespace App\Services;


use App\Services\Contracts\SearchEngineServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

/**
 * Class SearchEngineService
 * @package App\Services
 */
class SearchEngineService extends AbstractService implements SearchEngineServiceInterface
{
    /**
     * API endpoint to upload the list of search engines
     *
     * @var string
     */
    private $getEnginesEndpoint = 'https://api.dataforseo.com/v2/cmn_se';

    /**
     * @param Request $request
     * @return array
     */
    public function getSearchEnginesListByCountry(Request $request)
    {
        $result = [
            'models' => null,
            'status' => false,
        ];
        $response = $this->findEngines($request->code);
        if ($response['status'] === 'ok') {
            $result['models'] =
                $this->composeEngineFullnames($response['results']);
        }
        return $result;
    }

    /**
     *
     *
     * @param array $engines
     * @return array
     */
    private function composeEngineFullnames(array $engines)
    {   $newEngines = [];
        foreach ($engines as $key => $engine) {
            $fullName = 'id:' . $engine['se_id']
                . '  ' . $engine['se_name']
                . '  Lang: ' . $engine['se_language'];
                $engine['se_full_title'] = $fullName;
            $newEngines[$key] = $engine;
        }
        return $newEngines;
    }

    /**
     * Search full list of search engines for the selected country
     *
     * @param string $countryCode
     * @return array|mixed
     */
    private function findEngines(string $countryCode)
    {
        $httpClient = new Client();
        try {
            $response = $httpClient->request(
                'GET',
                $this->getEnginesEndpoint . '/' . $countryCode,
                ['headers' => $this->defaultHeaders]
            );
        } catch (GuzzleException $ex) {
            return $this->handleResponseException($ex);
        }
        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Search engine errors handler
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
}