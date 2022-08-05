<?php


namespace PHPTiktok\V1;


use PHPTiktok\V1\Traits\ShopApi;

class GlobalProduct extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/api/product';
}
