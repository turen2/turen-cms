<?php
/**
 * @link http://www.juwanfang.com/
 * @copyright Copyright (c) 聚万方CMS
 * @author developer qq:980522557
 */
namespace app\widgets\ueditor;

//ueditor后端配置
class Config
{
    public static function getConfig()
    {
        return [
            /* 上传图片配置项 */
            // 执行上传图片的action名称
            'imageActionName' => 'uploadimage',
            // 提交的图片表单名称
            'imageFieldName' => 'upfile',
            // 上传大小限制，单位B
            'imageMaxSize' => 4024000,//4M
            // 上传图片格式显示
            'imageAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp'
            ],
            // 是否压缩图片,默认是true
            'imageCompressEnable' => true,
            // 图片压缩最长边限制
            'imageCompressBorder' => 1600,
            // 插入的图片浮动方式
            'imageInsertAlign' => 'none',
            // 图片访问路径前缀
            'imageUrlPrefix' => '',
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
            /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
            /* {time} 会替换成时间戳 */
            /* {yyyy} 会替换成四位年份 */
            /* {yy} 会替换成两位年份 */
            /* {mm} 会替换成两位月份 */
            /* {dd} 会替换成两位日期 */
            /* {hh} 会替换成两位小时 */
            /* {ii} 会替换成两位分钟 */
            /* {ss} 会替换成两位秒 */
            /* 非法字符 \ => * ? ' < > | */
            /* 具请体看线上文档=> fex.baidu.com/ueditor/#use-format_upload_filename */
            'imagePathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
        
        
            /* 涂鸦图片上传配置项 */
        
            //执行上传涂鸦的action名称
            'scrawlActionName' => 'uploadscrawl',
            // 提交的图片表单名称
            'scrawlFieldName' => 'upfile',
            // 上传保存路径,可以自定义保存路径和文件名格式
            'scrawlPathFormat' => '/upload/image/scrawl/{yyyy}{mm}{dd}/{time}{rand:6}',
            // 上传大小限制，单位B
            'scrawlMaxSize' => 1024000,
            //图鸦类型
            'scrawlAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp'
            ],
            // 图片访问路径前缀
            'scrawlUrlPrefix' => '',
            // 截图工具上传
            'scrawlInsertAlign' => 'none',
            // 执行上传截图的action名称
            'snapscreenActionName' => 'uploadimage',
            // 上传保存路径,可以自定义保存路径和文件名格式
            'snapscreenPathFormat' => '/upload/image/snapscreen/{yyyy}{mm}{dd}/{time}{rand:6}',
            // 图片访问路径前缀
            'snapscreenUrlPrefix' => '',
            // 插入的图片浮动方式
            'snapscreenInsertAlign' => 'none',
        
            /* 抓取远程图片配置 */
        
            //抓取域名配置
            'catcherLocalDomain' => [
                '127.0.0.1',
                'localhost',
                'img.baidu.com'
            ],
            // 执行抓取远程图片的action名称
            'catcherActionName' => 'catchimage',
            // 提交的图片列表表单名称
            'catcherFieldName' => 'source',
            // 上传保存路径,可以自定义保存路径和文件名格式
            'catcherPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            // 图片访问路径前缀
            'catcherUrlPrefix' => '',
            // 上传大小限制，单位B
            'catcherMaxSize' => 1024000,
            // 抓取图片格式显示
            'catcherAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp'
            ],
        
            /* 上传视频配置 */
        
            //执行上传视频的action名称
            'videoActionName' => 'uploadvideo',
            // 提交的视频表单名称
            'videoFieldName' => 'upfile',
            // 上传保存路径,可以自定义保存路径和文件名格式
            'videoPathFormat' => '/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}',
            // 视频访问路径前缀
            'videoUrlPrefix' => '',
            // 上传大小限制，单位B，默认100MB
            'videoMaxSize' => 102400000,
            // 上传视频格式显示
            'videoAllowFiles' => [
                '.flv',
                '.swf',
                '.mkv',
                '.avi',
                '.rm',
                '.rmvb',
                '.mpeg',
                '.mpg',
                '.ogg',
                '.ogv',
                '.mov',
                '.wmv',
                '.mp4',
                '.webm',
                '.mp3',
                '.wav',
                '.mid'
            ],
        
            /* 上传文件配置 */
        
            //controller里,执行上传视频的action名称
            'fileActionName' => 'uploadfile',
            // 提交的文件表单名称
            'fileFieldName' => 'upfile',
            // 上传保存路径,可以自定义保存路径和文件名格式
            'filePathFormat' => '/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}',
            // 文件访问路径前缀
            'fileUrlPrefix' => '',
            // 上传大小限制，单位B，默认50MB
            'fileMaxSize' => 51200000,
            // 上传文件格式显示
            'fileAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp',
                '.flv',
                '.swf',
                '.mkv',
                '.avi',
                '.rm',
                '.rmvb',
                '.mpeg',
                '.mpg',
                '.ogg',
                '.ogv',
                '.mov',
                '.wmv',
                '.mp4',
                '.webm',
                '.mp3',
                '.wav',
                '.mid',
                '.rar',
                '.zip',
                '.tar',
                '.gz',
                '.7z',
                '.bz2',
                '.cab',
                '.iso',
                '.doc',
                '.docx',
                '.xls',
                '.xlsx',
                '.ppt',
                '.pptx',
                '.pdf',
                '.txt',
                '.md',
                '.xml'
            ],
        
            /* 列出指定目录下的图片 */
        
            //执行图片管理的action名称
            'imageManagerActionName' => 'listimage',
            // 指定要列出图片的目录
            'imageManagerListPath' => '/upload/image/',
            // 每次列出文件数量
            'imageManagerListSize' => 20,
            // 图片访问路径前缀
            'imageManagerUrlPrefix' => '',
            // 插入的图片浮动方式
            'imageManagerInsertAlign' => 'none',
            // 列出的文件类型
            'imageManagerAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp'
            ],
        
            /* 列出指定目录下的文件 */
        
            //执行文件管理的action名称
            'fileManagerActionName' => 'listfile',
            // 指定要列出文件的目录
            'fileManagerListPath' => '/upload/file/',
            // 文件访问路径前缀
            'fileManagerUrlPrefix' => '',
            // 每次列出文件数量
            'fileManagerListSize' => 20,
            // 列出的文件类型
            'fileManagerAllowFiles' => [
                '.png',
                '.jpg',
                '.jpeg',
                '.gif',
                '.bmp',
                '.flv',
                '.swf',
                '.mkv',
                '.avi',
                '.rm',
                '.rmvb',
                '.mpeg',
                '.mpg',
                '.ogg',
                '.ogv',
                '.mov',
                '.wmv',
                '.mp4',
                '.webm',
                '.mp3',
                '.wav',
                '.mid',
                '.rar',
                '.zip',
                '.tar',
                '.gz',
                '.7z',
                '.bz2',
                '.cab',
                '.iso',
                '.doc',
                '.docx',
                '.xls',
                '.xlsx',
                '.ppt',
                '.pptx',
                '.pdf',
                '.txt',
                '.md',
                '.xml'
            ]
        ];
    }
}

