<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\httpclient\Client;

class Util
{
    public static function convertModelToArray($models)
    {
        if (is_array($models)) {
            $arrayMode = true;
        } else {
            $models = array($models);
            $arrayMode = false;
        }

        $result = [];
        foreach ($models as $model) {
            $attributes = ArrayHelper::toArray($model);
            $relations = [];
            if ($model instanceof \yii\base\Model) {
                foreach ($model->getRelatedRecords() as $key => $related) {
                    if ($model->getRelation($key)) {
                        if ((is_array($model->$key)) || ($model->$key instanceof \yii\base\Model)) {
                            $relations[$key] = self::convertModelToArray($model->$key);
                        } else {
                            $relations[$key] = $model->$key;
                        }
                    }
                }
            }
            $all = array_merge($attributes, $relations);

            if ($arrayMode) {
                array_push($result, $all);
            } else {
                $result = $all;
            }
        }
        return $result;
    }

    public static function convertArrayToString($arr, $pre = '')
    {
        $str = '[' . "\n";
        $isAssociative = ArrayHelper::isAssociative($arr);
        foreach ($arr as $k => $v) {
            if ($isAssociative) {
                if (is_string($k)) {
                    $k = '\'' . $k . '\' => ';
                } else {
                    $k = $k . ' => ';
                }
            } else {
                $k = '';
            }
            if (is_int($v)) {
            } else if (is_string($v)) {
                $v = '\'' . str_replace('\'', '\\\'', $v) . '\'';
            } else if (is_bool($v)) {
                $v = ($v === true ? 'true' : 'false');
            } else if (is_array($v)) {
                $v = self::convertArrayToString($v, $pre . '  ');
            } else {
                $v = '';
            }
            $str = $str . $pre . '  ' . $k . $v . ',' . "\n";
        }
        return $str . $pre . ']';
    }

    public static function code62($x)
    {
        $show = '';
        while ($x > 0) {
            $s = $x % 62;
            if ($s > 35) {
                $s = chr($s + 61);
            } else if ($s > 9 && $s <= 35) {
                $s = chr($s + 55);
            }
            $show .= $s;
            $x = floor($x / 62);
        }
        return $show;
    }

    public static function shorturl($url)
    {
        $url = crc32($url);
        $result = sprintf("%u", $url);
        return self::code62($result);
    }

    public static function generateRandomString($length = 32)
    {
        $str = '';
        if (extension_loaded('openssl')) {
            $str = Yii::$app->security->generateRandomString($length);
        } else {
            $possible = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
            $possible_len = strlen($possible);
            $i = 0;

            while ($i < $length) {
                $str .= $possible[rand(0, $possible_len - 1)];
                $i++;
            }
        }
        return $str;
    }

    public static function getReferrer()
    {
        $request = Yii::$app->getRequest();
        $referrer = $request->getReferrer();
        $hostInfo = $request->getHostInfo();
        if (!$referrer || strpos($referrer, $hostInfo) !== 0) {
            $referrer = null;
        } else {
            $referrer = str_replace($hostInfo, '', $referrer);
        }
        return $referrer;
    }

    public static function getRedirect()
    {
        if (!($redirect = Yii::$app->getRequest()->get('redirect')) || !\yii\helpers\Url::isRelative($redirect)) {
            $redirect = null;
        }
        return $redirect;
    }

