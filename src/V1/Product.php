<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\ShopApi;

class Product extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/api/products';
}
