# laravel-tiktok
tiktok SDK

#### 安装教程
````
composer require yc-hwc/laravel-tiktok
````

### 用法
***

#### 配置
````
    $config = [
        'tiktokUrl'   => '',
        'appKey'      => '',
        'appSecret'   => '',
        'accessToken' => '',
        'shopId'      => '',
    ];
    
    $tiktokSDK = \PHPTiktok\TiktokSDK::config($config);
````
#### [店铺授权](https://developers.tiktok-shops.com/documents/document/234120)
````
        $config = [
            'tiktokUrl'  => '',
        ];
        $tiktokSDK = \PHPTiktok\TiktokSDK::config($config);

        return [
            'redirectUrl' => $tiktokSDK->oauth()->api('authorize')
                ->withQueryString(array_filter([
                    'app_key' => '',
                    'state'   => '',
                ]))
                ->fullUrl()
        ];
````
#### [获取订单列表](https://developers.tiktok-shops.com/documents/document/237434)
````
$config = [
    'tiktokUrl'   => '',
    'appKey'      => '',
    'appSecret'   => '',
    'accessToken' => '',
    'shopId'      => ''
];
$tiktokSDK = \PHPTiktok\TiktokSDK::config($config);
$response = $tiktokSDK->order()->api('/api/orders/search')
    ->withBody([
        'page_size' => 20,
    ])->post();
print_r($response);

tips: /开头为绝对路径uri,不是/开头为相对路径uri,建议使用绝对路径uri
````
