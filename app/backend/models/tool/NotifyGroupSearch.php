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
use app\models\tool\NotifyGroup;
use app\components\ActiveRecord;

/**
 * NotifyGroupSearch represents the model behind the search form about `app\models\tool\NotifyGroup`.
 */
class NotifyGroupSearch extends NotifyGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ng_id', 'ng_nc_id', 'ng_count', 'ng_send_count', 'ng_clock_time', 'ng_status'], 'integer'],
            [['ng_title', 'ng_comment', 'type_1', 'type_2', 'type_3', 'keyword'], 'safe'],
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
        
        $query = NotifyGroup::find()->with('notifyContent');//->current();

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
                    'ng_status' => SORT_DESC,
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
            'ng_id' => $this->ng_id,
            'ng_nc_id' => $this->ng_nc_id,
        ]);
        
        $query->andFilterWhere(['like', 'ng_title', $this->keyword])
            ->andFilterWhere(['like', 'ng_comment', $this->keyword]);
            
        if(!empty($this->type_1) || $this->type_1 === '0') {//是否发送完成
            if($this->type_1) {
                $query->andWhere(new \yii\db\Expression('ng_count > ng_send_count'));//未完成
            } else {
                $query->andWhere(new \yii\db\Expression('ng_count = ng_send_count'));//已发完
            }
        }
        
        if(!empty($this->type_2) || $this->type_2 === '0') {//发送中、暂停中
            if($this->type_2) {
                $query->andFilterWhere(['ng_status' => ActiveRecord::STATUS_ON]);//开启状态
            } else {
                $query->andFilterWhere(['ng_status' => ActiveRecord::STATUS_OFF]);//暂停状态
            }
        }
        
//         '0' => '时间未到',
//         '1' => '时间已到',
//         '2' => '没有定时',
        if(!empty($this->type_3) || $this->type_3 === '0') {//定时状态
            if(empty($this->type_3)) {
                $query->andFilterWhere(['>', 'ng_clock_time', time()]);
            } elseif($this->type_3 == 1) {
                $query->andFilterWhere(['<', 'ng_clock_time', time()]);
            } elseif($this->type_3 == 2) {
                $query->andWhere(new \yii\db\Expression('ng_clock_time = \'\''));
            }
        }
        
        //echo $dataProvider->query->createCommand()->rawSql;

        return $dataProvider;
    }
}
