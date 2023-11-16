<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Supplychain extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/supply_chain/202309';
}
