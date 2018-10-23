<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = 'Oops系统好像蒙圈了，请稍后再试。';
?>

<?php 
//特殊显示
if($name == 'Not Found (#404)') {
    echo $this->render('_error/404', ['name' => $name, 'message' => $message]);
//特殊显示
} elseif($name == 'Forbidden (#403)') {
    echo $this->render('_error/403', ['name' => $name, 'message' => $message]);
} else {
    echo $this->render('_error/error', ['name' => $name, 'message' => $message]);
}