    public static function autoLink($content)
    {
        $autolink = ArrayHelper::getValue(Yii::$app->params, 'settings.autolink', 0);
        if (intval($autolink) === 0) {
            return $content;
        }

        preg_match_all('/<a.*?href=.*?>.*?<\/a>/i', $content, $linkList);
        $linkList = $linkList[0];
        $str = preg_replace('/<a.*?href=.*?>.*?<\/a>/i', '<{link}>', $content);


        preg_match_all('/<img[^>]+>/im', $content, $imgList);
        $imgList = $imgList[0];
        $str = preg_replace('/<img[^>]+>/im', '<{img}>', $str);

//        $str=preg_replace('(https?[-a-zA-Z0-9@:%_/+.~#?&//=]+)','<a href="\0" target="_blank">\0</a>',$str);
        if (preg_match_all('/\bhttps?:[\/]{2}[^\s<]+\b\/*/ui', $str, $matchs)) {
            $urls = $matchs[0];
        } else {
            return $content;
        }

        // Replace all the URLs
        if (empty($urls)) {
            return $content;
        }

        $urls = array_unique($urls);
        $exceptUrls = ArrayHelper::getValue(Yii::$app->params, 'settings.autolink_filter', []);
        foreach ($urls as $url) {
            $flg = false;
            foreach ($exceptUrls as $excpt) {
                if (strpos($url, $excpt) !== false) {
                    $flg = true;
                    break;
                }
            }
            if ($flg === false) {
                $str = str_replace($url, '<a href="' . $url . '" target="_blank">' . $url . '</a>', $str);
            }
        }

        foreach ($linkList as $link) {
            $str = preg_replace('/<{link}>/', $link, $str, 1);
        }
        foreach ($imgList as $link) {
            $str = preg_replace('/<{img}>/', $link, $str, 1);
        }
        return $str;
    }

    /**
     * 省级联级数据
     * @param $province
     * @return bool
     */
    public static function CreateProvinceSelector($province)
    {
        $data = Json::decode(file_get_contents(FileHelper::normalizePath(Yii::getAlias('@app/web/js/pack.json'))));
        if (isset($data[$province])) {
            return $data[$province];
        }

        return false;
    }

