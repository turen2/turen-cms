<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\UserComment;

/**
 * UserCommentSearch represents the model behind the search form about `app\models\user\UserComment`.
 */
class UserCommentSearch extends UserComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uc_id', 'uc_pid', 'uc_model_id', 'uid', 'status', 'reply_time', 'created_at'], 'integer'],
            [['uc_class_name', 'username', 'uc_note', 'uc_reply', 'uc_link', 'uc_ip', 'lang'], 'safe'],
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
        
        $query = UserComment::find()->current();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => Yii::$app->params['config_page_size'],//'defaultPageSize' => 300,//一次性全部查出
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'reply_time' => SORT_DESC,
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
            'uc_id' => $this->uc_id,
            'uc_pid' => $this->uc_pid,
            'uc_model_id' => $this->uc_model_id,
            'uid' => $this->uid,
            'status' => $this->status,
            'reply_time' => $this->reply_time,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'uc_class_name', $this->uc_class_name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'uc_note', $this->uc_note])
            ->andFilterWhere(['like', 'uc_reply', $this->uc_reply])
            ->andFilterWhere(['like', 'uc_link', $this->uc_link])
            ->andFilterWhere(['like', 'uc_ip', $this->uc_ip])
            ->andFilterWhere(['like', 'lang', $this->lang]);
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
