<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Promotion extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/promotion/202309';
}
