<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\cms;

use app\behaviors\InsertLangBehavior;

class Tag extends \app\models\base\Cms
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