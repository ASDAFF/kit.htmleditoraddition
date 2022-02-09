<?
define('NOT_CHECK_PERMISSIONS', false);
define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

if (!\Bitrix\Main\Loader::includeModule('kit.htmleditoraddition')) return false;

if (class_exists('CKitHtmlEditorAddition', true))
{
    if($_REQUEST['ajax'] == 'yes' && $_REQUEST['action'] == "openWindow")
    {   
        CKitHtmlEditorAddition::modalVideoShow();
    }
    elseif($_REQUEST['ajax'] == 'yes' && $_REQUEST['action'] == "saveVideo")
    { 
        CKitHtmlEditorAddition::saveVideo();
    }        
}
?>