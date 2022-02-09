<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client_partner.php');
IncludeModuleLangFile(__FILE__);

class sotbit_htmleditoraddition extends CModule
{
    const MODULE_ID = 'sotbit.htmleditoraddition';
    var $MODULE_ID = 'sotbit.htmleditoraddition';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $_174164825 = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = GetMessage('sotbit.htmleditoraddition_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('sotbit.htmleditoraddition_MODULE_DESC');
        $this->PARTNER_NAME = GetMessage('sotbit.htmleditoraddition_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('sotbit.htmleditoraddition_PARTNER_URI');
    }

    function DoInstall()
    {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallDB();
        if ($_REQUEST['step'] == 1) {
            if ($_SERVER['SERVER_NAME']) {
                $_2083126301 = $_SERVER['SERVER_NAME'];
            } elseif ($_SERVER['HTTP_HOST']) {
                $_2083126301 = $_SERVER['HTTP_HOST'];
            }
            $_1769804322 = '';
            $_141330178 = \CUpdateClient::GetUpdatesList($_1769804322);
            $_1837621555 = array(
                'ACTION' => 'ADD',
                'SITE' => $_2083126301,
                'KEY' => md5('BITRIX' . \CUpdateClientPartner::GetLicenseKey() . 'LICENCE'),
                'LICENSE' => $_141330178['CLIENT'][0]['@']['LICENSE'],
                'MODULE' => self::MODULE_ID,
                'NAME' => $_REQUEST['Name'],
                'EMAIL' => $_REQUEST['Email'],
                'PHONE' => $_REQUEST['Phone'],
                'BITRIX_DATE_FROM' => $_141330178['CLIENT'][0]['@']['DATE_FROM'],
                'BITRIX_DATE_TO' => $_141330178['CLIENT'][0]['@']['DATE_TO'],
            );
            $_90443932 = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json; charset=utf-8',
                    'content' => json_encode($_1837621555)
                )
            );
            $_1314465464 = stream_context_create($_90443932);
            $_243717296 = file_get_contents('https://www.sotbit.ru:443/api/datacollection/index.php', 0, $_1314465464);
            RegisterModule(self::MODULE_ID);
        } else {
            $APPLICATION->IncludeAdminFile(GetMessage('INSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/sotbit.htmleditoraddition/install/step.php');
        }
    }

    function InstallFiles($_1921231922 = array())
    {
        if (is_dir($_10006117 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/admin')) {
            if ($_1867218094 = opendir($_10006117)) {
                while (false !== $_742514369 = readdir($_1867218094)) {
                    if ($_742514369 == '..' || $_742514369 == '.' || $_742514369 == 'menu.php') continue;
                    file_put_contents($_320328984 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . self::MODULE_ID . '_' . $_742514369, '<' . '? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/' . self::MODULE_ID . '/admin/' . $_742514369 . '");?' . '>');
                }
                closedir($_1867218094);
            }
        }
        if (is_dir($_10006117 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/components')) {
            if ($_1867218094 = opendir($_10006117)) {
                while (false !== $_742514369 = readdir($_1867218094)) {
                    if ($_742514369 == '..' || $_742514369 == '.') continue;
                    CopyDirFiles($_10006117 . '/' . $_742514369, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $_742514369, $_854770401 = True, $_2003081104 = True);
                }
                closedir($_1867218094);
            }
        }
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/tools/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/tools/', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/', true, true);
        return true;
    }

    function InstallDB($_1921231922 = array())
    {
        RegisterModuleDependences('fileman', 'OnBeforeHTMLEditorScriptRuns', self::MODULE_ID, 'CSotbitHtmlEditorAddition', 'OnIncludeHTMLEditorScriptRuns');
        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION;
        UnRegisterModule(self::MODULE_ID);
        $this->UnInstallDB();
        $this->UnInstallFiles();
    }

    function UnInstallDB($_1921231922 = array())
    {
        UnRegisterModuleDependences('fileman', 'OnBeforeHTMLEditorScriptRuns', self::MODULE_ID, 'CSotbitHtmlEditorAddition', 'OnIncludeHTMLEditorScriptRuns');
        return true;
    }

    function UnInstallFiles()
    {
        if (is_dir($_10006117 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/admin')) {
            if ($_1867218094 = opendir($_10006117)) {
                while (false !== $_742514369 = readdir($_1867218094)) {
                    if ($_742514369 == '..' || $_742514369 == '.') continue;
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . self::MODULE_ID . '_' . $_742514369);
                }
                closedir($_1867218094);
            }
        }
        if (is_dir($_10006117 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/components')) {
            if ($_1867218094 = opendir($_10006117)) {
                while (false !== $_742514369 = readdir($_1867218094)) {
                    if ($_742514369 == '..' || $_742514369 == '.' || !is_dir($_1523010834 = $_10006117 . '/' . $_742514369)) continue;
                    $_16089364 = opendir($_1523010834);
                    while (false !== $_1910175616 = readdir($_16089364)) {
                        if ($_1910175616 == '..' || $_1910175616 == '.') continue;
                        DeleteDirFilesEx('/bitrix/components/' . $_742514369 . '/' . $_1910175616);
                    }
                    closedir($_16089364);
                }
                closedir($_1867218094);
            }
        }
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/.default/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default');
        DeleteDirFilesEx('/bitrix/tools/' . self::MODULE_ID . '/');
        return true;
    }
}