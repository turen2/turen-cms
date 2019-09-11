<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\site;

use Yii;
use yii\helpers\ArrayHelper;
use app\behaviors\InsertLangBehavior;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%site_face_config}}".
 *
 * @property string $cfg_name 变量名称
 * @property string $cfg_value 变量值
 * @property string $lang 多语言
 */
class FaceConfig extends \app\models\base\Site
{
    private static $_config;
    
    public function behaviors()
    {
        return [
            'insertLang' => [//自动填充多站点和多语言
                'class' => InsertLangBehavior::class,
                'insertLangAttribute' => 'lang',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_face_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cfg_name', 'cfg_value'], 'string'],
            [['cfg_name'], 'string', 'max' => 100],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cfg_name' => '变量名称',
            'cfg_value' => '变量值',
            'lang' => '多语言',
        ];
    }

    /**
     * 获取指定语言和站点的界面配置
     * @return mixed
     */
    public static function FaceConfigArray()
    {
        if(empty(self::$_config)) {
            self::$_config = self::find()->current()->asArray()->all();
        }
        
        return self::$_config;
    }
    
    /**
     * 批量更新配置数据
     * @param array $data
     * @return boolean
     */
    public static function batchSave(array $data)
    {
        $csrfParam = Yii::$app->getRequest()->csrfParam;
        if (isset($data[$csrfParam])) {
            unset($data[$csrfParam]);
        }

        $models = self::find()->current()->all();
        $oldFaceConfigArray = ArrayHelper::map($models, 'cfg_name', 'cfg_value');

        $model = new self;
        foreach ($data as $key => $val) {
            //如果有则更新
            if (isset($oldFaceConfigArray[$key])) {
                unset($oldFaceConfigArray[$key]);//剔除
                self::updateAll(['cfg_value' => $val], ['cfg_name' => $key]);
            } else {
                //统一新建
                $model->isNewRecord = true;
                $model->cfg_name = $key;
                $model->cfg_value = $val;
                $model->save(false);
            }
        }
        //删除多余的
        self::deleteAll(['cfg_name' => array_keys($oldFaceConfigArray)]);

        //更新前台初始化缓存
        TagDependency::invalidate(Yii::$app->cache, Yii::$app->params['config.updateAllFaceCache']);

        return true;
    }

    /**
     * @inheritdoc
     * @return FaceConfigQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaceConfigQuery(get_called_class());
    }
}
