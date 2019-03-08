<?php

namespace common\models\cms;

use Yii;

/**
 * This is the model class for table "{{%cms_flag}}".
 *
 * @property string $id 信息标记id
 * @property string $flag 标记值
 * @property string $flagname 标记名称
 * @property string $orderid 排列排序
 * @property int $type 所属栏目类型
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Flag extends \common\components\ActiveRecord
{
    private static $_allFlag;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_flag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderid', 'type', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'required'],
            [['flag', 'flagname'], 'string', 'max' => 30],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '信息标记id',
            'flag' => '标记值',
            'flagname' => '标记名称',
            'orderid' => '排列排序',
            'type' => '所属栏目类型',
            'lang' => 'Lang',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }

    /**
     * 获取原系统的所有标签列表
     * @param integer $modelid 模型id
     * @param string $haveFlag 标签名是否带[flag]
     * @return string[]
     */
    public static function FlagList($modelid, $haveFlag = false)
    {
        if(empty(self::$_allFlag)) {
            self::$_allFlag = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
        }

        $flags = [];
        foreach (self::$_allFlag as $flag) {
            if($modelid == $flag['type']) {
                $flags[$flag['flag']] = ($flag['flagname'].($haveFlag?'['.$flag['flag'].']':''));
            }
        }

        return $flags;
    }

    /**
     * {@inheritdoc}
     * @return FlagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FlagQuery(get_called_class());
    }
}
