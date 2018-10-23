<?php 
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace common\components;

use yii\base\Component;

/**
 * 雪花生成器
 * @author jorry
 */
class SnowFlake extends Component
{
    //假设一个机器id
    public $machineId = 1234567890;
    
    /**
     * 生成一个全局唯一随机数
     * @return string
     */
    public function next()
    {
        //41bit timestamp(毫秒)
        $time = floor(microtime(true) * 1000);

        //0bit 未使用
        $suffix = 0;

        //datacenterId  添加数据的时间
        $base = decbin(pow(2,40) - 1 + $time);

        //workerId  机器ID
        $machineid = decbin(pow(2,9) - 1 + $this->machineId);

        //毫秒类的计数
        $random = mt_rand(1, pow(2,11)-1);
        $random = decbin(pow(2,11)-1 + $random);         
        //拼装所有数据
        $base64 = $suffix.$base.$machineid.$random;
        //将二进制转换int
        $base64 = bindec($base64);

        $id = sprintf('%.0f', $base64);

        return $id;
    }
}