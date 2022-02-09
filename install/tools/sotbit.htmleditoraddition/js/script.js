function kit_htmleditor_serialize(form) {
    if (!form || form.nodeName !== "FORM") {
        return;
    }
    var i, j, q = [];
    for (i = 0; i < form.elements.length; i = i + 1) {
        if (form.elements[i].name === "") {
            continue;
        }
        switch (form.elements[i].nodeName) {
        case 'INPUT':
            switch (form.elements[i].type) {
            case 'text':
            case 'hidden':
            case 'password':
            case 'button':
            case 'reset':
            case 'submit':
                q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                break;
            case 'checkbox':
            case 'radio':
                if (form.elements[i].checked) {
                    q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                }                        
                break;
            case 'file':
                break;
            }
            break;             
        case 'TEXTAREA':
            q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
            break;
        case 'SELECT':
            switch (form.elements[i].type) {
            case 'select-one':
                q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                break;
            case 'select-multiple':
                for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
                    if (form.elements[i].options[j].selected) {
                        q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].options[j].value));
                    }
                }
                break;
            }
            break;
        case 'BUTTON':
            switch (form.elements[i].type) {
            case 'reset':
            case 'submit':
            case 'button':
                q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
                break;
            }
            break;
        }
    }
    return q.join("&");
}

BX.addCustomEvent('OnEditorInitedBefore',function(editor){
    var _this=this; 
    var _class = 'kit_htmleditor';
    
    var pageUrl = window.location.pathname;

    this.AddButton({  //loading images
        iconClassName: 'bxhtmled-button-kit-add-img',
        src: '/bitrix/tools/kit.htmleditoraddition/images/kit_add_img_icon.png',
        id: 'kit-add-img',
        name: BX.message('KIT_HTML_EDITOR_MODAL_IMAGES_TITLE'),
        handler:function(e){
            var KitDialogAddImg = new BX.CDialog({
                title: BX.message('KIT_HTML_EDITOR_MODAL_IMAGES_TITLE'),
                content_url: '/bitrix/tools/kit.htmleditoraddition/include/ajax/loadImg.php',
                content_post: 'ajax=yes&action=openWindow&name_input='+_class,
                min_width:400,
                min_height:400,
                zIndex: 3008,
                buttons: [
                    //BX.CDialog.prototype.btnSave,
                    {
                        title: BX.message('KIT_HTML_EDITOR_MODAL_IMAGES_BTN_LOADIMG'),
                        name: 'loadImg',
                        id: 'loadImg',
                        action: function () {
                            var KitFormReturn = kit_htmleditor_serialize(document.forms[_class+"_form"]);
                            var KitAddTagsBr = document.getElementsByName(_class+'_addTagsBr').item(0).checked;

                            var _thisBtn = this;

                            BX.ajax({
                                url: '/bitrix/tools/kit.htmleditoraddition/include/ajax/loadImg.php',
                                method: 'POST',
                                dataType: 'json',
                                data: 'ajax=yes&action=saveImg&name_input='+ _class + '&' +KitFormReturn,
                                onsuccess: function(data){
                                    if(data)
                                    {
                                        //var content = _this.GetContent();     /*Insert content to end of document*/

                                        data.forEach(function(arFile, index, data)
                                        {
                                            if(KitAddTagsBr)
                                            {
                                                $img = '<br/><img src=' + arFile['SRC'] +' height="' + arFile['HEIGHT']  +'" width="' + arFile['WIDTH']  + '" alt="' + arFile['DESCRIPTION'] + '" title="' + arFile['DESCRIPTION'] + '">';
                                            }
                                            else
                                            {
                                                $img = '<img src=' + arFile['SRC'] + ' height="' + arFile['HEIGHT']  +'" width="' + arFile['WIDTH']  + '" alt="' + arFile['DESCRIPTION'] + '" title="' + arFile['DESCRIPTION'] + '">';
                                            }

                                            //content = content + $img;        /*Insert content to end of document*/

                                            _this.selection.InsertHTML($img); /*Insert content where cursor*/
                                        });

                                        //_this.SetContent(content, true);   /*Insert content to end of document*/
                                        //_this.ReInitIframe();             /*Insert content to end of document*/


                                        _thisBtn.parentWindow.Close();

                                    }

                                },
                            });


                        }
                    },
                    BX.CDialog.prototype.btnCancel,
                ]
            });
            KitDialogAddImg.Show();
        }
    });

    this.AddButton({  //loading video
        iconClassName: 'bxhtmled-button-kit-add-video',
        src: '/bitrix/tools/kit.htmleditoraddition/images/kit_add_video_icon.png',
        id: 'kit-add-video',
        name: BX.message('KIT_HTML_EDITOR_MODAL_VIDEO_TITLE'),
        handler:function(e){
            var KitDialogAddVideo = new BX.CDialog({
                title: BX.message('KIT_HTML_EDITOR_MODAL_VIDEOS_TITLE'),
                content_url: '/bitrix/tools/kit.htmleditoraddition/include/ajax/loadVideo.php',
                content_post: 'ajax=yes&action=openWindow&name_input='+_class,
                min_width:400,
                min_height:400,
                zIndex: 3008,
                buttons: [
                    //BX.CDialog.prototype.btnSave,
                    {
                        title: BX.message('KIT_HTML_EDITOR_MODAL_VIDEOS_BTN_LOADIMG'),
                        name: 'loadVideo',
                        id: 'loadVideo',
                        action: function () {
                            var KitFormReturn = kit_htmleditor_serialize(document.forms[_class+"_form"]);
                            var KitAddTagsBr = document.getElementsByName(_class+'_addTagsBr').item(0).checked;
                            var KitVideoHeight = document.getElementsByName(_class+'_videoHeight').item(0).value;
                            var KitVideoWidth = document.getElementsByName(_class+'_videoWidth').item(0).value;

                            var _thisBtn = this;

                            BX.ajax({
                                url: '/bitrix/tools/kit.htmleditoraddition/include/ajax/loadVideo.php',
                                method: 'POST',
                                dataType: 'json',
                                data: 'ajax=yes&action=saveVideo&name_input='+ _class + '&' +KitFormReturn,
                                onsuccess: function(data){
                                    if(data)
                                    {
                                        //var content = _this.GetContent();     /*Insert content to end of document*/

                                        data.forEach(function(arFile, index, data)
                                        {
                                            if(KitAddTagsBr)
                                            {
                                                $video = '<br><iframe width="'+KitVideoWidth+'" height="'+KitVideoHeight+'" title="" src="' + arFile['SRC'] +'" frameborder="0" allowfullscreen=""></iframe>';
                                            }
                                            else
                                            {
                                                $video = '<iframe width="'+KitVideoWidth+'" height="'+KitVideoHeight+'" title="" src="' + arFile['SRC'] +'" frameborder="0" allowfullscreen=""></iframe>';
                                            }

                                            //content = content + $img;        /*Insert content to end of document*/

                                            _this.selection.InsertHTML($video); /*Insert content where cursor*/
                                        });
                                        //_this.SetContent(content, true);   /*Insert content to end of document*/
                                        //_this.ReInitIframe();             /*Insert content to end of document*/
                                        _thisBtn.parentWindow.Close();
                                    }
                                },
                            });
                        }
                    },
                    BX.CDialog.prototype.btnCancel,
                ]
            });
            KitDialogAddVideo.Show();
        }
    });
}); 
 