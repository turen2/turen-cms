<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\cms\DiyField;

/**
 * DiyFieldSearch represents the model behind the search form about `backend\models\cms\DiyField`.
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
            [['fd_column_type', 'fd_name', 'fd_title', 'fd_desc', 'fd_type', 'fd_long', 'fd_value', 'fd_check', 'fd_tips', 'keyword'], 'safe'],
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
        
        $query = DiyField::find();

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
        $query->filterWhere(['and', ['and',
            '1 = 1',
            ['id' => $this->id],
            ['status' => $this->status],
            ['fd_type' => $this->fd_type],
            ['fd_column_type' => $this->fd_column_type],
        ], ['or',
            ['like', 'fd_name', $this->keyword],
            ['like', 'fd_title', $this->keyword],
            ['like', 'fd_desc', $this->keyword]
        ]]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
