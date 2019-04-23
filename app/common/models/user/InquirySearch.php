<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InquirySearch represents the model behind the search form about `app\models\user\Inquiry`.
 */
class InquirySearch extends Inquiry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ui_id', 'user_id', 'ui_type', 'ui_state', 'ui_submit_time', 'ui_answer_time', 'ui_remark_time'], 'integer'],
            [['ui_title', 'ui_content', 'ui_ipaddress', 'ui_browser', 'ui_answer', 'ui_remark', 'keyword'], 'safe'],
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
        $query = Inquiry::find()->alias('i')->select(['i.*', 'u.username as username'])->leftJoin(User::tableName().' as u', ' i.user_id = u.user_id');
        //$query = Inquiry::find();//->current();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => 8,
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    'ui_submit_time' => SORT_DESC,
                ],
            ],
        ]);

        $data = [];
        $data[$this->formName()]['ui_state'] = isset($params['state'])?$params['state']:null;
        $this->load($data);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ui_id' => $this->ui_id,
            'ui_type' => $this->ui_type,
            'ui_state' => $this->ui_state,
        ]);

        $query->andFilterWhere(['like', 'ui_title', $this->keyword])
            ->orFilterWhere(['like', 'ui_content', $this->keyword])
            ->orFilterWhere(['like', 'ui_ipaddress', $this->keyword])
            ->orFilterWhere(['like', 'ui_browser', $this->keyword])
            ->orFilterWhere(['like', 'ui_answer', $this->keyword])
            ->orFilterWhere(['like', 'ui_remark', $this->keyword]);

//        echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
