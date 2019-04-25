<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$this->title = '有验证码码请查收';
?>

<style type="text/css">
    body {
        margin: 0 auto;
        padding: 0;
        font-family: 'Microsoft YaHei';
        color: #333333;
        background-color: #fff;
        font-size: 12px;
    }

    a {
        color: #00a2ca;
        line-height: 22px;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
        color: #00a2ca;
    }

    td {
        font-family: 'Microsoft YaHei';
    }
</style>

<div style="background: #FFFFFF;font-family:'Microsoft YaHei';">
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5" style="font-family:'Microsoft YaHei';">
        <tr>
            <td>
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" height="40"></table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height="48" style="font-family:'Microsoft YaHei';border: 1px solid #edecec;border-bottom: none;">
                    <tr>
                        <td width="74" height="48" border="0" align="center" valign="middle" style="padding-left:20px;">
                            <a href="" target="_blank">
                                <img src="<?= $params['logo'] ?>" alt="" height="48" border="0">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="800" border="0" align="left" cellpadding="0" cellspacing="0" style=" border:1px solid #edecec; border-top:none; padding:0 20px;font-size:14px;color:#333333;">
                    <tr>
                        <td width="760" height="56" border="0" align="left" colspan="2" style=" font-size:16px;vertical-align:bottom;font-family:'Microsoft YaHei';">
                            尊敬的 <?= $params['username'] ?>，您好！
                        </td>
                    </tr>
                    <tr>
                        <td width="760" height="30" border="0" align="left" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="40" height="32" border="0" align="left" valign="middle" style=" width:40px; text-align:left;vertical-align:middle; line-height:32px; float:left;"></td>
                        <td width="720" height="32" border="0" align="left" valign="middle" style=" width:720px; text-align:left;vertical-align:middle;line-height:32px;font-family:'Microsoft YaHei';">
                            您在进行邮箱验证码操作，请在5分钟内完成验证，验证码为：<?= $params['code'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="720" height="32" colspan="2" style="padding-left:40px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="720" height="14" colspan="2" style="padding-bottom:16px; border-bottom:1px dashed #e5e5e5;font-family:'Microsoft YaHei';"> <?= $params['sitename'] ?></td>
                    </tr>
                    <tr>
                        <td width="720" height="14" colspan="2" style="padding:8px 0 28px;color:#999999; font-size:12px;font-family:'Microsoft YaHei';">此为系统邮件请勿回复</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>