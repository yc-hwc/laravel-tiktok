<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\TokenApi;

class Oauth extends TiktokResource
{
    use TokenApi;

    protected $parentResource = '/oauth';
}
