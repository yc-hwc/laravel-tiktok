<?php


namespace PHPTiktok\V202309\Apis;

use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Seller extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/seller/202309';
}
