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
use backend\models\cms\File;

/**
 * FileSearch represents the model behind the search form about `backend\models\cms\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'parentid', 'cateid', 'catepid', 'base_hits', 'hits', 'orderid', 'deltime'], 'integer'],
            [['parentstr', 'catepstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'filetype', 'filesize', 'website', 'demourl', 'dlurl', 'linkurl', 'keywords', 'keyword', 'description', 'content', 'picurl', 'picarr', 'status', 'delstate', 'lang', 'posttime', 'keyword', 'slug'], 'safe'],
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
        $query = File::find()->current()->delstate(File::IS_NOT_DEL);

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

        //清空behaviors行为
        $this->detachBehavior('columnParent');
        
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
            ['delstate' => File::IS_NOT_DEL],
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

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
