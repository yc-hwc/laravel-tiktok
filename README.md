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
        $tiktokSDK = TiktokSDK::config($config);

        return [
            'redirectUrl' => $tiktokSDK->oauth()->api('authorize')
                ->withQueryString(array_filter([
                    'app_key' => '',
                    'state'   => '',
                ]))
                ->fullUrl()
        ];
````
