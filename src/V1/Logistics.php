<?php


namespace PHPTiktok\V1;


use PHPTiktok\V1\Traits\PublicApi;

class Logistics extends TiktokResource
{
    use PublicApi;

    protected $parentResource = '/api/logistics';
}
