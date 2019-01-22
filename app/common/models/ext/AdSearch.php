<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\ext;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ext\Ad;

/**
 * AdSearch represents the model behind the search form of `common\models\ext\Ad`.
 */
class AdSearch extends Ad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ad_type_id', 'parentid', 'orderid', 'posttime', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr', 'title', 'admode', 'picurl', 'adtext', 'linkurl', 'lang'], 'safe'],
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
        $query = Ad::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ad_type_id' => $this->ad_type_id,
            'parentid' => $this->parentid,
            'orderid' => $this->orderid,
            'posttime' => $this->posttime,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'admode', $this->admode])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'adtext', $this->adtext])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
