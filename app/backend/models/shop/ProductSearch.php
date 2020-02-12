<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\shop;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shop\Product;

/**
 * ProductSearch represents the model behind the search form about `backend\models\shop\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'pcateid', 'brand_id', 'promote_start_date', 'promote_end_date', 'stock', 'base_hits', 'hits', 'orderid', 'posttime', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['attrtext', 'title', 'colorval', 'boldval', 'subtitle', 'keywords', 'description', 'flag', 'sku', 'product_sn', 'weight', 'is_promote', 'is_shipping', 'linkurl', 'content', 'picurl', 'picarr', 'is_best', 'is_new', 'is_hot', 'status', 'delstate', 'author', 'keyword', 'slug'], 'safe'],
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
        $query = Product::find();

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
        $query->filterWhere(['and', ['and',
            '1 = 1',
            ['lang' => GLOBAL_LANG],
            ['delstate' => Product::IS_NOT_DEL],
            ['id' => $this->id],
            ['columnid' => $this->columnid],
            ['pcateid' => $this->pcateid],
            ['brand_id' => $this->brand_id],
            ['is_best' => $this->is_best],
            ['is_new' => $this->is_new],
            ['is_hot' => $this->is_hot],
            ['is_promote' => $this->is_promote],
            ['is_shipping' => $this->is_shipping],
            ['status' => $this->status],
            ['author' => $this->author],
            ['like', 'flag', $this->flag]
        ], ['or',
            ['like', 'title', $this->keyword],
            ['like', 'slug', $this->keyword],
            ['like', 'subtitle', $this->keyword],
            ['like', 'keywords', $this->keyword],
            ['like', 'sku', $this->keyword],
            ['like', 'product_sn', $this->keyword],
            ['like', 'title', $this->keyword],
            ['like', 'title', $this->keyword],
            ['like', 'slug', $this->keyword],
            ['like', 'linkurl', $this->keyword]
        ]]);
        
//         echo $dataProvider->query->createCommand()->rawSql;exit;
        
        return $dataProvider;
    }
}
