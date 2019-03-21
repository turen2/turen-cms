<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
/* @var $exception \yii\web\HttpException|\Exception */
/* @var $handler \yii\web\ErrorHandler */

$this->title = $name;
?>
<style>
    .error-page {
        font: normal 9pt "Verdana";
        color: #000;
        padding: 10px;
        background: #f5f5f5;
    }

    .error-page h1 {
        font: normal 18pt "Verdana";
        color: #f00;
        margin-bottom: .5em;
    }

    .error-page h2 {
        font: normal 14pt "Verdana";
        color: #800000;
        margin-bottom: .5em;
    }

    .error-page h3 {
        font: bold 11pt "Verdana";
    }

    .error-page p {
        font: normal 9pt "Verdana";
        line-height: 15pt;
        color: #000;
    }

    .error-page .version {
        color: gray;
        font-size: 8pt;
        border-top: 1px solid #EEEEEE;
        padding-top: 1em;
        margin-bottom: 1em;
    }
</style>

<div class="error-page">
    <div class="container">
        <h1><?= $name ?></h1>
        <h2><?= nl2br($message) ?></h2>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>

        <div class="version">
            <?= date('Y-m-d H:i:s') ?>
        </div>
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    </div>
</div>
