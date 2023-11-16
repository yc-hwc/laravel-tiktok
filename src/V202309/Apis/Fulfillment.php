<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Fulfillment extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/fulfillment/202309';
}
