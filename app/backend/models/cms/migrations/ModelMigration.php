<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\models\cms\migrations;

use Yii;
use yii\db\Migration;
use yii\base\InvalidArgumentException;

class ModelMigration extends Migration
{
    public $tableName;
    
    public function init()
    {
        parent::init();
        
        if(empty($this->tableName)) {
            throw new InvalidArgumentException('ModelMigration::$tableName参数不能为空。');
        }
    }
    
    /**
     * 安装
     * {@inheritDoc}
     * @see \yii\db\Migration::up()
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $userTable = '{{%'.$this->tableName.'}}';

        // Check if the table exists
        if ($this->db->schema->getTableSchema($userTable, true) === null) {
            $this->createTable($userTable, [
                'id' => $this->primaryKey()->unsigned()->notNull()->comment('ID'),
                'title' => $this->string(80)->notNull()->defaultValue('')->comment('标题'),
                'slug' => $this->string(200)->notNull()->defaultValue('')->comment('访问链接'),
                'colorval' => $this->char(10)->notNull()->comment('字体颜色'),
                'boldval' => $this->char(10)->notNull()->comment('字体加粗'),
                'columnid' => $this->integer(11)->unsigned()->notNull()->comment('栏目ID'),
                'parentid' => $this->integer(11)->unsigned()->notNull()->comment('栏目父ID'),
                'parentstr' => $this->string(80)->notNull()->comment('栏目父ID列表'),
                'cateid' => $this->integer(11)->unsigned()->null()->comment('类别ID'),
                'catepid' => $this->integer(11)->unsigned()->null()->comment('类别父ID'),
                'catepstr' => $this->string(80)->null()->comment('类别父ID列表'),
                'flag' => $this->string(30)->notNull()->defaultValue('')->comment('标记'),
                'author' => $this->string(50)->notNull()->defaultValue('')->comment('作者编辑'),
                'picurl' => $this->string(100)->notNull()->defaultValue('')->comment('缩略图'),
                'lang' => $this->string(8)->notNull()->defaultValue('')->comment('多语言'),
                'status' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1)->comment('状态'),
                'orderid' => $this->integer(11)->unsigned()->notNull()->defaultValue(10)->comment('排序'),
                'posttime' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('发布时间'),
                'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('更新时间'),
                'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('添加时间'),
            ], $tableOptions);
        }
    }

    /**
     * 卸载
     * {@inheritDoc}
     * @see \yii\db\Migration::down()
     */
    public function down()
    {
        $userTable = '{{%'.$this->tableName.'}}';
        if (Yii::$app->db->schema->getTableSchema($userTable, true) !== null) {
            $this->dropTable($userTable);
        }
    }
}