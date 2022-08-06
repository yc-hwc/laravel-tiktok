<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\ShopApi;

class Oauth extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/oauth';
}
