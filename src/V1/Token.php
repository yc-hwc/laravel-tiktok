<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\TokenApi;

class Token extends TiktokResource
{
    use TokenApi;

    protected $parentResource = '/api/token';
}
