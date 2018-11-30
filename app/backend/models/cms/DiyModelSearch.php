<?php

namespace app\models\cms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cms\DiyModel;

/**
 * DiyModelSearch represents the model behind the search form about `app\models\cms\DiyModel`.
 */
class DiyModelSearch extends DiyModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_id', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['dm_title', 'dm_name', 'dm_tbname', 'keyword'], 'safe'],
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
        
        $query = DiyModel::find();//->current();

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
            'dm_id' => $this->dm_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'dm_title', $this->dm_title])
            ->andFilterWhere(['like', 'dm_name', $this->dm_name])
            ->andFilterWhere(['like', 'dm_tbname', $this->dm_tbname]);
        
        return $dataProvider;
    }
}
