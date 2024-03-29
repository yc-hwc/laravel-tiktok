<?php

namespace PHPTiktok\V1\Traits;

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

    protected $body;

    protected $requestMethod = 'post';

    protected $timeout = 60;

    protected $times = 3;

    protected $sleep = 100;

    protected $httpClient;

    protected $response;

    protected $headers = [
        'Content-type' => 'application/json',
        'Accept'       => 'application/json',
    ];

    protected $options = [
        'verify' => false
    ];

    protected $tiktokSDK;

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:18
     * @return static
     */
    public function setHttpClient()
    {
        $this->httpClient = Http::withOptions($this->options)->timeout($this->timeout)->retry($this->times, $this->sleep);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
     * @return PendingRequest
     */
    public function httpClient()
    {
        return $this->httpClient;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/26 20:33
     * @param array $options
     * @return static
     */
    public function withOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        $this->httpClient()->withOptions($this->options);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
     * @param int $timeout
     * @return static
     */
    public function setTimeout($timeout = 60)
    {
        $this->timeout = $timeout;
        $this->httpClient->timeout($this->timeout);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
     * @param int $times
     * @param int $sleep
     * @return static
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
     * @DateTime: 2022/4/23 11:20
     * @return string
     */
    protected function formatBody()
    {
        if ($this->requestMethod != 'post' || empty($this->body)) {
            return '';
        }

        return is_array($this->body) ? json_encode($this->body) : $this->body;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param $requestMethod
     * @return static
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param mixed $body
     * @param string $contentType
     * @return static
     */
    public function withBody(mixed $body, $contentType = 'application/json')
    {
        $this->body = $body;
        $this->httpClient()->withBody($this->formatBody(), $contentType);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param array $queryString
     * @return static
     */
    public function withQueryString(array $queryString)
    {
        $this->queryString  = $queryString;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param mixed $headers
     * @return static
     */
    public function withHeaders(mixed $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        $this->httpClient()->withHeaders($this->headers);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/20 17:48
     * @return array|mixed
     * @throws RequestException
     */
    public function post()
    {
        return $this->setRequestMethod('post')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/12/13 11:00
     * @return array|mixed
     * @throws RequestException
     */
    public function put()
    {
        return $this->setRequestMethod('put')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/20 17:49
     * @return array|mixed
     * @throws RequestException
     */
    public function get()
    {
        return $this->setRequestMethod('get')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/20 17:49
     * @return array|mixed
     * @throws RequestException
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
     * @DateTime: 2022/4/23 11:19
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
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
     * @DateTime: 2022/4/23 11:18
     * @return static
     */
    protected function generateUrl()
    {
        $this->uri = strpos($this->childResources, '/') === 0? $this->childResources: $this->parentResource . '/' . $this->childResources;
        $this->url = $this->tiktokSDK->config['tiktokUrl'];
        $this->timestamp = time();
        $this->setApiCommonParameters();
        return $this;
    }

    /**
     * 设置api公共参数
     * @Author: hwj
     * @DateTime: 2022/4/23 11:22
     */
    protected function setApiCommonParameters()
    {
        $tiktokSDK = &$this->tiktokSDK;

        $signArr = array_merge($this->queryString, array_filter([
            'app_key'     => $tiktokSDK->config['appKey'],
            'timestamp'   => $this->timestamp,
            'shop_id'     => $tiktokSDK->config['shopId'],
            'shop_cipher' => $tiktokSDK->config['shopCipher'],
        ]));

        uksort($signArr, 'strcmp');

        $signStr = sprintf('%s%s%s%s', ...[
            $tiktokSDK->config['appSecret'],
            $this->uri,
            (function ($signArr) {
                $signStr = '';
                foreach ($signArr as $key => &$val) {
                    $signStr .= $key . $val;
                }

                return $signStr;
            })($signArr),
            $tiktokSDK->config['appSecret']
        ]);

        $this->commonQueryString = array_filter([
            'app_key'      => $tiktokSDK->config['appKey'],
            'timestamp'    => $this->timestamp,
            'access_token' => $tiktokSDK->config['accessToken'],
            'shop_id'      => $tiktokSDK->config['shopId'],
            'shop_cipher'  => $tiktokSDK->config['shopCipher'],
            'sign'         => $this->generateSign($signStr, $tiktokSDK->config['appSecret']),
        ]);
    }

    /**
     * 生成签名
     * @Author: hwj
     * @DateTime: 2022/4/23 11:22
     * @param $had
     * @param $key
     * @return string
     */
    protected function generateSign($had, $key)
    {
        return bin2hex(hash_hmac('sha256', $had, $key,true));
    }
}
