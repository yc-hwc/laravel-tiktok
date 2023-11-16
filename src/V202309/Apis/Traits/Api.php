<?php

namespace PHPTiktok\V202309\Apis\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait Api
{
    public $url;

    public $uri;

    public $fullUrl;

    protected $queryString = [];

    protected $commonQueryString = [];

    protected $timestamp;

    protected $body = '';

    protected $requestMethod = 'post';

    protected $timeout = 60;

    protected $times = 3;

    protected $sleep = 100;

    /**
     * @var PendingRequest $httpClient
     */
    protected $httpClient;

    protected $response;

    protected $headers = [
        'Accept' => 'application/json',
    ];

    protected $options = [
        'verify' => false
    ];

    protected $tiktokClient;

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:16
     * @return $this
     */
    public function setHttpClient()
    {
        $this->httpClient = Http::withOptions($this->options)->timeout($this->timeout)->retry($this->times, $this->sleep);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:16
     * @return PendingRequest
     */
    public function httpClient()
    {
        return $this->httpClient;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:16
     * @param array $options
     * @return $this
     */
    public function withOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        $this->httpClient()->withOptions($this->options);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:16
     * @param int $timeout
     * @return $this
     */
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;
        $this->httpClient->timeout($this->timeout);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:16
     * @param int $times
     * @param int $sleep
     * @return $this
     */
    public function setRetry(int $times, int $sleep = 0)
    {
        $this->times = $times;
        $this->sleep = $sleep;
        $this->httpClient->retry($times, $sleep);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:49
     * @param mixed $body
     * @return false|string
     */
    protected function formatBody(mixed $body)
    {
        return ($this->body = is_array($body) ? json_encode($body) : $body);
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @param $requestMethod
     * @return $this
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @param mixed $body
     * @param string $contentType
     * @return $this
     */
    public function withBody(mixed $body, $contentType = 'application/json')
    {
        $this->httpClient()->withBody($this->formatBody($body), $contentType);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @param array $queryString
     * @return $this
     */
    public function withQueryString(array $queryString)
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @param mixed $headers
     * @return $this
     */
    public function withHeaders(mixed $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        $this->httpClient()->withHeaders($this->headers);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return array|mixed
     * @throws RequestException
     */
    public function post()
    {
        return $this->setRequestMethod('post')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return array|mixed
     * @throws RequestException
     */
    public function put()
    {
        return $this->setRequestMethod('put')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return array|mixed
     * @throws RequestException
     */
    public function get()
    {
        return $this->setRequestMethod('get')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return mixed
     */
    public function run()
    {
        $resource = $this->fullUrl();
        $response = match ($this->requestMethod) {
            'get'  => $this->httpClient()->get($resource),
            'post' => $this->httpClient()->post($resource),
            'put'  => $this->httpClient()->put($resource),
        };

        $this->setResponse($response);
        $response->throw();
        return $response->json()?: $response->body();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @param Response $response
     * @return Response
     */
    public function setResponse(Response $response)
    {
        return $this->response = $response;
    }

    public function fullUrl()
    {
        $this->generateUrl();
        return $this->fullUrl = sprintf('%s%s?%s', ...[
            $this->url,
            $this->uri,
            http_build_query(array_merge($this->queryString?? [], $this->commonQueryString))
        ]);
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:17
     * @return $this
     */
    protected function generateUrl()
    {
        $this->uri = strpos($this->childResources, '/') === 0? $this->childResources : $this->parentResource . '/' . $this->childResources;
        $this->url = $this->tiktokClient->config['tiktokUrl'];
        $this->timestamp = time();
        $this->setApiCommonParameters();
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:18
     */
    protected function setApiCommonParameters()
    {
        $tiktokClient = &$this->tiktokClient;

        $signArr = array_merge($this->queryString, array_filter([
            'app_key'     => $tiktokClient->config['appKey'],
            'timestamp'   => $this->timestamp,
            'shop_cipher' => $tiktokClient->config['shopCipher'],
        ]));

        uksort($signArr, 'strcmp');

        $signStr = sprintf('%s%s%s%s%s', ...[
            $tiktokClient->config['appSecret'],
            $this->uri,
            (function ($signArr) {
                $signStr = '';
                foreach ($signArr as $key => &$val) {
                    $signStr .= $key . $val;
                }

                return $signStr;
            })($signArr),
            $this->body,
            $tiktokClient->config['appSecret'],
        ]);

        $this->withHeaders([
            'x-tts-access-token' => $tiktokClient->config['accessToken']
        ]);

        $this->commonQueryString = array_filter([
            'app_key'     => $tiktokClient->config['appKey'],
            'timestamp'   => $this->timestamp,
            'shop_cipher' => $tiktokClient->config['shopCipher'],
            'sign'        => $this->generateSign($signStr, $tiktokClient->config['appSecret']),
        ]);
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 17:18
     * @param $had
     * @param $key
     * @return string
     */
    protected function generateSign($had, $key)
    {
        return bin2hex(hash_hmac('sha256', $had, $key,true));
    }
}
