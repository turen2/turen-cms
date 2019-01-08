<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%cms_tag}}".
 *
 * @property int $tag_id
 * @property string $name
 * @property string $frequency
 * @property string $slug
 * @property string $lang 简体中文
 */
class Tag extends \common\components\ActiveRecord
{
    private static $_TagsCache = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_tag}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 128],
            [['lang'], 'string', 'max' => 8],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => Yii::t('app', 'Tag ID'),
            'name' => Yii::t('app', 'Name'),
            'frequency' => Yii::t('app', 'Frequency'),
            'slug' => Yii::t('app', 'Slug'),
            'lang' => Yii::t('app', '简体中文'),
        ];
    }

    /**
     * 利用短类码，获取对应模型的所有标签，且以模型为单位进行运行缓存。
     * @param $shortClassName
     * @param string $id
     * @return array
     */
    public static function TagList($shortClassName, $id = '') {
        //联表查询，使用全数据加缓存
        if(isset(self::$_TagsCache[$shortClassName])) {
            $tags = self::$_TagsCache[$shortClassName];
        } else {
            $query = TagAssign::find()->alias('ta')->select(['ta.*', 't.name'])
                ->leftJoin(self::tableName().' as t', ' t.tag_id = ta.tag_id')
                ->where(['t.lang' => GLOBAL_LANG, 'class' => $shortClassName]);

            //if(!empty($id)) {
                //$query->andWhere(['item_id' => $id]);
            //}

            //echo $query->createCommand()->getRawSql();exit;

            $tags = $query->asArray()->all();
            self::$_TagsCache[$shortClassName] = $tags;
        }

        if(!empty($id)) {
            $itemTags = [];
            foreach ($tags as $tag) {
                if($tag['item_id'] == $id) {
                    $itemTags[] = $tag;
                }
            }
            return $itemTags;
        } else {
            $newTags = [];
            foreach ($tags as $tag) {
                if(isset($newTags[$tag['tag_id']])) {
                    $newTags[$tag['tag_id']]['hits']++;
                } else {
                    $newTags[$tag['tag_id']]['name'] = $tag['name'];
                    $newTags[$tag['tag_id']]['hits'] = 1;
                }
            }

            ArrayHelper::multisort($newTags, 'hits', SORT_DESC);
            return $newTags;
        }
    }

    /**
     * {@inheritdoc}
     * @return TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }
}
