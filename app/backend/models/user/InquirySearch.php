<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\Inquiry;

/**
 * InquirySearch represents the model behind the search form about `app\models\user\Inquiry`.
 */
class InquirySearch extends Inquiry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ui_id', 'user_id', 'ui_type', 'ui_state', 'ui_submit_time', 'ui_answer_time', 'ui_remark_time'], 'integer'],
            [['ui_title', 'ui_content', 'ui_ipaddress', 'ui_browser', 'ui_answer', 'ui_remark'], 'safe'],
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
        
        $query = Inquiry::find();//->current();

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
                    'ui_submit_time' => SORT_DESC,
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
            'ui_id' => $this->ui_id,
            'ui_type' => $this->ui_type,
            'ui_state' => $this->ui_state,
        ]);

        $query->andFilterWhere(['like', 'ui_title', $this->ui_title])
            ->andFilterWhere(['like', 'ui_content', $this->ui_content])
            ->andFilterWhere(['like', 'ui_ipaddress', $this->ui_ipaddress])
            ->andFilterWhere(['like', 'ui_browser', $this->ui_browser])
            ->andFilterWhere(['like', 'ui_answer', $this->ui_answer])
            ->andFilterWhere(['like', 'ui_remark', $this->ui_remark]);

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
