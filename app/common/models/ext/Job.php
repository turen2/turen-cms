<?php

namespace common\models\ext;

use Yii;

/**
 * This is the model class for table "{{%ext_job}}".
 *
 * @property string $id 招聘信息id
 * @property string $title 位岗名称
 * @property string $jobplace 工作地点
 * @property string $jobdescription 工作性质
 * @property int $employ 招聘人数
 * @property int $jobsex 性别要求，1为男
 * @property string $treatment 工资待遇
 * @property string $usefullife 有效期
 * @property string $experience 工作经验
 * @property string $education 学历要求
 * @property string $joblang 言语能力
 * @property string $workdesc 职位描述
 * @property string $content 职位要求
 * @property string $orderid 排列排序
 * @property string $posttime 更新时间
 * @property int $status 审核状态
 * @property string $lang
 * @property string $created_at 添加时间
 * @property string $updated_at 编辑时间
 */
class Job extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ext_job}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'jobplace', 'jobdescription', 'employ', 'treatment', 'usefullife', 'experience', 'education', 'joblang', 'workdesc', 'content', 'orderid', 'posttime', 'lang'], 'required'],
            [['employ', 'jobsex', 'orderid', 'posttime', 'status', 'created_at', 'updated_at'], 'integer'],
            [['workdesc', 'content'], 'string'],
            [['title', 'jobdescription', 'treatment', 'usefullife', 'experience', 'joblang'], 'string', 'max' => 50],
            [['jobplace', 'education'], 'string', 'max' => 80],
            [['lang'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '招聘信息id',
            'title' => '位岗名称',
            'jobplace' => '工作地点',
            'jobdescription' => '工作性质',
            'employ' => '招聘人数',
            'jobsex' => '性别要求，1为男',
            'treatment' => '工资待遇',
            'usefullife' => '有效期',
            'experience' => '工作经验',
            'education' => '学历要求',
            'joblang' => '言语能力',
            'workdesc' => '职位描述',
            'content' => '职位要求',
            'orderid' => '排列排序',
            'posttime' => '更新时间',
            'status' => '审核状态',
            'lang' => 'Lang',
            'created_at' => '添加时间',
            'updated_at' => '编辑时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return JobQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JobQuery(get_called_class());
    }
}
