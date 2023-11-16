<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Finance extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/finance/202309';
}
