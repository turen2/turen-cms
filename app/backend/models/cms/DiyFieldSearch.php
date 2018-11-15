<?php

namespace app\models\cms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cms\DiyField;

/**
 * DiyFieldSearch represents the model behind the search form about `app\models\cms\DiyField`.
 */
class DiyFieldSearch extends DiyField
{
    public $columnid;//用于搜索过滤器
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid_list', 'orderid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['fd_column_type', 'fd_name', 'fd_title', 'fd_desc', 'fd_type', 'fd_long', 'fd_value', 'fd_check', 'fd_tips'], 'safe'],
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
        
        $query = DiyField::find();//->current();

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
            'status' => $this->status,
            'fd_type' => $this->fd_type,
            'fd_column_type' => $this->fd_column_type,
        ]);

        $query->andFilterWhere(['like', 'fd_name', $this->fd_name])
            ->andFilterWhere(['like', 'fd_title', $this->fd_title])
            ->andFilterWhere(['like', 'fd_desc', $this->fd_desc])
            ->andFilterWhere(['like', 'fd_value', $this->fd_value])
            ->andFilterWhere(['like', 'fd_check', $this->fd_check])
            //->andFilterWhere(['like', 'columnid_list', $this->columnid.','])//??不精准
            ->andFilterWhere(['like', 'fd_tips', $this->fd_tips]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