    /**
     * 远程请求ip定位
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function IPAddess()
    {
        $url = 'http://ip.360.cn/IPShare/info';
        //$url = 'http://ip.360.cn/IPQuery/ipquery';
//        $ip = Yii::$app->getRequest()->getUserIP();
//        if(in_array($ip, ['127.0.0.1', 'localhost'])) {
//            $ip = '116.77.73.249';//默认为深圳
//        }

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
//            ->setData(['ip' => $ip])
            ->send();

        if ($response->isOk) {
            return [
                'location' => $response->data['location'],
            ];
        }

        return false;
    }

    /**
     * 验证是否是一个合格的Url
     * @param $url
     * @param array $validSchemes
     * @param bool $enableIDN
     * @return bool
     */
    public static function ValidationUrl($url, $validSchemes = ['http', 'https'], $enableIDN = false)
    {
        $defaultScheme = 'http';
        $pattern = '/^{schemes}:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';

        if (is_string($url) && strlen($url) < 2000) {
            if ($defaultScheme !== null && strpos($url, '://') === false) {
                $url = $defaultScheme . '://' . $url;
            }

            if (strpos($pattern, '{schemes}') !== false) {
                $pattern = str_replace('{schemes}', '(' . implode('|', $validSchemes) . ')', $pattern);
            } else {
                $pattern = $pattern;
            }

            if ($enableIDN) {
                $url = preg_replace_callback('/:\/\/([^\/]+)/', function ($matches) {
                    $idn = idn_to_ascii($matches[1], IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46);
                    if (PHP_VERSION_ID < 50600) {
                        // TODO: drop old PHP versions support
                        $idn = idn_to_ascii($matches[1]);
                    }
                    return '://' . $idn;
                }, $url);
            }

            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 生成简单的单号
     */
    public static function GenerateSimpleOrderNumber($prefix, $ext = '')
    {
        return $prefix . date('ymdHis') . $ext;
    }

    /**
     * 手机号码中间位隐藏
     * @param $number
     * @return mixed
     */
    public static function HidePhone($number)
    {
        return substr_replace($number, '****', 3, 4);
    }

    /**
     * 用户名、邮箱、手机账号中间字符串以*隐藏
     * @param $str
     * @return string|string[]|null
     */
    public static function HidePart($str)
    {
        if (strpos($str, '@')) {//邮箱
            $email_array = explode("@", $str);
            $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3);
            $count = 0;
            $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
            $rs = $prevfix . $str;
        } else {
            $pattern = '/(1[3578]{1}[0-9])[0-9]{4}([0-9]{4})/i';
            if (preg_match($pattern, $str)) {//手机号
                $rs = preg_replace($pattern, '$1****$2', $str);
            } else {//用户名
                $rs = substr($str, 0, 3) . "***" . substr($str, -1);
            }
        }

        return $rs;
    }

    /**
     * 生成随机验证码
     * @param $num
     * @return string
     */
    public static function GeneratePhoneCode($num)
    {
        $numbers = '1234567890';
        $code = '';
        for ($i = 0; $i < $num; ++$i) {
            $code .= $numbers[mt_rand(0, 9)];
        }

        return $code;
    }

    /**
     * 虚拟客户列表，电话和姓名
     */
    public static function VirtualUserList($count = 10, $suffix = '已预约', $cacheTime = 86400)
    {
        define('CACHE_KEY', 'CACHE_KEY_6161613136165');

        $xing = ['夏', '程', '罗', '金', '李', '陈', '沈', '邓', '高', '孙', '赵', '郭', '余', '霍', '刘', '李', '陈', '张', '黄', '王', '吴', '周', '胡',
            '李', '刘', '张', '陈', '杨', '胡', '黄', '王', '徐', '周', '王', '李', '张', '刘', '陈', '杨', '黄', '赵', '钱', '智', '周', '徐', '彭', '吕',
            '吴', '徐', '孙', '马', '胡', '朱', '郭', '何', '罗', '高', '林', '李', '王', '张', '刘', '陈', '杨', '赵', '黄', '周', '吴', '徐', '孙', '胡',
            '朱', '高', '林', '何', '郭', '马', '罗', '梁', '宋', '郑', '谢', '韩', '唐', '冯', '于', '董', '萧', '程', '曹', '袁', '邓', '许', '傅', '沈', '曾'];
        $gender = ['先生', '先生', '先生', '先生', '先生', '先生', '先生', '先生', '女士', '女士', '女士'];
        $numbers = '1234567890';

        if(Yii::$app->cache->exists(CACHE_KEY)) {
            return Yii::$app->cache->get(CACHE_KEY);
        } else {
            $list = [];
            for ($li = 0; $li < $count; $li++) {
                $time = rand(strtotime(date('Y-m-d')), time());//当天随机时间
                $title = Functions::toTime($time);
                $title .= $xing[array_rand($xing, 1)].$gender[array_rand($gender, 1)];
                $title .= '****';
                for ($i = 0; $i < 4; ++$i) {
                    $title .= $numbers[mt_rand(0, 9)];
                }
                $list[$time] = $title.$suffix;// 时间会进行排序
            }
            Yii::$app->cache->set(CACHE_KEY, $list, $cacheTime); // 必须要有缓存时间

            return $list;
        }
    }

    /**
     * 详情图片去掉宽高及所有内联样式
     * @param $content
     * @return string|string[]|null
     */
    public static function ContentPasswh($content, $delInline = true)
    {
        //去除样式
        if($delInline)
            $content = preg_replace("/style=.+?['|\"]/i",'',$content);

        $content = preg_replace('/(?:width)=(\'|").*?\\1/', ' width="100%"', $content);
        $content = preg_replace('/(?:height)=(\'|").*?\\1/', ' ', $content);

        $content = preg_replace('/(?:max-width:\s*\d*\.?\d*(px|rem|em))/', '', $content);
        $content = preg_replace('/(?:max-height:\s*\d*\.?\d*(px|rem|em))/', '', $content);

        $content = preg_replace('/(?:min-width:\s*\d*\.?\d*(px|rem|em))/', ' ', $content);
        $content = preg_replace('/(?:min-height:\s*\d*\.?\d*(px|rem|em))/', ' ', $content);

        return $content;
    }

    /**
     * html清理大全
     * @param $content
     * @return string|string[]|null
     */
    public static function ClearHtml($content) {
        $content = preg_replace("/<a[^>]*>/i", "", $content);
        $content = preg_replace("/<\/a>/i", "", $content);
        $content = preg_replace("/<div[^>]*>/i", "", $content);
        $content = preg_replace("/<\/div>/i", "", $content);
        $content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容
        $content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式
        $content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数

        return $content;
    }
}