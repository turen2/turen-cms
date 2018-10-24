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
            [['uf_id', 'uf_model_id', 'uid', 'uf_star', 'created_at'], 'integer'],
            [['uf_typeid', 'uf_data', 'uf_link', 'uf_ip', 'lang'], 'safe'],
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
        
        $query = UserFavorite::find()->with('user')->current();

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
            'uf_id' => $this->uf_id,
            'uf_model_id' => $this->uf_model_id,
            'uid' => $this->uid,
            'uf_star' => $this->uf_star,
            'uf_typeid' => $this->uf_typeid,
        ]);

        $query->andFilterWhere(['like', 'uf_data', $this->uf_data])
            ->andFilterWhere(['like', 'uf_link', $this->uf_link])
            ->andFilterWhere(['like', 'uf_ip', $this->uf_ip]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
