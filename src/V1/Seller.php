<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\ShopApi;

class Seller extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/api/seller';
}