<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class CSotbitHtmlEditorAddition
{
    const MODULE_ID = 'sotbit.htmleditoraddition';
    const SOTBIT_HTML_EDITOR_COOKIES = 'sotbit_html_editor_params';
    const EVENT_SERVER_NAME_ERROR = 'EMPTY_SERVER_NAME';
    private static $_1301099690 = '';

    public static function getIdCollectionDefault()
    {
        if (\Bitrix\Main\Loader::includeModule('fileman')) {
            CMedialib::Init();
            $_1593227664 = array('arFields' => array('NAME' => 'sotbit.htmleditoraddition', 'PARENT_ID' => 0, 'ACTIVE' => 'Y', 'ML_TYPE' => '1'), 'arFilter' => array('NAME' => 'sotbit.htmleditoraddition'));
            $_368628618 = CMedialibCollection::GetList($_1593227664);
            if (!empty($_368628618['0']['ID'])) {
                $_455699908 = $_368628618['0']['ID'];
            } else {
                $_455699908 = CMedialibCollection::Edit($_1593227664);
            }
            return $_455699908;
        }
    }

    public static function deleteCookieHtmlEditor()
    {
        static::$_1301099690 = static::getServerName();
        if (static::$_1301099690 === false) {
            static::log(static::EVENT_SERVER_NAME_ERROR, Loc::getMessage("SOTBIT_HTMLEDITORADDITION_V_NASTROYKAH_GLAVNOG") . static::SOTBIT_HTML_EDITOR_COOKIES . ' ' . Loc::getMessage("SOTBIT_HTMLEDITORADDITION_U_POLQZOVATELA_NE_UD"));
        } else {
            setcookie(static::SOTBIT_HTML_EDITOR_COOKIES, '', false, '/', static::$_1301099690, false, true);
        }
    }

    public static function getServerName()
    {
        $_1301099690 = Option::get('main', 'server_name');
        if ($_1301099690 === 'localhost') {
            return null;
        }
        $_169796117 = explode('.', $_1301099690);
        $_169796117 = array_reverse($_169796117);
        if ($_169796117['0'] && $_169796117['1']) {
            return '.' . $_169796117['1'] . '.' . $_169796117['0'];
        }
        return false;
    }

    protected function log($type, $_976317104, $_143578553 = 'WARNING')
    {
        \CEventLog::Add(array('SEVERITY' => $_143578553, 'AUDIT_TYPE_ID' => $type, 'MODULE_ID' => self::MODULE_ID, 'DESCRIPTION' => $_976317104, 'ITEM_ID' => self::MODULE_ID));
    }

    function getDemo()
    {
        $_149911671 = CModule::IncludeModuleEx(self::MODULE_ID);
        if ($_149911671 == 3) {
            echo Loc::getMessage('SOTBIT_HTML_EDITOR_ADDITION_DEMO');
            return false;
        } else return true;
    }

    public function OnIncludeHTMLEditorScriptRuns()
    {
        global $APPLICATION;
        if ($APPLICATION->GetFileAccessPermission('upload/') > 'U') {
            CJSCore::RegisterExt('sotbit_htmleditor_additional', array('js' => '/bitrix/tools/' . self::MODULE_ID . '/js/script.js', 'lang' => '/bitrix/modules/' . self::MODULE_ID . '/lang/' . LANGUAGE_ID . '/install/tools/' . self::MODULE_ID . '/js/script.php', 'rel' => array('fileinput'),));
            CJSCore::Init(array('sotbit_htmleditor_additional'));
        }
    }

    public function modalImagesShow()
    {
        if (class_exists('\Bitrix\Main\UI\FileInput', true) && isset($_REQUEST['name_input'])) {
            $_1219281716 = static::getCookieHtmlEditor();
            $_1057032277 = '<form class="' . $_REQUEST['name_input'] . '_form" name="' . $_REQUEST['name_input'] . '_form" action="#" method="post">';
            $_1057032277 .= '<script>';
            $_1057032277 .= 'var elem = document.getElementsByClassName("bx-core-popup-menu-level0");';
            $_1057032277 .= 'var over = document.getElementsByClassName("bx-core-dialog-overlay");';
            $_1057032277 .= 'if(elem.length != 0){';
            $_1057032277 .= 'elem[0].parentNode.removeChild(elem[0]);';
            $_1057032277 .= '}';
            $_1057032277 .= 'if(over.length != 0){';
            $_1057032277 .= 'over[over.length - 1].style.display = "block";';
            $_1057032277 .= 'over[over.length - 1].style.zIndex = "3006";';
            $_1057032277 .= '}';
            $_1057032277 .= '</script>';
            $_1057032277 .= '<table class="adm-detail-content-table edit-table" style="opacity: 1; width: 100%;">';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_IMAGES_PARAMS_SELECT_COLLECTION') . ':</td>';
            $_1057032277 .= '<td>';
            $_1057032277 .= CSotbitHtmlEditorAddition::getSelectBoxCollection($_REQUEST['name_input'] . '_collection', $_1219281716[$_REQUEST['name_input'] . '_collection'], 1);
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_IMAGES_PARAMS_ADD_BR') . ':</td>';
            $_1057032277 .= '<td>';
            if ($_1219281716 != null && $_1219281716[$_REQUEST['name_input'] . '_addTagsBr'] == 'N') {
                $_1057032277 .= '<input id="' . $_REQUEST['name_input'] . '_addTagsBr" class="adm-designed-checkbox" type="checkbox" value="Y" name="' . $_REQUEST['name_input'] . '_addTagsBr">';
            } else {
                $_1057032277 .= '<input id="' . $_REQUEST['name_input'] . '_addTagsBr" class="adm-designed-checkbox" type="checkbox" checked="checked" value="Y" name="' . $_REQUEST['name_input'] . '_addTagsBr">';
            }
            $_1057032277 .= '<label class="adm-designed-checkbox-label" for="' . $_REQUEST['name_input'] . '_addTagsBr" title=""></label>';
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr><td colspan="2">&nbsp;</td></tr>';
            $_1057032277 .= '<tr><td colspan="2">';
            $_1057032277 .= \Bitrix\Main\UI\FileInput::createInstance(array('name' => $_REQUEST['name_input'] . '[n#IND#]', 'description' => true, 'upload' => true, 'allowUpload' => 'I', 'medialib' => true, 'fileDialog' => true, 'cloud' => true, 'delete' => true, 'edit' => true,))->show($_REQUEST['name_input']);
            $_1057032277 .= '</td></tr>';
            $_1057032277 .= '</table>';
            $_1057032277 .= '</form>';
            echo $_1057032277;
        }
    }

    public static function getCookieHtmlEditor()
    {
        static::$_1301099690 = static::getServerName();
        if (static::$_1301099690 === false) {
            static::log(static::EVENT_SERVER_NAME_ERROR, Loc::getMessage("SOTBIT_HTMLEDITORADDITION_V_NASTROYKAH_GLAVNOG") . static::SOTBIT_HTML_EDITOR_COOKIES . ' ' . Loc::getMessage("SOTBIT_HTMLEDITORADDITION_POLQZOVATELU_NE_USTA"));
        } elseif (isset($_COOKIE[static::SOTBIT_HTML_EDITOR_COOKIES])) {
            return unserialize(stripcslashes($_COOKIE[static::SOTBIT_HTML_EDITOR_COOKIES]));
        }
        return null;
    }

    public static function getSelectBoxCollection($_692343834, $_1727398230, $_980747474 = 1)
    {
        $_1220725431 = static::getListCollection($_980747474);
        $_1565709665 = array();
        if (!empty($_1220725431)) {
            foreach ($_1220725431 as $_903895832 => $_1719288637) {
                $_1565709665['REFERENCE'][] = $_1719288637['NAME'];
                $_1565709665['REFERENCE_ID'][] = $_1719288637['ID'];
            }
            return SelectBoxFromArray($_692343834, $_1565709665, $_1727398230, '', '');
        } else {
            return '';
        }
    }

    public static function getListCollection($_980747474 = 1)
    {
        $_980747474 = intval($_980747474) ?: 1;
        $_1036837479 = '';
        if (\Bitrix\Main\Loader::includeModule('fileman')) {
            CMedialib::Init();
            $_1036837479 = CMedialibCollection::GetList(array('arFilter' => array('ACTIVE' => 'Y', 'ML_TYPE' => $_980747474), 'arOrder' => array('NAME' => 'ASC')));
            if (empty($_1036837479)) {
                $_1593227664 = array('arFields' => array('NAME' => Loc::getMessage('SOTBIT_HTMLEDITORADDITION_COLLECTION_MEDIA_NAME_' . $_980747474), 'PARENT_ID' => 0, 'ACTIVE' => 'Y', 'ML_TYPE' => $_980747474, 'DESCRIPTION' => Loc::getMessage('SOTBIT_HTMLEDITORADDITION_COLLECTION_MEDIA_DESCRIPTION')),);
                $_455699908 = CMedialibCollection::Edit($_1593227664);
                $_1036837479 = CMedialibCollection::GetList(array('arFilter' => array('ACTIVE' => 'Y', 'ML_TYPE' => $_980747474), 'arOrder' => array('NAME' => 'ASC')));
            }
        }
        return $_1036837479;
    }

    public function modalVideoShow()
    {
        if (class_exists('\Bitrix\Main\UI\FileInput', true) && isset($_REQUEST['name_input'])) {
            if (CModule::IncludeModule('fileman')) {
                CMedialib::Init();
                $_1227432844 = CMedialib::GetTypes(array('video'));
                $_1227432844 = $_1227432844[0]['ext'];
            } else {
                $_1227432844 = 'flv,mp4,wmv';
            }
            $_1219281716 = static::getCookieHtmlEditor();
            $_1057032277 = '<form class="' . $_REQUEST['name_input'] . '_form" name="' . $_REQUEST['name_input'] . '_form" action="#" method="post">';
            $_1057032277 .= '<script>';
            $_1057032277 .= 'var elem = document.getElementsByClassName("bx-core-popup-menu-level0");';
            $_1057032277 .= 'var over = document.getElementsByClassName("bx-core-dialog-overlay");';
            $_1057032277 .= 'if(elem.length != 0){';
            $_1057032277 .= 'elem[0].parentNode.removeChild(elem[0]);';
            $_1057032277 .= '}';
            $_1057032277 .= 'if(over.length != 0){';
            $_1057032277 .= 'over[over.length - 1].style.display = "block";';
            $_1057032277 .= 'over[over.length - 1].style.zIndex = "3006";';
            $_1057032277 .= '}';
            $_1057032277 .= '</script>';
            $_1057032277 .= '<table class="adm-detail-content-table edit-table" style="opacity: 1; width: 100%;">';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_PARAMS_SELECT_COLLECTION') . ':</td>';
            $_1057032277 .= '<td>';
            $_1057032277 .= CSotbitHtmlEditorAddition::getSelectBoxCollection($_REQUEST['name_input'] . '_collection', $_1219281716[$_REQUEST['name_input'] . '_collection'], 2);
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_PARAMS_ADD_BR') . ':</td>';
            $_1057032277 .= '<td>';
            if ($_1219281716 != null && $_1219281716[$_REQUEST['name_input'] . '_addTagsBr'] == 'N') {
                $_1057032277 .= '<input id="' . $_REQUEST['name_input'] . '_addTagsBr" class="adm-designed-checkbox" type="checkbox" value="Y" name="' . $_REQUEST['name_input'] . '_addTagsBr">';
            } else {
                $_1057032277 .= '<input id="' . $_REQUEST['name_input'] . '_addTagsBr" class="adm-designed-checkbox" type="checkbox" checked="checked" value="Y" name="' . $_REQUEST['name_input'] . '_addTagsBr">';
            }
            $_1057032277 .= '<label class="adm-designed-checkbox-label" for="' . $_REQUEST['name_input'] . '_addTagsBr" title=""></label>';
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_PARAMS_HEIGHT') . ':</td>';
            $_1057032277 .= '<td>';
            if ($_1219281716 != null && $_1219281716[$_REQUEST['name_input'] . '_videoHeight'] != '') {
                $_1057032277 .= '<input min=10 id="' . $_REQUEST['name_input'] . '_videoHeight" class="bxhtmled-90-input" type="number" value="' . $_1219281716[$_REQUEST['name_input'] . '_videoHeight'] . '" name="' . $_REQUEST['name_input'] . '_videoHeight">';
            } else {
                $_1057032277 .= '<input min=10 id="' . $_REQUEST['name_input'] . '_videoHeight" class="bxhtmled-90-input" type="number" value="480" name="' . $_REQUEST['name_input'] . '_videoHeight">';
            }
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr>';
            $_1057032277 .= '<td width="50%" style="text-align: right">' . Loc::getMessage('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_PARAMS_WIDTH') . ':</td>';
            $_1057032277 .= '<td>';
            if ($_1219281716 != null && $_1219281716[$_REQUEST['name_input'] . '_videoWidth'] != '') {
                $_1057032277 .= '<input min=10 id="' . $_REQUEST['name_input'] . '_videoWidth" class="bxhtmled-90-input" type="number" value="' . $_1219281716[$_REQUEST['name_input'] . '_videoWidth'] . '" name="' . $_REQUEST['name_input'] . '_videoWidth">';
            } else {
                $_1057032277 .= '<input min=10 id="' . $_REQUEST['name_input'] . '_videoWidth" class="bxhtmled-90-input" type="number" value="720" name="' . $_REQUEST['name_input'] . '_videoWidth">';
            }
            $_1057032277 .= '</td>';
            $_1057032277 .= '</tr>';
            $_1057032277 .= '<tr><td colspan="2">&nbsp;</td></tr>';
            $_1057032277 .= '<tr><td colspan="2">';
            $_1057032277 .= \Bitrix\Main\UI\FileInput::createInstance(array('name' => $_REQUEST['name_input'] . '[n#IND#]', 'description' => true, 'upload' => true, 'allowUpload' => 'F', 'allowUploadExt' => $_1227432844, 'medialib' => true, 'fileDialog' => true, 'cloud' => true, 'delete' => true, 'edit' => true))->show($_REQUEST['name_input']);
            $_1057032277 .= '</td></tr>';
            $_1057032277 .= '</table>';
            $_1057032277 .= '</form>';
            echo $_1057032277;
        }
    }

    public function saveImages()
    {
        if (isset($_REQUEST['name_input'])) {
            $_2075150870 = false;
            $_1792075593 = array();
            $_1619115352 = array();
            $_1245737537 = $_REQUEST[$_REQUEST['name_input'] . '_collection'];
            if ($_REQUEST[$_REQUEST['name_input'] . '_addTagsBr'] == 'Y') {
                $_594569437[$_REQUEST['name_input'] . '_addTagsBr'] = 'Y';
            } else {
                $_594569437[$_REQUEST['name_input'] . '_addTagsBr'] = 'N';
            }
            if ($_1245737537) {
                $_594569437[$_REQUEST['name_input'] . '_collection'] = $_1245737537;
            }
            static::setCookieHtmlEditor($_594569437);
            if (is_array($_REQUEST[$_REQUEST['name_input']])) {
                foreach ($_REQUEST[$_REQUEST['name_input']] as $_903895832 => $_1719288637) {
                    if (is_array($_1719288637)) {
                        $_1078061823 = '';
                        if (!strpos($_1719288637['tmp_name'], 'upload/tmp')) {
                            $_1078061823 = '/upload/tmp';
                        }
                        $_1603260094 = \CFile::MakeFileArray($_1078061823 . $_1719288637['tmp_name'], $_1719288637['type']);
                        $_1603260094['name'] = $_1719288637['name'];
                        $_1603260094['MODULE_ID'] = self::MODULE_ID;
                        if (!empty($_REQUEST[$_REQUEST['name_input'] . '_descr'][$_903895832])) {
                            $_1603260094['description'] = $_REQUEST[$_REQUEST['name_input'] . '_descr'][$_903895832];
                        }
                        $_1573662143 = '';
                        $_1573662143 = \CFile::SaveFile($_1603260094, self::MODULE_ID);
                        if (!empty($_1573662143)) {
                            if (!empty($_1245737537)) {
                                $_1752540251 = array('ID' => $_1573662143, 'NAME' => $_1603260094['name'], 'DESCRIPTION' => $_1603260094['description'], 'KEYWORDS' => '', 'ID_COLLECTION' => $_1245737537);
                                static::addFileMediaLib($_1752540251);
                            }
                            $_1619115352[] = $_1573662143;
                        }
                    } elseif (!empty($_1719288637)) {
                        $_1442594344 = explode('/', $_1719288637);
                        $_1744695654 = \CFile::GetList(array('ID' => 'asc'), array('SUBDIR' => $_1442594344['2'] . '/' . $_1442594344['3'], 'FILE_NAME' => $_1442594344['4']));
                        if ($_1603260094 = $_1744695654->Fetch()) {
                            $_1619115352[] = $_1603260094['ID'];
                        }
                    }
                }
            }
            if (!empty($_1619115352) && is_array($_1619115352)) {
                $_1744695654 = \CFile::GetList(array('ID' => 'asc'), array('@ID' => implode(',', $_1619115352)));
                while ($_1603260094 = $_1744695654->Fetch()) {
                    $_162268917['NAME'] = $_1603260094['FILE_NAME'];
                    $_162268917['DESCRIPTION'] = $_1603260094['DESCRIPTION'];
                    $_162268917['SRC'] = '/upload/' . $_1603260094['SUBDIR'] . '/' . $_1603260094['FILE_NAME'];
                    $_162268917['HEIGHT'] = $_1603260094['HEIGHT'];
                    $_162268917['WIDTH'] = $_1603260094['WIDTH'];
                    $_1792075593[] = $_162268917;
                }
                $_2075150870 = json_encode($_1792075593);
            }
            echo $_2075150870;
        }
    }

    public static function setCookieHtmlEditor($_2127951999)
    {
        static::$_1301099690 = static::getServerName();
        if (static::$_1301099690 === false) {
            static::log(static::EVENT_SERVER_NAME_ERROR, Loc::getMessage("SOTBIT_HTMLEDITORADDITION_V_NASTROYKAH_GLAVNOG") . static::SOTBIT_HTML_EDITOR_COOKIES . ' ' . Loc::getMessage("SOTBIT_HTMLEDITORADDITION_POLQZOVATELU_NE_USTA"));
        } else {
            setcookie(static::SOTBIT_HTML_EDITOR_COOKIES, serialize($_2127951999), false, '/', static::$_1301099690, false, true);
        }
    }

    public static function addFileMediaLib($_1690720192)
    {
        if (\Bitrix\Main\Loader::includeModule('fileman')) {
            CMedialib::Init();
            global $DB;
            if (CModule::IncludeModule('search')) {
                $_98980496 = stemming($_1690720192['NAME'] . ' ' . $_1690720192['DESCRIPTION'] . ' ' . $_1690720192['KEYWORDS'], LANGUAGE_ID);
                if (count($_98980496) > 0) $_1690720192['SEARCHABLE_CONTENT'] = '{' . implode('}{', array_keys($_98980496)) . '}'; else $_1690720192['SEARCHABLE_CONTENT'] = '';
            }
            $_1690720192['SOURCE_ID'] = $_1690720192['ID'];
            $_1690720192['~DATE_CREATE'] = $DB->CurrentTimeFunction();
            $_1690720192['~DATE_UPDATE'] = $DB->CurrentTimeFunction();
            $_1690720192['ITEM_TYPE'] = '';
            unset($_1690720192['ID']);
            $_2061125065 = $DB->Add('b_medialib_item', $_1690720192, array('DESCRIPTION', 'SEARCHABLE_CONTENT'));
            $_1347909109 = 'INSERT INTO b_medialib_collection_item(ITEM_ID, COLLECTION_ID) ' . 'SELECT ' . intVal($_2061125065) . ', ID ' . 'FROM b_medialib_collection ' . 'WHERE ID in (' . $_1690720192['ID_COLLECTION'] . ')';
            $_1000966794 = $DB->Query($_1347909109, false, 'FILE: ' . __FILE__ . '<br> LINE: ' . __LINE__);
        }
    }

    public function saveVideo()
    {
        if (isset($_REQUEST['name_input'])) {
            $_2075150870 = false;
            $_1792075593 = array();
            $_1619115352 = array();
            $_1245737537 = $_REQUEST[$_REQUEST['name_input'] . '_collection'];
            if ($_REQUEST[$_REQUEST['name_input'] . '_addTagsBr'] != '') {
                $_594569437[$_REQUEST['name_input'] . '_addTagsBr'] = 'Y';
            }
            if ($_REQUEST[$_REQUEST['name_input'] . '_videoHeight'] != '') {
                $_594569437[$_REQUEST['name_input'] . '_videoHeight'] = $_REQUEST[$_REQUEST['name_input'] . '_videoHeight'];
            }
            if ($_REQUEST[$_REQUEST['name_input'] . '_videoWidth'] != '') {
                $_594569437[$_REQUEST['name_input'] . '_videoWidth'] = $_REQUEST[$_REQUEST['name_input'] . '_videoWidth'];
            }
            if ($_1245737537) {
                $_594569437[$_REQUEST['name_input'] . '_collection'] = $_1245737537;
            }
            static::setCookieHtmlEditor($_594569437);
            if (is_array($_REQUEST[$_REQUEST['name_input']])) {
                foreach ($_REQUEST[$_REQUEST['name_input']] as $_903895832 => $_1719288637) {
                    if (is_array($_1719288637)) {
                        $_1078061823 = '';
                        if (!strpos('/upload/tmp', $_1719288637['tmp_name'])) {
                            $_1078061823 = '/upload/tmp';
                        }
                        $_1603260094 = \CFile::MakeFileArray($_1078061823 . $_1719288637['tmp_name'], $_1719288637['type']);
                        $_1603260094['name'] = $_1719288637['name'];
                        $_1603260094['MODULE_ID'] = self::MODULE_ID;
                        if (!empty($_REQUEST[$_REQUEST['name_input'] . '_descr'][$_903895832])) {
                            $_1603260094['description'] = $_REQUEST[$_REQUEST['name_input'] . '_descr'][$_903895832];
                        }
                        $_1573662143 = '';
                        $_1573662143 = \CFile::SaveFile($_1603260094, self::MODULE_ID);
                        if (!empty($_1573662143)) {
                            if (!empty($_1245737537)) {
                                $_1752540251 = array('ID' => $_1573662143, 'NAME' => $_1603260094['name'], 'DESCRIPTION' => $_1603260094['description'], 'KEYWORDS' => '', 'ID_COLLECTION' => $_1245737537);
                                static::addFileMediaLib($_1752540251);
                            }
                            $_1619115352[] = $_1573662143;
                        }
                    } elseif (!empty($_1719288637)) {
                        $_1442594344 = explode('/', $_1719288637);
                        $_1744695654 = \CFile::GetList(array('ID' => 'asc'), array('SUBDIR' => $_1442594344['2'] . '/' . $_1442594344['3'], 'FILE_NAME' => $_1442594344['4']));
                        if ($_1603260094 = $_1744695654->Fetch()) {
                            $_1619115352[] = $_1603260094['ID'];
                        }
                    }
                }
            }
            if (!empty($_1619115352) && is_array($_1619115352)) {
                $_1744695654 = \CFile::GetList(array('ID' => 'asc'), array('@ID' => implode(',', $_1619115352)));
                while ($_1603260094 = $_1744695654->Fetch()) {
                    $_162268917['NAME'] = $_1603260094['FILE_NAME'];
                    $_162268917['DESCRIPTION'] = $_1603260094['DESCRIPTION'];
                    $_162268917['SRC'] = '/upload/' . $_1603260094['SUBDIR'] . '/' . $_1603260094['FILE_NAME'];
                    $_162268917['HEIGHT'] = $_1603260094['HEIGHT'];
                    $_162268917['WIDTH'] = $_1603260094['WIDTH'];
                    $_1792075593[] = $_162268917;
                }
                $_2075150870 = json_encode($_1792075593);
            }
            echo $_2075150870;
        }
    }
}