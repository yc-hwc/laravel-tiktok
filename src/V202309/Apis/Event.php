<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class Event extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/event/202309';
}
