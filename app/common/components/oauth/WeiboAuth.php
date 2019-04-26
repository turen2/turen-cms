<?php

namespace common\components\oauth;

use yii\authclient\OAuth2;

/**
 * Sina Weibo OAuth
 * @author sunsult <vip@sunsult.com>
 * 获取信息的地址位置对应关系：
 * http://open.weibo.com/wiki/%E7%9C%81%E4%BB%BD%E5%9F%8E%E5%B8%82%E7%BC%96%E7%A0%81%E8%A1%A8#HTTP.E8.AF.B7.E6.B1.82.E6.96.B9.E5.BC.8F
 */
class WeiboAuth extends OAuth2 implements IAuth
{
    public $authUrl = 'https://api.weibo.com/oauth2/authorize';
    public $tokenUrl = 'https://api.weibo.com/oauth2/access_token';
    public $apiBaseUrl = 'https://api.weibo.com';

    /**
     * @return []
     * @see http://open.weibo.com/wiki/Oauth2/get_token_info
     * @see http://open.weibo.com/wiki/2/users/show
     */
    protected function initUserAttributes()
    {
        return $this->api('oauth2/get_token_info', 'POST');
    }

    /**
     * get UserInfo
     * @return []
     * @see http://open.weibo.com/wiki/2/users/show
     */
    public function getUserInfo()
    {
        return $this->api("2/users/show.json", 'GET', ['uid' => $this->getOpenid()]);
    }

    /**
     * @return int
     */
    public function getOpenid()
    {
        $attributes = $this->getUserAttributes();
        return $attributes['uid'];
    }

    protected function defaultName()
    {
        return 'Weibo';
    }

    protected function defaultTitle()
    {
        return '微博登录';
    }
}
