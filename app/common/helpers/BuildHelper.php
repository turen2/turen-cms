<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\helpers;

use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\exception\ModelAttributeException;
use yii\helpers\Url;

/**
 * 专门以递归的方式构建所需要的数据组织形式
 * 
 * @author Jorry
 * 
 * 常见用法：
 * $models = $dataProvider->getModels();
        
    //获取纯粹关系网
    $nexus = BuildHelper::getModelNexus($models, Menu::class, 'menu_id', 'parent_id');//即将模型抽离出来以简单的id和pid的数组
    
    //重构模型数组key
    $newModels = BuildHelper::reBuildModelKeys($models, 'menu_id');//即可以配合关系网，可以直接定位到模型
    
    //获取递归树，从boot起
    $tree = BuildHelper::buildTree($nexus, 0);//即将原有的抽象数组，转化为以多维数组带child的形式保存关系
    
    //展开树
    $newTree = BuildHelper::displayTree($tree);//将树的多层关系，转化为一维数组关系，配合level，可以显示出层级
    foreach ($newTree as $t) {
        echo str_repeat('--.', $t['level']-1).$t['id'];
        echo '<br />';
    }
    exit;

    $list = BuildHelper::buildList($nexus);//等同于上述三个方法的综合效果
    echo '<pre>';
    foreach ($list as $t) {
        echo str_repeat('--.', $t['level']-1).$t['id'];
        echo '<br />';
    }
    exit;
    
    //面包屑
    $breadcrumbnewModels = BuildHelper::buildBreadcrumb($models, '7,1,', 'menu_id');//一次性生成面包屑数组模型
    
    //$dataProvider综合方案
    $dataProvider = BuildHelper::rebuildDataProvider($dataProvider, Menu::class, 'menu_id', 'parent_id');//用以上的方法实现了对$dataProvider递归排序处理，使用快捷
 */
class BuildHelper
{
    /**
     * 获取模型数组的纯粹父子关系网
     * 
     * @param [] $models ActiveRecord[]
     * @param string $className
     * @param string $primaryKey
     * @param string $pidKey
     * @return array[]
     */
    public static function getModelNexus($models, $className, $primaryKey = 'id', $pidKey = 'pid')
    {
        $nexus = [];
        
        $properties = [
            $className => [
                $primaryKey,
                $pidKey,
            ],
        ];
        foreach ($models as $model) {
            $nexus[$model->{$primaryKey}] = ArrayHelper::toArray($model, $properties);
        }
        
        $newNexus = [];
        foreach ($nexus as $key => $value) {
            $newNexus[$key]['id'] = $value[$primaryKey];
            $newNexus[$key]['pid'] = $value[$pidKey];
        }
        unset($nexus);
        
        return $newNexus;
    }
    
    /**
     * 重构模型数组键值
     * 
     * @param array $models ActiveRecord[]
     * @return array
     */
    public static function reBuildModelKeys($models, $primaryKey = 'id')
    {
        $newModels = [];
        foreach ($models as $model) {
            $newModels[$model->{$primaryKey}] = $model;
        }
        
        return $newModels;
    }
    
    /**
     * 构建递归树
     * 
     * @param array $rows 来自getModelNexus()
     * @param number $pid
     * @param number $level
     * @return array
     */
    public static function buildTree($rows, $pid, $level = 1)
    {
        $result = [];
        foreach ($rows as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['level'] = $level;
                $result[$key] = $value;
            }
        }
        
        if (empty($result)) {
            return [];
        }
        
        $level ++;
        
        foreach ($result as $key => $value) {
            $rescurTree = self::buildTree($rows, $value['id'], $level);
            if (! empty($rescurTree)) {
                $result[$key]['child'] = $rescurTree;
            }
        }
        
