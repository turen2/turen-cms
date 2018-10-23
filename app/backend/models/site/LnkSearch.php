<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\models\site;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\site\Lnk;

/**
 * LnkSearch represents the model behind the search form about `app\models\site\Lnk`.
 */
class LnkSearch extends Lnk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lnk_id', 'orderid', 'created_at'], 'integer'],
            [['lnk_name', 'lnk_link', 'lnk_ico'], 'string'],
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
        
        $query = Lnk::find();

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
            //'lnk_id' => $this->lnk_id,
        ]);

        $query->andFilterWhere(['like', 'lnk_name', $this->lnk_name])
            ->andFilterWhere(['like', 'lnk_link', $this->lnk_link])
            ->andFilterWhere(['like', 'lnk_ico', $this->lnk_ico]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
