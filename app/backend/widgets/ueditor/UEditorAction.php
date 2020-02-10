<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\ueditor;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\components\AliyunOss;
use yii\base\InvalidConfigException;

class UEditorAction extends Action
{
    /**
     * @var array
     */
    public $config = [];
    
    public $folder = '';

    public function init()
    {
        parent::init();
        
        //close csrf
        Yii::$app->getRequest()->enableCsrfValidation = false;
        
        //后端默认设置
        $this->config = ArrayHelper::merge(Config::getConfig(), $this->config);
        
        if(empty($this->folder)) {
            throw new InvalidConfigException('上传组件配置错误。');
        }
    }

    /**
     * 执行并处理action
     */
    public function run()
    {
        $action = Yii::$app->request->get('action');
        switch ($action) {
            case 'config'://加载编辑器时，首次获取后台的配置
                $result = Json::encode($this->config);
                break;

                /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = $this->upload();
                break;

                /* 列出图片 */
            case 'listimage':
                /* 列出文件 */
            case 'listfile':
                $result = $this->fileList();
                break;

                /* 抓取远程文件 */
            case 'catchimage':
                $result = $this->remoteSave();
                break;

            default:
                $result = Json::encode([
                    'state' => 'Request the address wrong'
                ]);
                break;
        }
        /* 输出结果 */
        $callback = Yii::$app->getRequest()->get('callback');
        if ($callback) {
            if (preg_match('/^[\w_]+$/', $callback)) {
                echo $callback . '(' . $result . ')';
            } else {
                echo Json::encode([
                    'state' => 'Callback parameter is not valid',
                ]);
            }
        } else {
            echo $result;
        }
    }

