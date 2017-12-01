/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'zh';//語系指定
	//config.skin = 'kama'; //換佈景效果，選項：v2,office2003  
	//config.uiColor = '#AADC6E'; //換背景色
	//config.width = 500; //編輯區塊寬度設定
    config.height = 500; //編輯區塊高度設定
    //允許檔案上傳相關設定
	config.filebrowserBrowseUrl = 'ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = 'ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl = 'ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
