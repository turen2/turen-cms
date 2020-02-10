<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\sys;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\sys\Log;

/**
 * LogSearch represents the model behind the search form about `backend\models\sys\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'admin_id'], 'integer'],
            [['username', 'route', 'name', 'method', 'get_data', 'post_data', 'ip', 'agent', 'md5', 'created_at', 'keyword'], 'safe'],
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
        $query = Log::find();

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
                    'log_id' => SORT_DESC,
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
            ['log_id' => $this->log_id],
            ['method' => $this->method]
        ], ['or',
            ['like', 'username', $this->keyword],
            ['like', 'route', $this->keyword],
            ['like', 'name', $this->keyword],
            ['like', 'post_data', $this->keyword],
            ['like', 'ip', $this->keyword],
            ['like', 'agent', $this->keyword],
            ['like', 'ip', $this->keyword],
            ['like', 'get_data', $this->keyword]
        ]]);

//        echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
