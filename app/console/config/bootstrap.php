<?php
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');//控制台

//虽然与其它app隔离了，但是console会引用common的包
Yii::setAlias('@common', dirname(dirname(__DIR__)) . '/common');