<?php


namespace PHPTiktok\V202309\Apis;


use PHPTiktok\V202309\Apis\Traits\ShopApi;

class ReturnRefund extends TiktokResource
{
    use ShopApi;

    protected $parentResource = '/return_refund/202309';
}
