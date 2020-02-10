<?php

namespace common\models\shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shop\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\shop\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'pcateid', 'pcatepid', 'brand_id', 'is_promote', 'promote_start_date', 'promote_end_date', 'stock', 'warn_num', 'is_shipping', 'point', 'is_best', 'is_new', 'is_hot', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['pcatepstr', 'attrtext', 'title', 'slug', 'colorval', 'boldval', 'subtitle', 'keywords', 'description', 'flag', 'sku', 'product_sn', 'linkurl', 'content', 'picurl', 'picarr', 'author', 'lang', 'diyfield_service_item', 'diyfield_service_price'], 'safe'],
            [['weight', 'market_price', 'sales_price', 'promote_price'], 'number'],
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
    public function search($params, $columnId = null)
    {
        $query = Product::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => 18,
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
            'columnid' => $columnId,
            'is_best' => $this->is_best,
            'is_new' => $this->is_new,
            'is_hot' => $this->is_hot,
            'hits' => $this->hits,
        ]);

            /*
            'pcateid' => $this->pcateid,
            'pcatepid' => $this->pcatepid,
            'brand_id' => $this->brand_id,
            'weight' => $this->weight,
            'market_price' => $this->market_price,
            'sales_price' => $this->sales_price,
            'is_promote' => $this->is_promote,
            'promote_price' => $this->promote_price,
            'promote_start_date' => $this->promote_start_date,
            'promote_end_date' => $this->promote_end_date,
            'stock' => $this->stock,
            'warn_num' => $this->warn_num,
            'is_shipping' => $this->is_shipping,
            'point' => $this->point,
            'orderid' => $this->orderid,
            'posttime' => $this->posttime,
            'status' => $this->status,
            'delstate' => $this->delstate,
            'deltime' => $this->deltime,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'pcatepstr', $this->pcatepstr])
            ->andFilterWhere(['like', 'attrtext', $this->attrtext])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'colorval', $this->colorval])
            ->andFilterWhere(['like', 'boldval', $this->boldval])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'product_sn', $this->product_sn])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'picarr', $this->picarr])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'diyfield_service_item', $this->diyfield_service_item])
            ->andFilterWhere(['like', 'diyfield_service_price', $this->diyfield_service_price]);
            */

        return $dataProvider;
    }
}
