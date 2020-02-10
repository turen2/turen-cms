<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\cms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cms\Article;

/**
 * ArticleSearch represents the model behind the search form about `app\models\cms\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'deltime'], 'integer'],
            [['parentstr', 'catepstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'linkurl', 'keywords', 'keyword', 'description', 'content', 'picurl', 'picarr', 'status', 'delstate', 'lang', 'posttime', 'keyword', 'slug'], 'safe'],
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
        
        $query = Article::find();

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
        // $query->filterWhere(['and', ['and', ['type' => 2], ['like', 'name', 'tester']], ['or', ['like', 'name1', 't1'], ['like', 'name2', 't2']]]);
        $query->filterWhere(['and', ['and',
            '1 = 1',
            ['lang' => GLOBAL_LANG],
            ['delstate' => Article::IS_NOT_DEL],
            ['id' => $this->id],
            ['columnid' => $this->columnid],
            ['cateid' => $this->cateid],
            ['status' => $this->status],
            ['author' => $this->author],
            ['like', 'flag', $this->flag]
        ], ['or',
            ['like', 'title', $this->keyword],
            ['like', 'slug', $this->keyword],
            ['like', 'linkurl', $this->keyword]
        ]]);
        
        // echo $dataProvider->query->createCommand()->rawSql;exit;

        return $dataProvider;
    }
}
