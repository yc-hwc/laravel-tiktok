<?php

namespace PHPTiktok\V202309\Apis;

use PHPTiktok\V202309\TiktokClient;

abstract class TiktokResource
{
    protected $parentResource;

    protected $childResources;

    protected $tiktokClient;

    public function __construct(TiktokClient $tiktokClient)
    {
        $this->tiktokClient = $tiktokClient;
        $this->setHttpClient();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 16:51
     * @param $resourceName
     * @return mixed
     */
    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 16:51
     * @param $resourceName
     * @param $arguments
     * @return $this
     */
    public function __call($resourceName, $arguments)
    {
        return $this->api($resourceName);
    }

    /**
     * @Author: hwj
     * @DateTime: 2023/11/15 16:51
     * @param $childResources
     * @return $this
     */
    public function api($childResources)
    {
        $this->childResources = $childResources;
        return $this;
    }

    public abstract function setHttpClient();
}
