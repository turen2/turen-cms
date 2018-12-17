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
use app\models\tool\NotifySmsQueue;

/**
 * NotifySmsQueueSearch represents the model behind the search form about `app\models\tool\NotifySmsQueue`.
 */
class NotifySmsQueueSearch extends NotifySmsQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nq_sms_id', 'nq_nu_id', 'nq_ng_id', 'nq_user_id', 'nq_phone', 'nq_sms_send_time', 'nq_sms_arrive_time'], 'integer'],
            [['keyword'], 'safe'],
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
        
        $query = NotifySmsQueue::find()->with('notifyGroup', 'notifyUser');//->current();

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
                    'nq_sms_id' => SORT_ASC,
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
            'nq_sms_id' => $this->nq_sms_id,
            'nq_nu_id' => $this->nq_nu_id,
            'nq_ng_id' => $this->nq_ng_id,
            'nq_user_id' => $this->nq_user_id,
            //nq_phone//like
        ]);
        
//         'nq_email_send_time' => $this->nq_email_send_time,
//         'nq_email_arrive_time' => $this->nq_email_arrive_time,
//         'nq_notify_send_time' => $this->nq_notify_send_time,
//         'nq_notify_arrive_time' => $this->nq_notify_arrive_time,
//         'nq_sms_send_time' => $this->nq_sms_send_time,
//         'nq_sms_arrive_time' => $this->nq_sms_arrive_time,
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
