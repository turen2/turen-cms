<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use Yii;
use yii\base\Model;
use common\models\user\User;

/**
 * Company form
 */
class CompanyForm extends Model
{
    public $company_name;//公司名称
    public $company;//公司营业执照

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['company_name', 'company'], 'required'],
            [['company_name', 'company'], 'string'],
        ];

        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'company_name' => '公司名称',
            'company' => '公司营业执照',
        ];

        return $labels;
    }
}