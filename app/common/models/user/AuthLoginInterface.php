<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

interface AuthLoginInterface
{
    /**
     * 统一获取头像
     */
    public function getDisplayAvatar();
    
    /**
     * 统一获取昵称
     */
    public function getDisplayName();
    
}