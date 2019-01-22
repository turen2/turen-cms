<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\ext;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ext\AdType;

/**
 * AdTypeSearch represents the model behind the search form of `common\models\ext\AdType`.
 */
class AdTypeSearch extends AdType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parentid', 'width', 'height', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['parentstr', 'typename', 'lang'], 'safe'],
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
        $query = AdType::find();

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
            'parentid' => $this->parentid,
            'width' => $this->width,
            'height' => $this->height,
            'orderid' => $this->orderid,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'typename', $this->typename])
            ->andFilterWhere(['like', 'lang', $this->lang]);

        return $dataProvider;
    }
}
