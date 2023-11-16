<?php

namespace PHPTiktok\V202309;

use PHPTiktok\Exception\SdkException;

use PHPTiktok\V202309\Apis\{Authorization,Event,Promotion,Token, Oauth, Seller,ReturnRefund,Product,Order,Logistics,Finance,Fulfillment,Supplychain};

/**
 * @property-read Seller $seller
 * @property-read Promotion $promotion
 * @property-read Event $event
 * @property-read Authorization $authorization
 * @property-read Oauth $oauth
 * @property-read Token $token
 * @property-read ReturnRefund $returnRefund
 * @property-read Product $product
 * @property-read Order $order
 * @property-read Logistics $logistics
 * @property-read Finance $finance
 * @property-read Fulfillment $fulfillment
 * @property-read Supplychain $supplychain
 *
 * @method Authorization authorization()
 * @method Promotion promotion()
 * @method Event event()
 * @method Token token()
 * @method Oauth oauth()
 * @method ReturnRefund returnRefund()
 * @method Product product()
 * @method Order order()
 * @method Logistics logistics()
 * @method Finance finance()
 * @method Fulfillment fulfillment()
 * @method Seller seller()
 * @method Supplychain supplychain()
 */
class TiktokClient
{
    protected $resources = [
        'promotion',
        'event',
        'authorization',
        'token',
        'oauth',
        'returnRefund',
        'product',
        'order',
        'logistics',
        'finance',
        'fulfillment',
        'seller',
        'supplychain'
    ];

    public $config = [
        'tiktokUrl'   => '',
        'appKey'      => '',
        'appSecret'   => '',
        'accessToken' => '',
        'shopCipher'  => '',
    ];

    public function __construct($config)
    {
        $this->config = array_merge($this->config, $config);
    }

    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    public function __call($resourceName, $arguments)
    {
        if (!in_array($resourceName, $this->resources)) {
            throw new SdkException(sprintf('Invalid resource name %s. Pls check the API Reference to get the appropriate resource name.', $resourceName));
        }

        $resourceClassName = __NAMESPACE__ . "\\Apis\\" . \ucfirst($resourceName);

        $resource = new $resourceClassName($this);

        return $resource;
    }

    public static function config($config)
    {
        return new static($config);
    }
}
