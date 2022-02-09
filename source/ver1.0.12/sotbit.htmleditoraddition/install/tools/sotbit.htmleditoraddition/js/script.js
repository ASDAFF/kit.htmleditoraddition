function sotbit_htmleditor_serialize(form) {
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
    var _class = 'sotbit_htmleditor';      
    
    var pageUrl = window.location.pathname;

    this.AddButton({  //loading images
        iconClassName: 'bxhtmled-button-sotbit-add-img',
        src: '/bitrix/tools/sotbit.htmleditoraddition/images/sotbit_add_img_icon.png',
        id: 'sotbit-add-img',
        name: BX.message('SOTBIT_HTML_EDITOR_MODAL_IMAGES_TITLE'),
        handler:function(e){
            var SotbitDialogAddImg = new BX.CDialog({
                title: BX.message('SOTBIT_HTML_EDITOR_MODAL_IMAGES_TITLE'),
                content_url: '/bitrix/tools/sotbit.htmleditoraddition/include/ajax/loadImg.php',
                content_post: 'ajax=yes&action=openWindow&name_input='+_class,
                min_width:400,
                min_height:400,
                zIndex: 3008,
                buttons: [
                    //BX.CDialog.prototype.btnSave,
                    {
                        title: BX.message('SOTBIT_HTML_EDITOR_MODAL_IMAGES_BTN_LOADIMG'),
                        name: 'loadImg',
                        id: 'loadImg',
                        action: function () {
                            var SotbitFormReturn = sotbit_htmleditor_serialize(document.forms[_class+"_form"]);
                            var SotbitAddTagsBr = document.getElementsByName(_class+'_addTagsBr').item(0).checked;

                            var _thisBtn = this;

                            BX.ajax({
                                url: '/bitrix/tools/sotbit.htmleditoraddition/include/ajax/loadImg.php',
                                method: 'POST',
                                dataType: 'json',
                                data: 'ajax=yes&action=saveImg&name_input='+ _class + '&' +SotbitFormReturn,
                                onsuccess: function(data){
                                    if(data)
                                    {
                                        //var content = _this.GetContent();     /*Insert content to end of document*/

                                        data.forEach(function(arFile, index, data)
                                        {
                                            if(SotbitAddTagsBr)
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
            SotbitDialogAddImg.Show();
        }
    });

    this.AddButton({  //loading video
        iconClassName: 'bxhtmled-button-sotbit-add-video',
        src: '/bitrix/tools/sotbit.htmleditoraddition/images/sotbit_add_video_icon.png',
        id: 'sotbit-add-video',
        name: BX.message('SOTBIT_HTML_EDITOR_MODAL_VIDEO_TITLE'),
        handler:function(e){
            var SotbitDialogAddVideo = new BX.CDialog({
                title: BX.message('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_TITLE'),
                content_url: '/bitrix/tools/sotbit.htmleditoraddition/include/ajax/loadVideo.php',
                content_post: 'ajax=yes&action=openWindow&name_input='+_class,
                min_width:400,
                min_height:400,
                zIndex: 3008,
                buttons: [
                    //BX.CDialog.prototype.btnSave,
                    {
                        title: BX.message('SOTBIT_HTML_EDITOR_MODAL_VIDEOS_BTN_LOADIMG'),
                        name: 'loadVideo',
                        id: 'loadVideo',
                        action: function () {
                            var SotbitFormReturn = sotbit_htmleditor_serialize(document.forms[_class+"_form"]);
                            var SotbitAddTagsBr = document.getElementsByName(_class+'_addTagsBr').item(0).checked;
                            var SotbitVideoHeight = document.getElementsByName(_class+'_videoHeight').item(0).value;
                            var SotbitVideoWidth = document.getElementsByName(_class+'_videoWidth').item(0).value;

                            var _thisBtn = this;

                            BX.ajax({
                                url: '/bitrix/tools/sotbit.htmleditoraddition/include/ajax/loadVideo.php',
                                method: 'POST',
                                dataType: 'json',
                                data: 'ajax=yes&action=saveVideo&name_input='+ _class + '&' +SotbitFormReturn,
                                onsuccess: function(data){
                                    if(data)
                                    {
                                        //var content = _this.GetContent();     /*Insert content to end of document*/

                                        data.forEach(function(arFile, index, data)
                                        {
                                            if(SotbitAddTagsBr)
                                            {
                                                $video = '<br><iframe width="'+SotbitVideoWidth+'" height="'+SotbitVideoHeight+'" title="" src="' + arFile['SRC'] +'" frameborder="0" allowfullscreen=""></iframe>';
                                            }
                                            else
                                            {
                                                $video = '<iframe width="'+SotbitVideoWidth+'" height="'+SotbitVideoHeight+'" title="" src="' + arFile['SRC'] +'" frameborder="0" allowfullscreen=""></iframe>';
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
            SotbitDialogAddVideo.Show();
        }
    });
}); 
 