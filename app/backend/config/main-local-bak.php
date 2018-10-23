<?php
$config = [
    'components' => [
        'request' => [
            //这个是本地的
            'cookieValidationKey' => 'OUX1YppF-bHW9cm86EAmg4MwmBQ6Xvni',
        ],
    ],
];

//本地环境下，且在本地启用debug和gii模块
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [//重点，为gii添加新模板
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => ['wind' => '@backend/gii/model/wind']
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => ['wind' => '@backend/gii/crud/wind']
            ],
            'controller' => [
                'class' => 'yii\gii\generators\controller\Generator',
                'templates' => ['wind' => '@backend/gii/controller/wind']
            ],
            'form' => [
                'class' => 'yii\gii\generators\form\Generator',
                'templates' => ['wind' => '@backend/gii/form/wind']//填写别名路径
            ],
            'module' => ['class' => 'yii\gii\generators\module\Generator'],
            'extension' => ['class' => 'yii\gii\generators\extension\Generator'],
        ]
    ];
}

return $config;
