<?
define('NOT_CHECK_PERMISSIONS', false);
define('NO_KEEP_STATISTIC', true);
define('STOP_STATISTICS', true);
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

if (!\Bitrix\Main\Loader::includeModule('sotbit.htmleditoraddition')) return false;

if (class_exists('CSotbitHtmlEditorAddition', true)) 
{
    if($_REQUEST['ajax'] == 'yes' && $_REQUEST['action'] == "openWindow")
    {   
        CSotbitHtmlEditorAddition::modalVideoShow();
    }
    elseif($_REQUEST['ajax'] == 'yes' && $_REQUEST['action'] == "saveVideo")
    { 
        CSotbitHtmlEditorAddition::saveVideo();      
    }        
}
?>