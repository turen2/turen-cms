<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use backend\behaviors\InsertLangBehavior;

class Tag extends \backend\models\base\Cms
{
    public function behaviors()
    {
        return [
            'insertLang' => [//自动填充多站点和多语言
                'class' => InsertLangBehavior::class,
                'insertLangAttribute' => 'lang',
            ]
        ];
    }
    
    public static function tableName()
    {
        return '{{%cms_tag}}';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['frequency'], 'integer'],
            [['name', 'lang'], 'string'],
        ];
    }
    
    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }
}