<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use backend\behaviors\OrderDefaultBehavior;

/**
 * This is the model class for table "{{%diy_field}}".
 *
 * @property string $id 自定义字段id
 * @property string $fd_column_type 所属模型类型
 * @property int $columnid_list 所属栏目
 * @property string $fd_name 字段名称
 * @property string $fd_title 字段标题
 * @property string $fd_desc 字段提示
 * @property string $fd_type 字段类型
 * @property string $fd_long 字段长度
 * @property string $fd_value 字段选项值
 * @property string $fd_check 校验正则
 * @property string $fd_tips 未通过提示
 * @property string $orderid 排列排序
 * @property int $status 是否生效
 * @property int $list_status 是否在列表中显示（自定义模型专用）
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class DiyField extends \backend\models\base\Cms
{
    const FIELD_PRE = 'diyfield_';
    const FIELD_MULTI_UPLOAD_NAME = 'diyfield-multi-upload';
    const FIELD_UPLOAD_NAME = 'diyfield-upload';
    
	public $keyword;
	
	/**
	 * 自定义模型和字段中统一采用的类型规则
	 */
	public static $fieldTypeList = [
	    //标识 => 字段类型，名称，长度，默认值，提示
	    'varchar' => ['name' => 'varchar', 'type' => 'varchar', 'title' => '单行文本', 'size' => '50', 'value' => '默认文本（注意清空）', 'tips' => '字数较少，例如文章标题等；默认长度小于或等于'],
	    'text' => ['name' => 'text', 'type' => 'text', 'title' => '多行文本', 'size' => '0', 'value' => '默认文本（注意清空）', 'tips' => '字数偏多，类似于文章描述形式的多行文本'],
	    'mediumtext' => ['name' => 'mediumtext', 'type' => 'mediumtext', 'title' => '编辑器', 'size' => '0', 'value' => '默认文本（注意清空）', 'tips' => '字数较多，输入框带编辑器大型文本，如文章内容'],
	    'int' => ['name' => 'int', 'type' => 'int', 'title' => '整数', 'size' => '10', 'value' => '0', 'tips' => '正负整数类型字段，如123456；长度默认为'],
	    'radio' => ['name' => 'radio', 'type' => 'varchar', 'title' => '单选菜单', 'size' => '1', 'value' => 'abc-123|34-DEG', 'tips' => '默认值填充格式为：“abc-123|34-DEG”左边是提交值，右边显示名，多个以“|”分隔。'],
	    'checkbox' => ['name' => 'checkbox', 'type' => 'varchar', 'title' => '多选菜单', 'size' => '1', 'value' => 'abc-123|34-DEG', 'tips' => '默认值填充格式为：“abc-123|34-DEG”左边是提交值，右边显示名，多个以“|”分隔。'],
	    'select' => ['name' => 'select', 'type' => 'varchar', 'title' => '下拉菜单', 'size' => '20', 'value' => 'abc-123|34-DEG', 'tips' => '默认值填充格式为：“abc-123|34-DEG”左边是提交值，右边显示名，多个以“|”分隔。'],
	    'decimal' => ['name' => 'decimal', 'type' => 'decimal', 'title' => '货币', 'size' => '10,2', 'value' => '10.2', 'tips' => '如102.56；长度默认为 "<span class="blue">10,2</span>"，"10"代表值总长度，"2"代表小数位数'],
	    'datetime' => ['name' => 'datetime', 'type' => 'int', 'title' => '日期时间', 'size' => '10', 'value' => '0', 'tips' => '如2012-07-25 10:21:23，本系统日期格式为整型，所以系统会为您创建为整型字段；<span class="blue">字段长度留空</span>'],
	    'file' => ['name' => 'file', 'type' => 'varchar', 'title' => '单个附件', 'size' => '128', 'value' => '', 'tips' => '上传类型字段(如图片、文档等)，上传类型、大小等限制按系统附件设置执行；默认长度小于或等于 "<span class="blue">100</span>"'],
	    'filearr' => ['name' => 'filearr', 'type' => 'text', 'title' => '多个附件', 'size' => '0', 'value' => '', 'tips' => '多个附件：</strong>可上传多个附件，类似于组图上传；<span class="blue">字段长度留空 </span>'],
	];
	
	private static $FieldModels;//缓存
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
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
        return '{{%diy_field}}';
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
        return [
            [['columnid_list', 'fd_title', 'fd_column_type', 'fd_name', 'fd_type'], 'required'],
            [['fd_title', 'fd_name'], 'unique'],
            [['fd_column_type', 'orderid', 'status', 'list_status', 'created_at', 'updated_at'], 'integer'],
            [['fd_name', 'fd_title', 'fd_type', 'fd_tips', 'fd_long', 'fd_desc', 'fd_value', 'fd_check'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['list_status'], 'default', 'value' => self::STATUS_OFF],
            [['columnid_list', 'keyword'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fd_column_type' => '所属模型类型',
            'columnid_list' => '所属栏目',
            'fd_name' => '字段名',
            'fd_title' => '字段标题',
            'fd_desc' => '字段提示',
            'fd_type' => '字段类型',
            'fd_long' => '字段长度',
            'fd_value' => '字段选项值',
            'fd_check' => '格式控制',
            'fd_tips' => '未通过提示',
            'orderid' => '排列排序',
            'status' => '是否生效',
            'list_status' => '列表显示',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    /**
     * 插入之前整理，且通过过滤器，删除之前保已经调整了表结构
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeSave()
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        //转化columnid list为字符串
        if(is_array($this->columnid_list)) {
            $this->columnid_list = implode(',', $this->columnid_list);
        }
        
        //增加或删除模型中的字段
        $className = Column::ColumnConvert('id2class', $this->fd_column_type);
        //判断自定义模型
        if(strpos($className, 'MasterModel_'.$this->fd_column_type) !== false) {
            $className = str_replace('MasterModel_'.$this->fd_column_type, 'MasterModel', $className);
            $className::$DiyModelId = $this->fd_column_type;
        }
        
        $tableName = $className::tableName();
        $columnName = self::FIELD_PRE.$this->fd_name;
        if(empty($className) || empty($tableName)) {
            return true;//直接返回
        }
        
        $tableSchema = Yii::$app->db->schema->getTableSchema($tableName);
        //如果有则删除
        if($columnSchema = $tableSchema->getColumn($columnName)) {
            Yii::$app->db->createCommand()->dropColumn($tableName, $columnName)->execute();
        }
        //插入新字段
        $type = self::$fieldTypeList[$this->fd_type]['type'];
        if(!in_array($type, ['text', 'mediumtext', 'filearr'])) {
            if(!empty($this->fd_long) || (empty($this->fd_long) && $this->fd_long == 0)) {
                $type .= '('.$this->fd_long.')';
            }
        }
        
        //var_dump(Yii::$app->db->createCommand()->addColumn($tableName, $columnName, $type)->getRawSql());exit;
        Yii::$app->db->createCommand()
            ->addColumn($tableName, $columnName, $type)
            ->execute();
        
        return true;
    }
    
    /**
     * 删除之前保已经调整了表结构
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::beforeDelete()
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        
        //删除模型中的字段
        $className = Column::ColumnConvert('id2class', $this->fd_column_type);
        //判断自定义模型
        if(strpos($className, 'MasterModel_'.$this->fd_column_type) !== false) {
            $className = str_replace('MasterModel_'.$this->fd_column_type, 'MasterModel', $className);
            $className::$DiyModelId = $this->fd_column_type;
        }
        
        $columnName = self::FIELD_PRE.$this->fd_name;
        if(empty($className)) {
            return true;//直接返回
        }
        $tableName = $className::tableName();

        $tableSchema = Yii::$app->db->schema->getTableSchema($tableName);
        //如果有则删除
        if($columnSchema = $tableSchema->getColumn($columnName)) {
            Yii::$app->db->createCommand()->dropColumn($tableName, $columnName)->execute();
        }
        
        return true;    
    }
    
    public function columnListStr()
    {
        $columns = Column::ColumnListByType($this->fd_column_type);
        $columnNameList = [];
        foreach (explode(',', $this->columnid_list) as $columnid) {
            $columnNameList[$columnid] = isset($columns[$columnid])?$columns[$columnid]:'未定义';
        }
        
        return $columnNameList;
    }
    
    /**
     * 获取字段模型
     * @param integer $columnType 模型id值
     * @param integer $columnid 对应模型生成的栏目id值，如果为null则表示全部栏目，否则为指定栏目字段
     * @return \backend\components\Column[]|array
     */
    public static function FieldModelList($columnType, $columnid = null)
    {
        if(empty(self::$FieldModels)) {
            self::$FieldModels = self::find()->where(['fd_column_type' => $columnType])->orderBy(['orderid' => SORT_DESC])->all();
        }
        $fieldModels = self::$FieldModels;
        if(!empty($columnid)) {
            foreach ($fieldModels as $key => $fieldModel) {
                if(!in_array($columnid, explode(',', $fieldModel->columnid_list))) {
                    unset($fieldModels[$key]);
                }
            }
        }
        
        return $fieldModels;
    }
    
    /**
     * 自定义字段提交，保存之前的验证规则
     * @param Model $model 绑定了自定义字段的模型
     * @param integer $type 返回类型，true：返回规则rule,false：返回消息label
     * @return []
     */
    public static function DiyFieldRule($model, $type = true)
    {
        if(get_class($model) == MasterModel::class) {
            $className = MasterModel::class.'_'.MasterModel::$DiyModelId;
        } else {
            $className = get_class($model);
        }
        $id = Column::ColumnConvert('class2id', $className);
        $fieldModels = DiyField::FieldModelList($id, $model->columnid);//取匹配的活动字段
        
        if($type) {//返回规则
            $rules = [];
            foreach ($fieldModels as $fieldModel) {
                //验证规则对应关系
                switch (trim($fieldModel->fd_check)) {
                    case 'required':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'required'];
                        break;
                    case 'email':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'email'];
                        break;
                    case 'url':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'url'];
                        break;
                    case 'digits':
                    case 'number':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'double'];
                        break;
                    case 'maxlength':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'string', 'max' => $fieldModel->fd_long];
                        break;
                    case 'dateISO':
                    case 'creditcard':
                    case 'isZipCode':
                    case 'isPhone':
                    case 'isDomain':
                        $rules[] = [DiyField::FIELD_PRE.$fieldModel->fd_name, 'safe'];
                        break;
                }
            }
            return $rules;
        }
        
        //不返回规则，则返回标题label
        $labels = [];
        foreach ($fieldModels as $fieldModel) {
            $labels[DiyField::FIELD_PRE.$fieldModel->fd_name] = $fieldModel->fd_title;
        }
        return $labels;
    }
    
    /**
     * 生成diy field验证规则
     * @return array
     */
    public static function DiyFieldRuleClient($model, $diyModel = null)
    {
        $className = get_class($model);
        if(!is_null($diyModel) && get_class($diyModel) == DiyModel::class) {
            $className = MasterModel::class.'_'.$diyModel->dm_id;
        }
        $id = Column::ColumnConvert('class2id', $className);
        $fieldModels = self::FieldModelList($id, $model->columnid);//取匹配的字段
        
        $rules = [];
        $messages = [];
        foreach ($fieldModels as $fieldModel) {
            $attribute = DiyField::FIELD_PRE.$fieldModel->fd_name;
            if(!empty($fieldModel->fd_check)) {
                if($fieldModel->fd_check == 'maxlength' && $fieldModel->fd_long > 0) {
                    $rules[Html::getInputName($model, $attribute)] = [$fieldModel->fd_check => $fieldModel->fd_long];
                } else {
                    $rules[Html::getInputName($model, $attribute)] = [$fieldModel->fd_check => true];
                }
            }
            $messages[Html::getInputName($model, $attribute)] = $fieldModel->fd_tips;
        }
        
        return [
            'rules' => $rules,
            'messages' => $messages,
        ];
    }
    
    /**
     * 验证列表
     * @param string $hasNull
     * @return string[] | empty
     */
    public static function RuleList($key = null, $hasNull = true)
    {
        $rules = [
            'required' => '必填',//true必须输入的字段
            'email' => '邮箱',//true必须输入正确格式的电子邮件
            'url' => '网址',//true必须输入正确格式的网址
            'dateISO' => '日期',//true必须输入正确格式的日期（ISO），例如：2009-06-23，1998/01/22
            'number' => '数字',//true必须输入合法的数字（负数，小数）
            'digits' => '整数',//true必须输入整数
            'creditcard' => '信用卡号',//true必须输入合法的信用卡号
            'maxlength' => '最大长度限制',//5	输入长度最多是 5 的字符串（汉字算一个字符）
            'isZipCode' => '邮政编码',//true必须填写正确的邮政编码
            'isPhone' => '手机号码',//true必须填写正确的手机号码
            'isDomain' => '域名',//true必须填写正确的域名
        ];
        
        $rules = $hasNull?ArrayHelper::merge([null => '常用格式限制'], $rules):$rules;
        
        return is_null($key)?$rules:(isset($rules[$key])?$rules[$key]:'');
    }
    
    /**
     * @inheritdoc
     * @return DiyFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiyFieldQuery(get_called_class());
    }
}
