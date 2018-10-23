<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\UserFavorite;

/**
 * UserFavoriteSearch represents the model behind the search form about `app\models\user\UserFavorite`.
 */
class UserFavoriteSearch extends UserFavorite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ufid', 'uf_model_id', 'uid', 'uf_star', 'created_at'], 'integer'],
            [['uf_class_name', 'uf_data', 'uf_link', 'uf_ip', 'lang'], 'safe'],
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
        
        $query = UserFavorite::find();//->current();

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
                    //'orderid' => SORT_DESC,
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
            'ufid' => $this->ufid,
            'uf_model_id' => $this->uf_model_id,
            'uid' => $this->uid,
            'uf_star' => $this->uf_star,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'uf_class_name', $this->uf_class_name])
            ->andFilterWhere(['like', 'uf_data', $this->uf_data])
            ->andFilterWhere(['like', 'uf_link', $this->uf_link])
            ->andFilterWhere(['like', 'uf_ip', $this->uf_ip])
            ->andFilterWhere(['like', 'lang', $this->lang]);
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
