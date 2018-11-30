<?php

namespace app\models\tool;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tool\NotifyFrom;

/**
 * NotifyFromSearch represents the model behind the search form about `app\models\tool\NotifyFrom`.
 */
class NotifyFromSearch extends NotifyFrom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fr_id', 'fr_is_default'], 'integer'],
            [['fr_title', 'fr_comment', 'keyword'], 'safe'],
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
        
        $query = NotifyFrom::find();//->current();

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
                    'fr_title' => SORT_DESC,
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
            'fr_id' => $this->fr_id,
            'fr_is_default' => $this->fr_is_default,
        ]);
        
        $query->andFilterWhere(['or',
            ['like', 'fr_title', $this->keyword],
            ['like', 'fr_comment', $this->keyword]
        ]);

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
