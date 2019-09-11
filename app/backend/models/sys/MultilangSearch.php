<?php

namespace app\models\sys;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sys\Multilang;

/**
 * MultilangSearch represents the model behind the search form about `app\models\sys\Multilang`.
 */
class MultilangSearch extends Multilang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'back_default', 'front_default', 'is_visible', 'orderid'], 'integer'],
            [['lang_sign', 'key', 'keyword'], 'safe'],
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
        
        $query = Multilang::find();

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
            'back_default' => $this->back_default,
            'front_default' => $this->front_default,
            'is_visible' => $this->is_visible,
        ]);

        $query->andFilterWhere(['like', 'lang_sign', $this->lang_sign])
            ->andFilterWhere(['like', 'key', $this->key]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}