<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\sys;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sys\Admin;

/**
 * AdminSearch represents the model behind the search form of `app\models\sys\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'nickname', 'question', 'answer', 'phone', 'status'], 'safe'],
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
        $query = Admin::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => Yii::$app->params['config.defaultPageSize'],
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    //'parent_id' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
//             var_dump($this->getErrors());
//             echo $dataProvider->query->createCommand()->rawSql;exit;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->orFilterWhere(['like', 'username', $this->username])
                ->orFilterWhere(['like', 'nickname', $this->nickname])
                ->orFilterWhere(['like', 'question', $this->question])
                ->orFilterWhere(['like', 'answer', $this->answer])
                ->orFilterWhere(['like', 'loginip', $this->loginip])
                ->orFilterWhere(['like', 'phone', $this->phone])
                ->orFilterWhere(['like', 'status', $this->status]);
        
        $query->andFilterWhere([
            
        ]);

        //echo $dataProvider->query->createCommand()->rawSql;exit;
        return $dataProvider;
    }
}
