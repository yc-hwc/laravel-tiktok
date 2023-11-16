<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Oauth extends TiktokResource
{
    use TokenApi;

    protected $parentResource = '/open/authorize';
}