    /**
     * 上传
     * @return string
     */
    protected function upload()
    {
        $mode = 'upload';
        switch (Yii::$app->getRequest()->get('action')) {
            case 'uploadimage':
                $config = array(
                    'pathFormat' => $this->config['imagePathFormat'],
                    'maxSize' => $this->config['imageMaxSize'],
                    'allowFiles' => $this->config['imageAllowFiles']
                );
                $fieldName = $this->config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    'pathFormat' => $this->config['scrawlPathFormat'],
                    'maxSize' => $this->config['scrawlMaxSize'],
                    'allowFiles' => $this->config['scrawlAllowFiles'],
                    'oriName' => 'scrawl.png'
                );
                $fieldName = $this->config['scrawlFieldName'];
                $mode = 'base64';
                break;
            case 'uploadvideo':
                $config = array(
                    'pathFormat' => $this->config['videoPathFormat'],
                    'maxSize' => $this->config['videoMaxSize'],
                    'allowFiles' => $this->config['videoAllowFiles']
                );
                $fieldName = $this->config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    'pathFormat' => $this->config['filePathFormat'],
                    'maxSize' => $this->config['fileMaxSize'],
                    'allowFiles' => $this->config['fileAllowFiles']
                );
                $fieldName = $this->config['fileFieldName'];
                break;
        }
        
        //开始上传
        $uploader = new UEditorUploader($fieldName, $config, $this->folder, $mode);
        //返回数据
        return Json::encode($uploader->getFileInfo());
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     'state' => '',          //上传状态，上传成功时必须返回'SUCCESS'
         *     'url' => '',            //返回的地址
         *     'title' => '',          //新文件名
         *     'original' => '',       //原始文件名
         *     'type' => ''            //文件类型
         *     'size' => '',           //文件大小
         * )
         */
    }

    /**
     * 获取已上传的文件列表
     * @return string
     */
    protected function fileList()
    {
        /* 判断类型 */
        switch (Yii::$app->getRequest()->get('action')) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $this->config['fileManagerAllowFiles'];
                $listSize = $this->config['fileManagerListSize'];
                $path = $this->config['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $this->config['imageManagerAllowFiles'];
                $listSize = $this->config['imageManagerListSize'];
                $path = $this->config['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace('.', '|', join('', $allowFiles)), 1);

        /* 获取参数 */
        $size = Yii::$app->getRequest()->get('size', $listSize);
        $start = Yii::$app->getRequest()->get('start', 0);
        $end = (int)$start + (int)$size;
        
//         $objectList = [];
//         $basePath = Yii::$app->aliyunoss->getFullPath();
//         $time = time();
//         $models = Attachment::find()->limit($size)->offset($start)->all();
//         foreach ($models as $model) {
//             $objectList[] = [
//                 'url ' => $model->getObject($basePath),
//                 'mtime' => $time,
//             ];
//         }
        
//         /* 返回数据 */
//         $result = Json::encode([
//             'state' => 'SUCCESS',
//             'list' => $objectList,
//             'start' => $start,
//             'total' => count($objectList)
//         ]);
        
//         return $result;
        
        /* 获取文件列表 */
        //$files = $this->getfiles($path, $allowFiles);//被阿里云替代
        
        $options = [
            'delimiter' => '/',
            'prefix' => $this->folder.'/',
            'max-keys' => 1000,
            'marker' => '',
        ];
        //以后会使用数据库管理这些图片，否则这时的内存占用会非常大
        $objectList = Yii::$app->aliyunoss->getFiles($options);
        
        //如果没有找到文件
        if (empty($objectList)) {
            return Json::encode([
                'state' => 'No match file',
                'list' => [],
                'start' => $start,
                'total' => count($objectList)
            ]);
        }
        //排序
        usort($objectList, function($a, $b) {
            if(strtotime($a->getLastModified()) == strtotime($b->getLastModified())) return 0;
            return strtotime($a->getLastModified()) > strtotime($b->getLastModified()) ? -1 : 1;
        });

        /* 获取指定范围的列表 */
        $len = count($objectList);
        for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = [
                'url' => Yii::$app->aliyunoss->getFullPath().$objectList[$i]->getKey(),
                'mtime' => strtotime($objectList[$i]->getLastModified()),
            ];
        }

        /* 返回数据 */
        $result = Json::encode([
            'state' => 'SUCCESS',
            'list' => $list,
            'start' => $start,
            'total' => count($objectList)
        ]);

        return $result;
    }

    /**
     * 抓取远程图片
     * @return string
     */
    protected function remoteSave()
    {
        /* 上传配置 */
        $config = [
            'pathFormat' => $this->config['catcherPathFormat'],
            'maxSize' => $this->config['catcherMaxSize'],
            'allowFiles' => $this->config['catcherAllowFiles'],
            'oriName' => 'remote.png'
        ];
        $fieldName = $this->config['catcherFieldName'];

        /* 抓取远程图片 */
        $list = [];
        $errorList = [];
        if (Yii::$app->getRequest()->post($fieldName)) {
            $source = Yii::$app->getRequest()->post($fieldName);
        } else {
            $source = Yii::$app->getRequest()->get($fieldName);
        }
        
        foreach ($source as $imgUrl) {
            $uploader = new UEditorUploader($imgUrl, $config, $this->folder, 'remote');
            $info = $uploader->getFileInfo();
            //var_dump($info);
            
            if($info['state'] == 'SUCCESS') {
                array_push($list, [
                    'state' => $info['state'],
                    'url' => $info['url'],
                    'size' => $info['size'],
                    'title' => htmlspecialchars($info['title']),
                    'original' => htmlspecialchars($info['original']),
                    'source' => htmlspecialchars($imgUrl),
                ]);
            } else {
                $errorList[] = $info;
            }
        }

        /* 返回抓取数据 */
        return Json::encode([
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => count($list) ? $list : $errorList,
        ]);
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param $allowFiles
     * @param array $files
     * @return array|null
     */
    /*
    protected function getfiles($path, $allowFiles, &$files = [])
    {
        if (!is_dir($path)) return null;
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
        
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match('/\.(' . $allowFiles . ')$/i', $file)) {
                        $files[] = [
                            'url' => Yii::getAlias('@web').'/'.str_replace('\\', '/', substr($path2, strlen(Yii::getAlias('@backend/web/')))),
                            'mtime' => filemtime($path2)
                        ];
                    }
                }
            }
        }
        return $files;
    }
    */
}