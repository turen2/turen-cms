<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\helpers;

use Yii;
use yii\helpers\ArrayHelper;

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
        return '<input type="checkbox" id="perm-'.(str_replace('/', '-', $route)).'"'.
            ' name="Perm[route][]" value="'.$route.'" '.(($model->checkPerm($route))?'checked="checked"':'').' />'.
            '<label for="perm-'.(str_replace('/', '-', $route)).'"> '.$name.'</label>';
    }
    
    /**
     * 检测模型类中是否包含指定字段
     * @param string $className
     * @param string $field
     */
    public static function CheckFieldExist($className, $field)
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema($className::tableName());
        return !is_null($tableSchema->getColumn($field));
        
//         $fields = ArrayHelper::getColumn($tableSchema->columns, 'name', false);
//         $oldFields = $fields;
//         ArrayHelper::removeValue($fields, $field);
//         return $oldFields != $fields;
    }

    public static function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = [];
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }

    public static function getUrlQuery($array_query)
    {
        $tmp = [];
        foreach ($array_query as $k => $param) {
            $tmp[] = $k . '=' . $param;
        }
        $params = implode('&', $tmp);
        return $params;
    }
}