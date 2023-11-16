<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Logistics extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/logistics/202309';
}
