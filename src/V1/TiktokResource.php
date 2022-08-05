<?php

namespace PHPTiktok\V1;

use PHPTiktok\TiktokSDK;

abstract class TiktokResource
{
    protected $parentResource;

    protected $childResources;

    protected $tiktokSDK;

    public function __construct(TiktokSDK $tiktokSDK)
    {
        $this->tiktokSDK = $tiktokSDK;
        $this->setHttpClient();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/25 12:14
     * @param $resourceName
     * @return static
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/25 12:02
     * @param $resourceName
     * @param $arguments
     * @return staitc
     */
    public function __call($resourceName, $arguments)
    {
        return $this->api($resourceName);
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/25 14:06
     * @param $childResources
     * @return static
     */
    public function api($childResources)
    {
        $this->childResources = sprintf('/%s', $childResources);
        return $this;
    }

    public abstract function setHttpClient();
}
