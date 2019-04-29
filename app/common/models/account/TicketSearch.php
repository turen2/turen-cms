<?php

namespace common\models\account;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TicketSearch represents the model behind the search form of `common\models\user\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['t_id', 't_relate_id', 't_user_id', 't_status', 't_star', 't_is_finish', 'finished_at', 'created_at', 'udpated_at'], 'integer'],
            [['t_ticket_num', 't_title', 't_content', 't_phone', 't_email', 't_finish_comment', 'lang'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Ticket::find()->current();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => 10,
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
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
            't_id' => $this->t_id,
            't_relate_id' => $this->t_relate_id,
            't_status' => $this->t_status,
            't_star' => $this->t_star,
            't_is_finish' => $this->t_is_finish,
            't_user_id' => Yii::$app->getUser()->getId(),
        ]);

        $query->andFilterWhere(['like', 't_ticket_num', $this->t_ticket_num])
            ->andFilterWhere(['like', 't_title', $this->t_title])
            ->andFilterWhere(['like', 't_content', $this->t_content])
            ->andFilterWhere(['like', 't_phone', $this->t_phone])
            ->andFilterWhere(['like', 't_email', $this->t_email])
            ->andFilterWhere(['like', 't_finish_comment', $this->t_finish_comment]);

//        echo $query->createCommand()->getRawSql();exit;

        return $dataProvider;
    }
}
