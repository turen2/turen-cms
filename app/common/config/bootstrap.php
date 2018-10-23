<?php
Yii::setAlias('@common', dirname(__DIR__));//common是唯一不用于执行应用的目录，以下目录都对应一个应用！

Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');//前台
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');//后台
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');//控制台
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');//API