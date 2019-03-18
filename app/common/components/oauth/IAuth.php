<?php

namespace common\components\oauth;

/**
 * Oauth Interface
 * @author sunsult <vip@sunsult.com>
 */
interface IAuth
{
    /**
     *
     * @return []
     */
    public function getUserInfo();

    /**
     *
     * @return mixed
     */
    public function getOpenid();
}
