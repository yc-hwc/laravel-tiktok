<?php


namespace PHPTiktok\V1;


use PHPTiktok\V1\Traits\ShopApi;

class Supplychain extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/api/supply_chain';

}
