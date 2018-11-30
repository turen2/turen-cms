<?php

namespace app\models\shop;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\shop\ProductCate;

/**
 * ProductCateSearch represents the model behind the search form about `app\models\shop\ProductCate`.
 */
class ProductCateSearch extends ProductCate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parentid', 'orderid', 'created_at', 'updated_at'], 'integer'],
            [['parentstr', 'cname', 'ctext', 'picurl', 'linkurl', 'status', 'lang', 'keyword'], 'safe'],
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
        
        $query = ProductCate::find()->current();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => 300,//一次性全部查出
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
            'parentid' => $this->parentid,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'cname', $this->cname])
            ->andFilterWhere(['like', 'ctext', $this->ctext])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
