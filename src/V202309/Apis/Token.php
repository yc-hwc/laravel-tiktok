<?php


namespace PHPTiktok\V202309\Apis;

use PHPTiktok\V202309\Apis\Traits\TokenApi;

class Token extends TiktokResource
{
    use TokenApi;

    protected $parentResource = '/api/v2/token/get';
}
