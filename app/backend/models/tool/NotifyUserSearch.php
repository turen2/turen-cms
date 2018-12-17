<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\models\tool;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tool\NotifyUser;

/**
 * NotifyUserSearch represents the model behind the search form about `app\models\tool\NotifyUser`.
 */
class NotifyUserSearch extends NotifyUser
{
    
    public $nu_last_order_s_time;
    public $nu_last_order_e_time;
    public $nu_last_send_s_time;
    public $nu_last_send_e_time;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nu_id', 'nu_userid', 'nu_fr_id', 'nu_reg_time', 'nu_star', 'nu_is_sms_white', 'nu_is_notify_white', 'nu_is_email_white'], 'integer'],
            [['nu_username', 'nu_realname', 'nu_phone', 'nu_email', 'nu_comment', 'nu_province', 'nu_city', 'nu_area', 'keyword', 'nu_last_login_time', 'nu_last_order_time', 'nu_last_send_time', 'created_at', 'updated_at', 'keyword'], 'safe'],
            [['nu_order_total'], 'number'],
            
            [['nu_last_order_s_time', 'nu_last_order_e_time', 'nu_last_send_s_time', 'nu_last_send_e_time'], 'safe'],
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
    public function search($params, $limit = null)
    {
    	//$sql = "select a.*, s.company as company, s.domain as domain, s.username as merchant from ".Admin::tableName()." as a left join ".Site::tableName()." as s on a.test_id = s.testid";
        //$query = Admin::findBySql($sql);
        //$query = Admin::find()->alias('a')->select(['a.*', 's.company as company', 's.domain as domain', 's.username as merchant'])->leftJoin(Site::tableName().' as s', ' a.test_id = s.testid');
        
//         $query = Post::find()->joinWith('cate');
//         $post = $query->orderBy(['post.id' => SORT_DESC])->asArray()->where(['post.status' => 1]);
//         $post->andFilterWhere(['like', 'post.title', $key])->orFilterWhere(['like', 'post.content', $key]);
        
        $query = NotifyUser::find();//->current();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => empty($limit)?Yii::$app->params['config_page_size']:$limit,
                'pageSizeLimit' => [1, empty($limit)?50:$limit],
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    //'orderid' => SORT_DESC,
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
            'nu_id' => $this->nu_id,
            'nu_userid' => $this->nu_userid,
            'nu_fr_id' => $this->nu_fr_id,
            'nu_star' => $this->nu_star,
            'nu_is_sms_white' => $this->nu_is_sms_white,
            'nu_is_notify_white' => $this->nu_is_notify_white,
            'nu_is_email_white' => $this->nu_is_email_white,
        ]);
        
        //大于最小金额
        $query->andFilterWhere(['>=', 'nu_order_total', $this->nu_order_total]);//['>=', 'id', 10]
        
        //时间范围
        if(!empty($this->nu_last_order_s_time)) {
            $query->andFilterWhere(['>=', 'nu_last_order_time', strtotime($this->nu_last_order_s_time)]);
        }
        if(!empty($this->nu_last_order_e_time)) {
            $query->andFilterWhere(['<=', 'nu_last_order_time', strtotime($this->nu_last_order_e_time)+(24*3600)]);
        }
        if(!empty($this->nu_last_send_s_time)) {
            $query->andFilterWhere(['>=', 'nu_last_send_time', strtotime($this->nu_last_send_s_time)]);
        }
        if(!empty($this->nu_last_send_e_time)) {
            $query->andFilterWhere(['<=', 'nu_last_send_time', strtotime($this->nu_last_send_e_time)+(24*3600)]);
        }
        
        /*
        if(!empty($this->nu_reg_time)) {
            $query->andFilterWhere(['between', 'nu_reg_time', strtotime($start), strtotime($end)]);
        }
        if(!empty($this->nu_last_login_time)) {
            $query->andFilterWhere(['between', 'nu_last_login_time', strtotime($start), strtotime($end)]);
        }
        */
        
        //good
        $query->andFilterWhere(['or', 
            ['like', 'nu_username', $this->keyword], 
            ['like', 'nu_realname', $this->keyword],
            ['like', 'nu_phone', $this->keyword],
            ['like', 'nu_email', $this->keyword],
            ['like', 'nu_comment', $this->keyword],
            ['like', 'nu_province', $this->keyword],
            ['like', 'nu_city', $this->keyword],
            ['like', 'nu_area', $this->keyword],
        ]);
        
        //echo $dataProvider->query->createCommand()->rawSql;exit;

        return $dataProvider;
    }
}
