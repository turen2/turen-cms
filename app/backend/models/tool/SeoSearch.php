<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\tool;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SeoSearch extends \backend\models\base\Tool
{
    public function attributes()
    {
        return ['id', 'columnid', 'cateid', 'status', 'flag', 'author', 'keyword'];
    }

    public function rules()
    {
        return [
            [['id', 'columnid', 'cateid'], 'integer'],
            [['flag', 'author', 'keyword', 'status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'columnid' => '所属栏目',
            'cateid' => '所属类别',
            'flag' => '展示标记',
            'author' => '作者编辑',
            'status' => '审核状态',
            'keyword' => '关键词',
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $className)
    {
        $query = $className::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'class' => Pagination::class,
                'defaultPageSize' => Yii::$app->params['config_page_size'],
            ],
            'sort' => [
                //'class' => Sort::class,
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->filterWhere(['and', ['and',
            '1 = 1',
            ['lang' => GLOBAL_LANG],
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
