<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\ext;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ext\Link;

/**
 * LinkSearch represents the model behind the search form about `app\models\ext\Link`.
 */
class LinkSearch extends Link
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'link_type_id', 'parentid', 'orderid'], 'integer'],
            [['parentstr', 'webname', 'webnote', 'picurl', 'linkurl', 'status', 'lang', 'posttime'], 'safe'],
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
        
        $query = Link::find()->current();

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
                    'posttime' => SORT_DESC,
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
            
            'link_type_id' => $this->link_type_id,
            'parentid' => $this->parentid,
            'orderid' => $this->orderid,
        ]);

        $query->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'webname', $this->webname])
            ->andFilterWhere(['like', 'webnote', $this->webnote])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'lang', $this->lang]);
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
