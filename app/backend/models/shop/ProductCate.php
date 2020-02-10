<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\shop;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\helpers\Json;
use backend\behaviors\InsertLangBehavior;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%shop_product_cate}}".
 *
 * @property string $id 商品类型id
 * @property string $parentid 类型上级id
 * @property string $parentstr 类型上级id字符串
 * @property string $cname 类别名称
 * @property string $ctext 链接集合
 * @property string $picurl 缩略图片
 * @property string $linkurl 跳转链接
 * @property string $orderid 排列顺序
 * @property int $status 是否显示
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class ProductCate extends \backend\models\base\Shop
{
    public $keyword;
    public $level;
    
    private static $_allCate;
	
	public function behaviors()
	{
	    return [
	        'parentString' => [
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'parentstr',
	                ActiveRecord::EVENT_BEFORE_UPDATE => 'parentstr',
	            ],
	            'value' => function ($event) {
    	            //添加和编辑，都要处理parentstr
    	            return $this->initParentStr();
	            },
            ],
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertlang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        'defaultOrderid' => [
	            'class' => OrderDefaultBehavior::class,
            ],
	    ];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_product_cate}}';
    }
    
    /**
     * 为联表操作做准备
     * {@inheritDoc}
     * @see \yii\db\ActiveRecord::attributes()
     */
    public function attributes()
    {
        return ArrayHelper::merge(parent::attributes(), []);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //静态默认值由规则来赋值
        //[['status'], 'default', 'value' => self::STATUS_ON],
        //[['hits'], 'default', 'value' => Yii::$app->params['config.hits']],
        return [
            [['cname'], 'required'],
            [['parentid', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['ctext'], 'string'],
            [['parentstr'], 'string', 'max' => 50],
            [['cname'], 'string', 'max' => 30],
            [['picurl', 'linkurl'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentid' => '所属上级分类',
            'parentstr' => '所属上级分类串',
            'cname' => '类别名称',
            'ctext' => '附加展开菜单',
            'picurl' => '缩略图片',
            'linkurl' => '跳转链接',
            'orderid' => '排列顺序',
            'status' => '是否显示',
            'lang' => '多语言',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    /**
    * 分类属性表单
    */
    public static function AttributeForm($pcateid, $attrtext = '')
    {
        $jsonArr = [];
        if(!empty($attrtext)) {
            $jsonArr = Json::decode($attrtext);
        }
        
        $str = '';
        $attributeModels = Attribute::find()->current()->active()->andWhere(['pcateid' => $pcateid])->orderBy(['orderid' => SORT_DESC])->all();
        if($attributeModels && !empty($pcateid) && $pcateid > 0) {//防止分类id为0的情况
            foreach ($attributeModels as $attributeModel) {
                $arrtxt = [];
                if(strpos($attributeModel->typetext, '|') !== false) {
                    foreach (explode('|', $attributeModel->typetext) as $name) {
                        $arrtxt[$name] = $name;
                    }
                }
                
                $str .= '<li>'.Html::label($attributeModel->attrname, 'attr-'.$attributeModel->id);
                switch ($attributeModel->type) {
                    case 'text':
                        $val = isset($jsonArr[$attributeModel->attrname])?$jsonArr[$attributeModel->attrname]:$attributeModel->typetext;
                        $str .= Html::textInput('pattribute['.$attributeModel->attrname.']', $val, ['class' => 'input txt-input170', 'id' => 'attr-'.$attributeModel->id]);
                        break;
                    case 'select':
                        $val = isset($jsonArr[$attributeModel->attrname])?$jsonArr[$attributeModel->attrname]:[];
                        $str .= Html::dropDownList('pattribute['.$attributeModel->attrname.']', $val, $arrtxt, ['class' => '', 'id' => 'attr-'.$attributeModel->id]);
                        break;
                    case 'checkbox':
                        $val = isset($jsonArr[$attributeModel->attrname])?$jsonArr[$attributeModel->attrname]:[];
                        $str .= Html::checkboxList('pattribute['.$attributeModel->attrname.']', $val, $arrtxt, ['class' => '', 'id' => 'attr-'.$attributeModel->id]);
                        break;
                    case 'radio':
                        $val = isset($jsonArr[$attributeModel->attrname])?$jsonArr[$attributeModel->attrname]:[];
                        $str .= Html::radioList('pattribute['.$attributeModel->attrname.']', $val, $arrtxt, ['class' => '', 'id' => 'attr-'.$attributeModel->id]);
                }
                $str .= '</li>';
            }
            
            return '<ul class="attr-box clearfix">'.$str.'</ul>';
        } else {
            return '<div style="color:#9C0;">暂无自定义属性，您可以在商品类别中进行绑定</div>';
        }
    }
    
    /**
     * 获取所有类别列表
     * @return array
     */
    public static function CateList() {
        if(empty(self::$_allCate)) {
            self::$_allCate = self::find()->current()->orderBy(['orderid' => SORT_DESC])->asArray()->all();
            foreach (self::$_allCate as $cate) {
                self::$_allCate[$cate['id']] = $cate;
            }
        }
        
        return self::$_allCate;
    }
    
    /**
     * 类别名称
     * @param integer $cateid
     * @return string|string|mixed
     */
    public static function CateName($cateid = null) {
        $name = '未定义';
        $cateList = self::CateList();
        if(is_null($cateid)) {
            return $name;
        } else {
            return isset($cateList[$cateid])?$cateList[$cateid]['cname']:$name;
        }
    }

    /**
     * @inheritdoc
     * @return ProductCateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCateQuery(get_called_class());
    }
}
