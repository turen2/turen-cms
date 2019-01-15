<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\diy;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\diy\Faqs;

/**
 * FaqsSearch represents the model behind the search form of `common\models\diy\Faqs`.
 */
class FaqsSearch extends Faqs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'parentid', 'cateid', 'catepid', 'status', 'orderid', 'posttime', 'updated_at', 'created_at'], 'integer'],
            [['title', 'slug', 'colorval', 'boldval', 'parentstr', 'catepstr', 'flag', 'picurl', 'lang', 'diyfield_ask_content'], 'safe'],
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
        $query = Faqs::find()->current()->active();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => 5,
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
        if(isset($params['flag']) && !empty($params['flag'])) {
            //传递参数
            $this->flag = $params['flag'];
            $query->andFilterWhere(['like', 'flag', $this->flag]);
        }

        /*
        $query->andFilterWhere([
            'id' => $this->id,
            'columnid' => $this->columnid,
            'parentid' => $this->parentid,
            'cateid' => $this->cateid,
            'catepid' => $this->catepid,
            'status' => $this->status,
            'orderid' => $this->orderid,
            'posttime' => $this->posttime,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'colorval', $this->colorval])
            ->andFilterWhere(['like', 'boldval', $this->boldval])
            ->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'catepstr', $this->catepstr])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'diyfield_ask_content', $this->diyfield_ask_content]);
        */

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
