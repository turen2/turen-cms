<?php

namespace app\models\cms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\InsertLangBehavior;

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
 * @property string $lang 多语言
 * @property string $orderid 排列排序
 * @property int $status 是否生效
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class DiyField extends \app\models\base\Cms
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
	
	public function behaviors()
	{
	    return [
	        'timemap' => [
	            'class' => TimestampBehavior::class,
	            'createdAtAttribute' => 'created_at',
	            'updatedAtAttribute' => 'updated_at'
	        ],
	        'insertLang' => [//自动填充多站点和多语言
	            'class' => InsertLangBehavior::class,
	            'insertLangAttribute' => 'lang',
	        ],
	        'defaultOrderid' => [
	            'class' => AttributeBehavior::class,
	            'attributes' => [
	                ActiveRecord::EVENT_BEFORE_INSERT => 'orderid',
	                //ActiveRecord::EVENT_BEFORE_UPDATE => 'attribute2',
	            ],
	            'value' => function ($event) {
	            	if(empty($this->orderid)) {
        	            $maxModel = self::find()->current()->orderBy(['orderid' => SORT_DESC])->one();
        	            if($maxModel) {
        	                return $maxModel->orderid + 1;
        	            } else {
        	                return Yii::$app->params['config.orderid'];//配置默认值
        	            }
    	            }
    	            
    	            return $this->orderid;
	            }
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
            [['fd_column_type', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['lang', 'fd_name', 'fd_title', 'fd_type', 'fd_tips', 'fd_long', 'fd_desc', 'fd_value', 'fd_check'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_ON],
            [['columnid_list'], 'safe'],
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
            'fd_check' => '校验正则',
            'fd_tips' => '未通过提示',
            'lang' => '多语言',
            'orderid' => '排列排序',
            'status' => '是否生效',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }
    
    /**
     * 插入之前整理，且通过过滤器
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
    
    public function afterDelete()
    {
        parent::afterDelete();
        
        //删除模型中的字段
        $className = Column::ColumnConvert('id2class', $this->fd_column_type);
        $columnName = self::FIELD_PRE.$this->fd_name;
        $tableName = $className::tableName();
        if(empty($className)) {
            return;//直接返回
        }
        
        $tableSchema = Yii::$app->db->schema->getTableSchema($tableName);
        //如果有则删除
        if($columnSchema = $tableSchema->getColumn($columnName)) {
            Yii::$app->db->createCommand()->dropColumn($tableName, $columnName)->execute();
        }
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        //增加或删除模型中的字段
        $className = Column::ColumnConvert('id2class', $this->fd_column_type);
        $columnName = self::FIELD_PRE.$this->fd_name;
        $tableName = $className::tableName();
        if(empty($className)) {
            return;//直接返回
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
    }
    
    /**
     * 生成diy field验证规则
     * @return array
     */
    public function diyFieldrules()
    {
        return [];
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
