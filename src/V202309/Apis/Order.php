<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Order extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/order/202309';
}
