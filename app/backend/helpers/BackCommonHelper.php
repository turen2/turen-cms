<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\helpers;

class BackCommonHelper {
    
    public static function ShowMsg($msg='', $gourl='-1')
    {
        if($gourl == '-1') {
            echo '<script>alert("'.$msg.'");history.go(-1);</script>';
        } else if($gourl == '0') {
            echo '<script>alert("'.$msg.'");location.reload();</script>';
        } else {
            echo '<script>alert("'.$msg.'");location.href="'.$gourl.'";</script>';
        }
    }
    
    public static function CheckPermBox(\app\models\sys\Role $model, $route, $name)
    {
        return '<input type="checkbox" id="perm-'.(str_replace('/', '-', $route)).'" name="Perm[route][]" value="'.$route.'" '.(($model->checkPerm($route))?'checked="checked"':'').' /><label for="perm-'.(str_replace('/', '-', $route)).'"> '.$name.'</label>';
    }
}