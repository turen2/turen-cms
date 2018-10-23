<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace common\helpers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * 一些通用全局的共用函数
 * 
 * @author Jorry
 */
class Functions
{
    /**
     * 生成跨站地址
     * 
     * @param string $domain 全地址域名例如：http://test.com
     * @param string $route 路由字符串
     * @param array $param 链接参数
     * @return string
     */
    public static function CrossDomainUrl($domain, $route = '', $param = [])
    {
        $urlManager = Yii::$app->getUrlManager();
        
        // 1.先备份hostinfo
        $hostInfo = $urlManager->hostInfo;
        
        // 2.重写hostinfo//Yii::getAlias('@http_common')
        $urlManager->hostInfo = $domain;
        
        $url = $urlManager->createAbsoluteUrl(ArrayHelper::merge([
            $route
        ], $param));
        
        // 3.恢复
        $urlManager->hostInfo = $hostInfo;
        
        return $url;
    }

    /**
     * 替换字符串中间位置为星号
     * 
     * @param $string replaceString('simple',
     * '***', 1, 3,"utf-8");
     */
    public static function ReplaceString($string, $replacement, $start, $length = null, $encoding = null)
    {
        if ($encoding == null) {
            if ($length == null) {
                return mb_substr($string, 0, $start) . $replacement;
            } else {
                return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
            }
        } else {
            if ($length == null) {
                return mb_substr($string, 0, $start, $encoding) . $replacement;
            } else {
                return mb_substr($string, 0, $start, $encoding) . $replacement . mb_substr($string, $start + $length, mb_strlen($string, $encoding), $encoding);
            }
        }
    }
    
    /**
     * 清除html图片标签的宽高
     * @param string $content
     * @param string $data
     */
    public static function resetImageSrc($content)
    {
        $config = array('width', 'height');
        foreach($config as $v) {
            $content = preg_replace('/'.$v.'\s*=\s*\d+\s*/i', '', $content);
            $content = preg_replace('/'.$v.'\s*=\s*.+?["\']/i', '', $content);
            $content = preg_replace('/'.$v.'\s*:\s*\d+\s*px\s*;?/i', '', $content);
        }
        
        return $content;
    }
    
    /**
     * 友好格式化时间
     * @param int $time 必须为时间戳
     * @return string
     */
    public static function toTime($time)
    {
        $rtime = date("Y.m.d H:i", $time);
        $htime = date("H:i", $time);
        $time = time() - $time;
        if ($time < 60) {
            $str = "刚刚";
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . "分钟前";
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . "小时前 ";
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d = 1)
                $str = "昨天 ".$htime;
                else
                    $str = "前天 ".$htime;
        } else {
            $str = $rtime;
        }
        return $str;
    }
}