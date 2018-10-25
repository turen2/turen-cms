<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\User;

/**
 * UserSearch represents the model behind the search form about `app\models\user\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'level_id', 'ug_id', 'sex', 'point', 'reg_time', 'login_time', 'status', 'deltime', 'delstate'], 'integer'],
            [['username', 'email', 'mobile', 'password', 'avatar', 'company', 'trade', 'license', 'telephone', 'intro', 'address_prov', 'address_city', 'address_country', 'address', 'zipcode', 'reg_ip', 'login_ip', 'qq_id', 'weibo_id', 'wx_id'], 'safe'],
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
        
        $query = User::find()->delstate(User::IS_NOT_DEL)->with('group', 'level');

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
                    'login_time' => SORT_DESC,
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
            'user_id' => $this->user_id,
            'level_id' => $this->level_id,
            'ug_id' => $this->ug_id,
            'sex' => $this->sex,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'trade', $this->trade])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'address_prov', $this->address_prov])
            ->andFilterWhere(['like', 'address_city', $this->address_city])
            ->andFilterWhere(['like', 'address_country', $this->address_country])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'reg_ip', $this->reg_ip])
            ->andFilterWhere(['like', 'login_ip', $this->login_ip])
            ->andFilterWhere(['like', 'qq_id', $this->qq_id])
            ->andFilterWhere(['like', 'weibo_id', $this->weibo_id])
            ->andFilterWhere(['like', 'wx_id', $this->wx_id]);
        
//         echo $dataProvider->query->createCommand()->rawSql;exit;

        return $dataProvider;
    }
}
