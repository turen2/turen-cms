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
use app\models\cms\File;

/**
 * FileSearch represents the model behind the search form about `app\models\cms\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'deltime'], 'integer'],
            [['parentstr', 'catepstr', 'title', 'colorval', 'boldval', 'flag', 'source', 'author', 'filetype', 'filesize', 'website', 'demourl', 'dlurl', 'linkurl', 'keywords', 'keyword', 'description', 'content', 'picurl', 'picarr', 'status', 'delstate', 'lang', 'posttime', 'keyword'], 'safe'],
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
            'columnid' => $this->columnid,
            'parentid' => $this->parentid,
            'cateid' => $this->cateid,
            'catepid' => $this->catepid,
            'hits' => $this->hits,
            'delstate' => $this->delstate,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'demourl', $this->demourl])
            ->andFilterWhere(['like', 'dlurl', $this->dlurl])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
