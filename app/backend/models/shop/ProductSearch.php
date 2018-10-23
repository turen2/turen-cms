<?php

namespace app\models\shop;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\shop\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\shop\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'pcateid', 'brand_id', 'promote_start_date', 'promote_end_date', 'stock', 'hits', 'orderid', 'posttime', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['attrtext', 'title', 'colorval', 'boldval', 'subtitle', 'keywords', 'description', 'flag', 'sku', 'product_sn', 'weight', 'is_promote', 'is_shipping', 'linkurl', 'content', 'picurl', 'picarr', 'is_best', 'is_new', 'is_hot', 'status', 'delstate'], 'safe'],
            [['market_price', 'sales_price', 'promote_price'], 'number'],
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
        
        $query = Product::find();//->current();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => Yii::$app->params['config_page_size'],//'defaultPageSize' => 300,//一次性全部查出
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
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
            'id' => $this->id,
            'columnid' => $this->columnid,
            'pcateid' => $this->pcateid,
            'brand_id' => $this->brand_id,
            'is_best' => $this->is_best,
            'is_new' => $this->is_new,
            'is_hot' => $this->is_hot,
            'status' => $this->status,
            'delstate' => $this->delstate,
            'is_promote' => $this->is_promote,
            'is_shipping' => $this->is_shipping,
            'delstate' => $this->delstate,
            'author' => $this->author,
        ]);
        
        //'promote_start_date' => $this->promote_start_date,
        //'promote_end_date' => $this->promote_end_date,
        //->andFilterWhere(['like', 'flag', $this->flag])
        
        $query->andFilterWhere(['like', 'attrtext', $this->attrtext])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'product_sn', $this->product_sn])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'content', $this->content]);
        
//         echo $dataProvider->query->createCommand()->rawSql;
//         exit;
        
        return $dataProvider;
    }
}
