<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Product extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/product/202309';
}
