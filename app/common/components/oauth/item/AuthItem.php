<?php

namespace common\components\oauth\item;

use Yii;
use yii\authclient\widgets\AuthChoiceItem;
use yii\helpers\Html;

class AuthItem extends AuthChoiceItem
{    
    //public $client;
    //public $authChoice;
    
    //设置weiget挂件view路径
//     public function getViewPath()
//     {
//         return parent::getViewPath();
//     }
    
    public function run()
    {
        $viewOptions = $this->client->getViewOptions();
        
        if (!isset($htmlOptions['class'])) {
            $htmlOptions['class'] = $this->client->getName();
        }
        if (!isset($htmlOptions['title'])) {
            $htmlOptions['title'] = $this->client->getTitle();
        }
        Html::addCssClass($htmlOptions, ['widget' => 'auth-link']);
        
        if ($this->authChoice->popupMode) {
            if (isset($viewOptions['popupWidth'])) {
                $htmlOptions['data-popup-width'] = $viewOptions['popupWidth'];
            }
            if (isset($viewOptions['popupHeight'])) {
                $htmlOptions['data-popup-height'] = $viewOptions['popupHeight'];
            }
        }
        
        return Html::a($this->client->getName(), $this->authChoice->createClientUrl($this->client), $htmlOptions);
    }
}