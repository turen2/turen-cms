<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\tool;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tool\NotifyContent;

/**
 * NotifyContentSearch represents the model behind the search form about `app\models\tool\NotifyContent`.
 */
class NotifyContentSearch extends NotifyContent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nc_id', 'nc_status', 'created_at', 'updated_at'], 'integer'],
            [['nc_title', 'nc_notify_content', 'nc_notify_data', 'nc_email_content', 'nc_email_data', 'nc_sms_tcode', 'nc_sms_data', 'nc_sms_sign', 'nc_sms_ext', 'nc_sms_outid', 'keyword'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
    	//$sql = "select a.*, s.company as company, s.domain as domain, s.username as merchant from ".Admin::tableName()." as a left join ".Site::tableName()." as s on a.test_id = s.testid";
        //$query = Admin::findBySql($sql);
        //$query = Admin::find()->alias('a')->select(['a.*', 's.company as company', 's.domain as domain', 's.username as merchant'])->leftJoin(Site::tableName().' as s', ' a.test_id = s.testid');
        
        $query = NotifyContent::find();//->current();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => Yii::$app->params['config_page_size'],
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    'orderid' => SORT_DESC,
                    'updated_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'nc_id' => $this->nc_id,
            'nc_status' => $this->nc_status,
        ]);
        
        $query->andFilterWhere(['or',
            ['like', 'nc_title', $this->keyword],
            ['like', 'nc_notify_content', $this->keyword],
            ['like', 'nc_notify_data', $this->keyword],
            ['like', 'nc_email_content', $this->keyword],
            ['like', 'nc_email_data', $this->keyword],
            ['like', 'nc_sms_tcode', $this->keyword],
            ['like', 'nc_sms_data', $this->keyword],
            ['like', 'nc_sms_sign', $this->keyword],
            ['like', 'nc_sms_ext', $this->keyword],
            ['like', 'nc_sms_outid', $this->keyword],
        ]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
