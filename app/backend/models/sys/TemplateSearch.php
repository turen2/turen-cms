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
use app\models\sys\Template;

/**
 * TemplateSearch represents the model behind the search form about `app\models\sys\Template`.
 */
class TemplateSearch extends Template
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['temp_id', 'posttime', 'created_at', 'updated_at'], 'integer'],
            [['temp_name', 'temp_code', 'open_cate', 'picurl', 'picarr', 'developer_name', 'design_name', 'note', 'langs', 'default_lang'], 'safe'],
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
        
        $query = Template::find();

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
                    //'parent_id' => SORT_ASC,
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
        $query->andFilterWhere(['like', 'default_lang', $this->default_lang]);

        $query->andFilterWhere(['like', 'temp_name', $this->temp_name])
            ->andFilterWhere(['like', 'temp_code', $this->temp_code])
            ->andFilterWhere(['like', 'open_cate', $this->open_cate])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'developer_name', $this->developer_name])
            ->andFilterWhere(['like', 'design_name', $this->design_name])
            ->andFilterWhere(['like', 'langs', $this->langs]);
        
//         echo $dataProvider->query->createCommand()->rawSql;exit;

        return $dataProvider;
    }
}
