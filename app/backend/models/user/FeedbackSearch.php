<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\user\Feedback;

/**
 * FeedbackSearch represents the model behind the search form about `backend\models\user\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    //屏蔽Feedback中行为带来的干扰
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_id', 'fk_user_id', 'fk_show', 'fk_type_id', 'fk_retime', 'fk_sms', 'fk_email', 'created_at', 'updated_at'], 'integer'],
            [['fk_nickname', 'fk_contact', 'fk_content', 'fk_ip', 'fk_review', 'lang'], 'safe'],
            ['keyword', 'string'],
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
        
        $query = Feedback::find()->current()->with('feedbackType')->with('user');

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
                    'created_at' => SORT_DESC,
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
            'fk_user_id' => $this->fk_user_id,
            'fk_show' => $this->fk_show,
            'fk_type_id' => $this->fk_type_id,
            'fk_sms' => $this->fk_sms,
            'fk_email' => $this->fk_email,
        ]);

        $query->andFilterWhere(['like', 'fk_nickname', $this->keyword])
            ->andFilterWhere(['like', 'fk_contact', $this->keyword])
            ->andFilterWhere(['like', 'fk_content', $this->keyword])
            ->andFilterWhere(['like', 'fk_ip', $this->keyword])
            ->andFilterWhere(['like', 'fk_review', $this->keyword]);

        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
