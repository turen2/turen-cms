<?php

namespace common\components\oauth;

use yii\authclient\OAuth2;

/**
 * Renren OAuth
 * @author light <light-li@hotmail.com>
 * @see http://wiki.dev.renren.com/wiki/Authentication
 */
class RenrenAuth extends OAuth2 implements IAuth
{
    public $authUrl = 'https://graph.renren.com/oauth/authorize';
    public $tokenUrl = 'https://graph.renren.com/oauth/token';
    public $apiBaseUrl = 'https://api.renren.com';
    
    /**
     * Try to use getUserAttributes to get simple user info
     * @see http://wiki.dev.renren.com/wiki/Authentication
     *
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->getAccessToken()->getParams()['user'];
    }

    /**
     * Get authed user info
     *
     * @see http://wiki.dev.renren.com/wiki/V2/user/get
     * @return array
     */
    public function getUserInfo()
    {
        return $this->api("v2/user/get", 'GET', ['userId' => $this->getOpenid()]);
    }

    /**
     * @return int
     */
    public function getOpenid()
    {
        $attributes = $this->getUserAttributes();
        return $attributes['id'];
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'renren';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return '人人登录';
    }

}