        return $result;
    }

    /**
     * 梳理递归展开树
     * 
     * @param array $tree 来自buildTree()
     * @return array
     */
    public static function displayTree($tree, &$result = [])
    {
        foreach ($tree as $key => $value) {
            if (! empty($value['child'])) {
                $tmp = $value;
                unset($tmp['child']);
                $result[$key] = $tmp;
                self::displayTree($value['child'], $result);
            } else {
                $result[$key] = $value;
            }
        }
        
        return $result;
    }

    /**
     * 构建递归列表
     * 
     * @param array $rows 来自getModelNexus()
     * @param number $pid
     * @param array $result
     * @param number $level
     * @return array
     */
    public static function buildList($rows, $pid = 0, &$result = [], $level = 0)
    {
        $level += 1;
        foreach ($rows as $key => $val) {
            if ($pid == $val['pid']) {
                $result[$key] = $val;
                $result[$key]['level'] = $level;
                
                self::buildList($rows, $val['id'], $result, $level);
            }
        }
        
        return $result;
    }
    
    /**
     * 通过parentstr返回面包屑对象数组
     * 
     * @param array $models ActiveRecord[]
     * @return array ActiveRecord[]
     */
    public static function buildBreadcrumb($models, $parentStr, $primaryKey = 'id')
    {
        $breadcrumb = [];
        $models = self::reBuildModelKeys($models, $primaryKey);
        
        foreach (explode(',', $parentStr) as $id) {
            if(!empty($id) || $id === 0) {
                $breadcrumb[] = $models[$id];
            }
        }
        
        return $breadcrumb;
    }
    
    /**
     * 将模型的数据供应器（$dataProvider）重新递归排序，且生成新的level属性，进而在展示的时候实现上下的层次感
     * 
     * @param ActiveDataProvider $dataProvider
     * @return \yii\data\ActiveDataProvider
     */
    public static function rebuildDataProvider(ActiveDataProvider $dataProvider, $className, $primaryKey = 'id', $pidKey = 'pid')
    {
        if(!property_exists($className, 'level')) {
            throw new ModelAttributeException();
        }
        $models = $dataProvider->getModels();
        
        $models = BuildHelper::reBuildModelKeys($models, $primaryKey);//重构模型数组索引
        $nexus = self::getModelNexus($models, $className, $primaryKey, $pidKey);//获取父子关系
        $list = self::buildList($nexus);
        $newModels = [];
        foreach ($list as $id => $item) {
            $newModels[$id] = $models[$id];//按照新的关系，重新排序
            $models[$id]->level = $item['level'];
        }
        
        $dataProvider->setModels($newModels);
        $dataProvider->setKeys(array_keys($newModels));//重构模型数组索引key
        
        return $dataProvider;
    }
    
    /**
     * 生成select下拉选择器数据[栏目专用]
     * @param array $models
     * @param string $className
     * @param string $primaryKey
     * @param string $pidKey
     * @param string $nameKey
     * @param boolean $isTop
     * @param integer $type
     * @return string[]
     */
    public static function buildSelectorData($models, $className, $primaryKey = 'id', $pidKey = 'pid', $nameKey = 'name', $isTop = true)
    {
        $models = BuildHelper::reBuildModelKeys($models, $primaryKey);//重构模型数组索引
        $nexus = self::getModelNexus($models, $className, $primaryKey, $pidKey);//获取父子关系
        $list = self::buildList($nexus);
        $arr = [];
        foreach ($list as $id => $item) {
            //按照新的关系，重新排序
            $arr[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->{$nameKey});
        }
        
        return $isTop?ArrayHelper::merge([0 => '顶级类目'], $arr):$arr;
    }
    
    /**
     * 生成select下拉选择器[模型专用]
     * @param array $models
     * @param string $className
     * @param string $primaryKey
     * @param string $pidKey
     * @param string $nameKey
     * @param boolean $isTop
     * @param null | integer | array $type
     * @return string select html
     */
    public static function buildSelector($model, $attribute, $models, $className, $primaryKey = 'id', $pidKey = 'pid', $nameKey = 'name', $isTop = true, $type = null, $selectOptions = [])
    {
        $models = BuildHelper::reBuildModelKeys($models, $primaryKey);//重构模型数组索引
        $nexus = self::getModelNexus($models, $className, $primaryKey, $pidKey);//获取父子关系
        $list = self::buildList($nexus);
        $arr = [];
        $selectOptions = ArrayHelper::merge(['encode' => false, 'options' => []], $selectOptions);
        $options = [];
        foreach ($list as $id => $item) {
            //按照新的关系，重新排序
            $arr[$id] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->{$nameKey});
            // if(!is_null($type) && $type != $models[$id]->type) {
            // f(isset($models[$id]) && (is_null($type) || (!is_array($type) && $models[$id]->type == $type) || (is_array($type) && in_array($models[$id]->type, $type)))) {
            if(!is_null($type) && ((!is_array($type) && $type != $models[$id]->type) || (is_array($type) && !in_array($models[$id]->type, $type)))) {
                $options[$id] = ['disabled' => true];
            }
        }
//         echo '<pre>';
//         var_dump($options);exit;
        
        $arr = $isTop?ArrayHelper::merge([null => '请选择所属栏目'], $arr):$arr;
        $selectOptions['options'] = $options;
        
        return Html::activeDropDownList($model, $attribute, $arr, $selectOptions);
    }

    /**
     * @param $models
     * @param $className
     * @param string $primaryKey
     * @param string $pidKey
     * @param string $nameKey
     * @param bool $isTop
     * @param null | integer | array $type
     * @param string $searchName
     * @param string $field
     * @param array $addRoutes
     * @return string
     */
    public static function buildFilter($models, $className, $primaryKey = 'id', $pidKey = 'pid', $nameKey = 'name', $isTop = true, $type = null, $searchName = '', $field = '', $addRoutes = [])
    {
        $models = BuildHelper::reBuildModelKeys($models, $primaryKey);//重构模型数组索引
        $nexus = self::getModelNexus($models, $className, $primaryKey, $pidKey);//获取父子关系
        $list = self::buildList($nexus);
        $str = '';
        foreach ($list as $id => $item) {
            //按照新的关系，重新排序
            if(isset($models[$id]) && (is_null($type) || (!is_array($type) && $models[$id]->type == $type) || (is_array($type) && in_array($models[$id]->type, $type)))) {
                $str .= '<a href="'.Url::to(ArrayHelper::merge(['index', $searchName.'['.$field.']' => $id], $addRoutes)).'">'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $item['level']-1).(empty($item['level']-1)?'':'|-').($models[$id]->{$nameKey}).'</a>';
            }
        }
        
        if($str) {
            return $str;
        } else {
            return '';
        }
    }
}