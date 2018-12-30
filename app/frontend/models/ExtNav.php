<?php

namespace app\models;

use common\helpers\BuildHelper;
use Yii;

/**
 * This is the model class for table "{{%ext_nav}}".
 *
 * @property string $id 导航id
 * @property string $parentid 导航分类
 * @property string $parentstr 导航分类父id字符串
 * @property string $menuname 导航名称
 * @property string $linkurl 跳转链接
 * @property string $picurl 导航图片
 * @property string $target 打开方式
 * @property string $orderid 排列排序
 * @property int $status 导航状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class ExtNav extends \app\components\ActiveRecord
{
    private static $_allModel;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_nav}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentid', 'parentstr', 'menuname', 'linkurl', 'picurl', 'target', 'lang'], 'required'],
            [['parentid', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr'], 'string', 'max' => 80],
            [['menuname', 'target'], 'string', 'max' => 30],
            [['linkurl'], 'string', 'max' => 255],
            [['picurl'], 'string', 'max' => 100],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '导航id'),
            'parentid' => Yii::t('app', '导航分类'),
            'parentstr' => Yii::t('app', '导航分类父id字符串'),
            'menuname' => Yii::t('app', '导航名称'),
            'linkurl' => Yii::t('app', '跳转链接'),
            'picurl' => Yii::t('app', '导航图片'),
            'target' => Yii::t('app', '打开方式'),
            'orderid' => Yii::t('app', '排列排序'),
            'status' => Yii::t('app', '导航状态'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }

    /**
     * 导航菜单只支持两层
     * @param int $navid 菜单顶级项
     * @param int $level 开始层级
     * @return array
     */
    public static function NavByCode($navid)
    {
        $models = static::find()->current()->active()->all();
        $models = BuildHelper::reBuildModelKeys($models, 'id');//重构模型数组索引
        $nexus = BuildHelper::getModelNexus($models, self::class, 'id', 'parentid');//获取父子关系
        $list = BuildHelper::buildList($nexus);

        $mainNav = [];
        $subNav = [];
        $point = false;//指向截停功能
        $level = 1;
        foreach ($list as $id => $item) {
            //按照新的关系，重新排序
            if($id == $navid && !$point) {
                $point = true;
                $level = $item['level'];
                continue;
            }
            if($id == $navid && $point) {
                $point = false;
                break;
            }

            if($point && $item['level'] == ($level + 1)) {//一级
                $mainNav[] = $models[$item['id']];
            }

            if($point && $item['level'] == ($level + 2)) {//二级
                $subNav[$models[$item['id']]->parentid][] = $models[$item['id']];
            }
        }

        return ['main' => $mainNav, 'sub' => $subNav];//返回一级菜单和对应的二级菜单
    }

    /**
     * {@inheritdoc}
     * @return ExtNavQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExtNavQuery(get_called_class());
    }
}
