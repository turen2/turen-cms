<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\helpers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;

/**
 * 图片高清缩放压缩
 * 
 * @author jorry
 */
class ImageHelper
{
    /**
     * 图片压缩，且可以设置缩放比例，将$img按照$percent比例进行缩放
     * @param string $img 原图
     * @param string $newImg 新图
     * @param number $percent 缩放比率
     */
    public static function Compress($img, $newImg, $percent = 1) {
        //文件不存在
        if(!file_exists($img)) {
            throw new InvalidArgumentException('源文件不存在');
        }
        
        //后缀名不一致
        if(strtolower(strrchr($img, '.')) != strtolower(strrchr($newImg, '.'))) {
            throw new InvalidArgumentException('源文件后缀与预期文件后缀不一致');
        }
        
        //不在指定后缀名范围
        $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp', '.gif'];
        if(!in_array(strtolower(strrchr($img, '.')), $allowImgs)) {
            throw new InvalidArgumentException('系统仅支持如下文件类型：jpg、jpeg、png、bmp、wbmp、gif');
        }
        
        //1.打开图像
        list ($width, $height, $type, $attr) = getimagesize($img);
        $imageinfo = [
            'width' => $width,
            'height' => $height,
            'type' => image_type_to_extension($type, false),
            'attr' => $attr
        ];
        
        $fun = 'imagecreatefrom' . $imageinfo['type'];
        $image = $fun($img);
        
        //2.操作图片
        $new_width = $imageinfo['width'] * $percent;
        $new_height = $imageinfo['height'] * $percent;
        $image_thump = imagecreatetruecolor($new_width, $new_height);
        // 将原图复制在图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump, $image, 0, 0, 0, 0, $new_width, $new_height, $imageinfo['width'], $imageinfo['height']);
        imagedestroy($image);
        $image = $image_thump;
        
        $funcs = 'image' . $imageinfo['type'];
        $funcs($image, $newImg);
        
        return true;
    }
    
    public static function getNopic($position = false)
    {
        $pwebUrl = Yii::$app->request->hostInfo.'/';
        $webUrl = Yii::getAlias('@web/images/');
        if($position) {
            return $pwebUrl.'nopic.jpg';
        } else {
            return $webUrl.'nopic.jpg';
        }
    }
    
    public static function Crop($height, $width, $percent) {
        
        
        
        
        
        
    }
}