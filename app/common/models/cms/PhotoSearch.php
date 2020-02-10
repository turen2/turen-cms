<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\cms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\Photo;

/**
 * PhotoSearch represents the model behind the search form of `common\models\cms\Photo`.
 */
class PhotoSearch extends Photo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'columnid', 'parentid', 'cateid', 'catepid', 'hits', 'orderid', 'posttime', 'status', 'delstate', 'deltime', 'created_at', 'updated_at'], 'integer'],
            [['parentstr', 'catepstr', 'title', 'slug', 'colorval', 'boldval', 'flag', 'source', 'author', 'linkurl', 'keywords', 'description', 'content', 'picurl', 'picarr', 'lang'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params, $pageSize, $columnId = null)
    {
        $query = Photo::find()->current();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => $pageSize,//一大单元为27个元素，ajax请求每3次为一个单元
            ],
            'sort' => [
                //'class' => Sort::class,
                'enableMultiSort' => true,
                'defaultOrder' => [
                    'posttime' => SORT_DESC,
                    'hits' => SORT_ASC,
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
            'columnid' => $columnId,
            /*
            'parentid' => $this->parentid,
            'cateid' => $this->cateid,
            'catepid' => $this->catepid,
            'hits' => $this->hits,
            'orderid' => $this->orderid,
            'posttime' => $this->posttime,
            'status' => $this->status,
            'delstate' => $this->delstate,
            'deltime' => $this->deltime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            */
        ]);

        /*
        $query->andFilterWhere(['like', 'parentstr', $this->parentstr])
            ->andFilterWhere(['like', 'catepstr', $this->catepstr])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'colorval', $this->colorval])
            ->andFilterWhere(['like', 'boldval', $this->boldval])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'picurl', $this->picurl])
            ->andFilterWhere(['like', 'picarr', $this->picarr])
            ->andFilterWhere(['like', 'lang', $this->lang]);
        */

//        echo $dataProvider->query->createCommand()->getRawSql();exit;
//        echo $dataProvider->query->createCommand()->rawSql;exit;

        return $dataProvider;
    }
}
