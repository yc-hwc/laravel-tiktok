<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\TokenApi;

class Oauth extends TiktokResource
{
    use TokenApi;

    protected $parentResource = '/open/authorize';
}
