<?php

namespace common\tools\like;

use Yii;
/**
 * This is the model class for table "{{%like}}".
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property string $model
 * @property int $model_id
 * @property string $md5
 * @property int $created_at
 */
class Like extends \yii\db\ActiveRecord
{
    const TYPE_UP = 'UP'; // 赞
    const TYPE_DOWN = 'DOWN'; // 踩
    const TYPE_FOLLOW = 'FOLLOW'; // 关注

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%like}}';
    }

    public static function PlusOne($modelClass, $id, $md5, $type = self::TYPE_UP)
    {
        // 插入
        Yii::$app->db->createCommand()->insert(self::tableName(), [
            'type' => $type,
            'user_id' => Yii::$app->user->isGuest?null:Yii::$app->user->id,
            'model' => $modelClass,
            'model_id' => $id,
            'md5' => $md5,
            'lang' => GLOBAL_LANG,
            'created_at' => time(),
        ])->execute();
    }
}
