<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Alert extends Widget
{
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];

    public $closeBtn = true;

    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    $className = $this->alertTypes[$type];
                    $id = $this->getId() . '-' . $type . '-' . $i;

                    $str = '<div id="'.$id.'" class="alert '.$className.' alert-dismissable">';
                    if($this->closeBtn) {
                        $str .= '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
                    }
                    $str .= $message;
                    $str .= '</div>';
                }
                
                echo $str;

                $session->removeFlash($type);
            }
        }
    }
}
