<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\FeedbackType;

/**
 * FeedbackTypeSearch represents the model behind the search form about `app\models\user\FeedbackType`.
 */
class FeedbackTypeSearch extends FeedbackType
{
    //屏蔽FeedbackType中行为带来的干扰
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fkt_id', 'fkt_form_show', 'fkt_list_show', 'status', 'is_default', 'created_at', 'updated_at'], 'integer'],
            [['fkt_form_name', 'fkt_list_name', 'lang'], 'safe'],
            [['keyword'], 'string'],
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
        
        $query = FeedbackType::find()->current();

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
            'fkt_form_show' => $this->fkt_form_show,
            'fkt_list_show' => $this->fkt_list_show,
            'status' => $this->status,
            'is_default' => $this->is_default,
        ]);

        $query->andFilterWhere(['like', 'fkt_form_name', $this->keyword])
            ->andFilterWhere(['like', 'fkt_list_name', $this->keyword]);

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
