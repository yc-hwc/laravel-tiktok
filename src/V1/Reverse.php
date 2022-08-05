<?php


namespace PHPTiktok\V1;

use PHPTiktok\V1\Traits\PartnerApi;

class Reverse extends TiktokResource
{
    use PartnerApi;

    protected $parentResource = '/api/reverse';
}
