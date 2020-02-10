<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace backend\widgets\kindeditor;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class KindEditorAction extends Action
{
    public $appPath;

    public $appUrl;
    
    public $maxSize;

    protected $rootPath;

    protected $rootUrl;

    protected $savePath;

    protected $saveUrl;
    
    private $_request;

    // public $savePath;
    public function init()
    {
        // load config file
        parent::init();
        
        $this->_request = Yii::$app->getRequest();
        
        // close csrf
        $this->_request->enableCsrfValidation = false;
        
        // 默认设置
        if(empty($this->appPath)) {
            $this->appPath = Yii::getAlias('@app/web') . '/';
        }
        if(empty($this->appUrl)) {
            $this->appUrl = Url::to('/');
        }
        
        // 根目录路径，可以指定绝对路径，比如 /var/www/attached/
        $this->rootPath = $this->appPath . 'upload/';
        // 根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
        $this->rootUrl = $this->appUrl . 'upload/';
        // 图片扩展名
        // $ext_arr = ['gif', 'jpg', 'jpeg', 'png', 'bmp'],
        // 文件保存目录路径
        $this->savePath = $this->appPath . 'upload/';
        // 文件保存目录URL
        $this->saveUrl = $this->appUrl . 'upload/';
        // 定义允许上传的文件扩展名
        // $ext_arr = array(
        // 'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
        // 'flash' => array('swf', 'flv'),
        // 'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        // 'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        // ),
        // 最大文件大小
        $this->maxSize = 1000000;
        $this->savePath = realpath($this->savePath) . '/';
    }

    /**
     * 处理动作
     */
    public function run()
    {
        // 获得action 动作
        $action = $this->_request->get('action');
        switch ($action) {
            case 'fileManagerJson':
                $this->fileManagerJsonAction();
                break;
            case 'uploadJson':
                $this->UploadJosnAction();
                break;
            default:
                break;
        }
    }

    // 排序
    protected function orderFile($a, $b)
    {
        global $order;
        if ($a['is_dir'] && ! $b['is_dir']) {
            return - 1;
        } else if (! $a['is_dir'] && $b['is_dir']) {
            return 1;
        } else {
            if ($order == 'size') {
                if ($a['filesize'] > $b['filesize']) {
                    return 1;
                } else if ($a['filesize'] < $b['filesize']) {
                    return - 1;
                } else {
                    return 0;
                }
            } else if ($order == 'type') {
                return strcmp($a['filetype'], $b['filetype']);
            } else {
                return strcmp($a['filename'], $b['filename']);
            }
        }
    }

    /**
     * 文件管理操作
     * 
     * @author ${author}
     */
    public function fileManagerJsonAction()
    {
        // 图片扩展名
        $ext_arr = array(
            'gif',
            'jpg',
            'jpeg',
            'png',
            'bmp'
        );
        
        // 目录名
        $dir_name = empty($this->_request->get('dir')) ? '' : trim($this->_request->get('dir'));
        if (! in_array($dir_name, array(
            '',
            'image',
            'flash',
            'media',
            'file'
        ))) {
            echo "Invalid Directory name.";
            exit();
        }
        
        if ($dir_name !== '') {
            $rootPath = $this->rootPath . $dir_name . "/";
            $rootUrl = $this->rootUrl . $dir_name . "/";
            
            FileHelper::createDirectory($rootPath);
        }
        
        // 根据path参数，设置各路径和URL
        if (empty($this->_request->get('path'))) {
            $current_path = realpath($rootPath) . '/';
            $current_url = $rootUrl;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($rootPath) . '/' . $this->_request->get('path');
            $current_url = $rootUrl . $this->_request->get('path');
            $current_dir_path = $this->_request->get('path');
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
        
        // echo realpath($this->rootPath);
        // 排序形式，name or size or type
        $order = empty($this->_request->get('order')) ? 'name' : strtolower($this->_request->get('order'));
        // 不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit();
        }
        // 最后一个字符不是/
        if (! preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit();
        }
        // 目录不存在或不是目录
        if (! file_exists($current_path) || ! is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit();
        }
        // 遍历目录取得文件信息
        $file_list = [];
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.')
                    continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; // 是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); // 文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; // 文件大小
                    $file_list[$i]['is_photo'] = false; // 是否图片
                    $file_list[$i]['filetype'] = ''; // 文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; // 文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); // 文件最后修改时间
                $i ++;
            }
            closedir($handle);
        }
        
        usort($file_list, [
            $this,
            'orderFile'
        ]);
        
        $result = [];
        // 相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        // 相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        // 当前目录的URL
        $result['current_url'] = $current_url;
        // 文件数
        $result['total_count'] = count($file_list);
        // 文件列表数组
        $result['file_list'] = $file_list;
        
        // 输出JSON字符串
        echo Json::encode($result);
    }

    public function UploadJosnAction()
    {
        // 定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array(
                'gif',
                'jpg',
                'jpeg',
                'png',
                'bmp'
            ),
            'flash' => array(
                'swf',
                'flv'
            ),
            'media' => array(
                'swf',
                'flv',
                'mp3',
                'wav',
                'wma',
                'wmv',
                'mid',
                'avi',
                'mpg',
                'asf',
                'rm',
                'rmvb'
            ),
            'file' => array(
                'doc',
                'docx',
                'xls',
                'xlsx',
                'ppt',
                'htm',
                'html',
                'txt',
                'zip',
                'rar',
                'gz',
                'bz2'
            )
        );
        
        // PHP上传失败
        if (! empty($_FILES['imgFile']['error'])) {
            switch ($_FILES['imgFile']['error']) {
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            
            $this->alert($error);
        }
        // 有上传文件时
        if (empty($_FILES) === false) {
            // 原文件名
            $file_name = $_FILES['imgFile']['name'];
            // 服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            // 文件大小
            $file_size = $_FILES['imgFile']['size'];
            // 检查文件名
            if (! $file_name) {
                $this->alert("请选择文件。");
            }
            // 检查目录
            if (@is_dir($this->savePath) === false) {
                $this->alert("上传目录不存在。");
            }
            // 检查目录写权限
            if (@is_writable($this->savePath) === false) {
                $this->alert("上传目录没有写权限。");
            }
            // 检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                $this->alert("上传失败。");
            }
            // 检查文件大小
            if ($file_size > $this->maxSize) {
                $this->alert("上传文件大小超过限制。");
            }
            // 检查目录名
            $dir_name = empty($this->_request->get('dir')) ? 'image' : trim($this->_request->get('dir'));
            if (empty($ext_arr[$dir_name])) {
                $this->alert("目录名不正确。");
            }
            // 获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            // 检查扩展名
            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
                $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
            }
            // 创建文件夹
            if ($dir_name !== '') {
                $savePath = $this->savePath . $dir_name . "/";
                $saveUrl = $this->saveUrl . $dir_name . "/";
                
                FileHelper::createDirectory($savePath);
            }
            $ymd = date("Ymd");
            $savePath .= $ymd . "/";
            $saveUrl .= $ymd . "/";
            
            FileHelper::createDirectory($savePath);
            // 新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            // 移动文件
            $file_path = $savePath . $new_file_name;
            if (move_uploaded_file($tmp_name, $file_path) === false) {
                $this->alert("上传文件失败。");
            }
            @chmod($file_path, 0644);
            $file_url = $saveUrl . $new_file_name;
            
            echo Json::encode(array(
                'error' => 0,
                'url' => $file_url
            ));
        }
    }

    protected function alert($msg)
    {
        echo Json::encode(array(
            'error' => 1,
            'message' => $msg
        ));
    }
}