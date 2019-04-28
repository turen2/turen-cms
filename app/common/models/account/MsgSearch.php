<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\account;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\account\Msg;

/**
 * MsgSearch represents the model behind the search form of `common\models\account\Msg`.
 */
class MsgSearch extends Msg
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['msg_id', 'msg_type', 'msg_user_id', 'msg_readtime', 'msg_deltime', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['msg_content', 'lang'], 'safe'],
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
        $query = Msg::find()->current();

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
            'msg_id' => $this->msg_id,
            'msg_type' => $this->msg_type,
            'msg_user_id' => Yii::$app->getUser()->getId(),
            'msg_deltime' => 0,//只获取未删除的
        ]);

        $query->andFilterWhere(['like', 'msg_content', $this->msg_content]);

        return $dataProvider;
    }
}
