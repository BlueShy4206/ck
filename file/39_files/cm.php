window._cm = {};
window._cm.tmpl = {};
window._cm.lang = {};
window._cm.path = {};
window._cm.setting = {};window._cm.tmpl.upload_column = function() {/* <div class="row-fluid" style="margin-bottom: 5px;">  <button type="button" title="{{lang.UPLOAD_FILE_UPLOAD_BTN_TITLE}}" class="btn btn-default" data-cmfield-func="site-file-upload">    <i class="glyphicon glyphicon-upload"></i>&nbsp;{{lang.UPLOAD_FILE_UPLOAD_BTN}}    <span data-cmfunc="process"></span>  </button></div><ul class="row-fluid file-upload-list" data-cmfield-func="file-list" style="margin: 15px 0px;">{{#files}}  {{> javascript_upload_files}}{{/files}}</ul>{{&upload_field}} */}.toString();
window._cm.tmpl.upload_modal = function() {/* <div id="{{mId}}" class="modal fade{{#mClass}} {{mClass}}{{/mClass}}" tabindex="-1" role="dialog" aria-hidden="true">  <div class="modal-dialog{{#large}} modal-lg{{/large}}{{#small}} modal-sm{{/small}}">    <div class="modal-content">      {{&mTop}}      <div class="modal-header">        <button type="button" class="close">×</button>        {{#mSHeader}}<h3>{{&mHeader}}&nbsp;<small>{{&mSHeader}}</small></h3>{{/mSHeader}}        {{^mSHeader}}<h3>{{&mHeader}}</h3>{{/mSHeader}}      </div>      <div class="modal-body">      {{#mBody}}{{&mBody}}{{/mBody}}      </div>      <div class="modal-footer">{{&mButton}}</div>      {{&mBottom}}    </div>  </div></div> */}.toString();
window._cm.tmpl.upload_files = function() {/* <li data-cmfield-data-file="{{file}}"  data-cmfield-func="file-item" class="media">  <a class="pull-left thumbnail" target="_blank" href="{{preview}}">{{&thumbnail}}</a>  <div class="media-body" data-cmfield-params='{{&params}}'>    <div class="btn-group">      <a class="btn btn-default" target="_blank" href="{{preview}}"><i class="icofont-eye-open"></i>&nbsp;{{lang.UPLOAD_FILE_PREVIEW_BTN}}</a>      <button type="button" class="btn btn-danger btn-small" data-cmfield-func="file-remove"><i class="icofont-trash"></i>&nbsp;{{lang.UPLOAD_FILE_REMOVE_BTN}}</button>    </div>  </div></li> */}.toString();
window._cm.tmpl.blueimpGallery = function() {/* <div id="blueimp-gallery" class="blueimp-gallery">  <div class="slides"></div>  <h3 class="title"></h3>  <a class="prev">‹</a>  <a class="next">›</a>  <a class="close">×</a>  <a class="play-pause"></a>  <ol class="indicator"></ol>  <div class="modal fade">    <div class="modal-dialog">      <div class="modal-content">        <div class="modal-header">          <button type="button" class="close" aria-hidden="true">&times;</button>          <h4 class="modal-title"></h4>        </div>        <div class="modal-body next"></div>        <div class="modal-footer">          <button type="button" class="btn btn-default pull-left prev">            <i class="glyphicon glyphicon-chevron-left"></i>            {{prevText}}          </button>          <button type="button" class="btn btn-primary next">            {{nextText}}            <i class="glyphicon glyphicon-chevron-right"></i>          </button>        </div>      </div>    </div>  </div></div> */}.toString();
window._cm.tmpl.modal = function() {/* <div id="{{id}}" class="modal fade{{#large}} bs-example-modal-lg{{/large}}{{#small}} bs-example-modal-sm{{/small}}" tabindex="-1" role="dialog" aria-hidden="true"{{#name}} aria-labelledby="{{name}}"{{/name}}{{#attr}} {{&attr}}{{/attr}}>  <div class="modal-dialog{{#large}} modal-lg{{/large}}{{#small}} modal-sm{{/small}}">    <div class="modal-content">      <div class="modal-header">        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>        <h4 class="modal-title">{{headline}}</h4>      </div>      <div class="modal-body">{{&body}}</div>      <div class="modal-footer">{{&footer}}</div>    </div>  </div></div> */}.toString();
window._cm.lang.VALIDATE_MAX_WORDS = '輸入不能超過 {0} 個字';
window._cm.lang.VALIDATE_MIN_WORDS = '必須輸入超過 {0} 個字';
window._cm.lang.VALIDATE_RANGE_WORDS = '輸入的字數必須介於 {0} 到 {1} 個字';
window._cm.lang.VALIDATE_PHONE = '請輸入正確的電話格式 範例：02-11111111';
window._cm.lang.VALIDATE_CELLPHONE = '請輸入正確的手機格式 範例：0911-111-111';
window._cm.lang.VALIDATE_ENG = '這個欄位只能輸入英文字母';
window._cm.lang.VALIDATE_ENG_NUM = '這個欄位只能輸入英文字母和數字';
window._cm.lang.VALIDATE_FIXED_LENGTH = '這個欄位只能固定輸入 {0} 個字';
window._cm.lang.VALIDATE_ROC_CITIZEN_ID = '請輸入正確的身分證字號';
window._cm.lang.VALIDATE_ROC_CITIZEN_ID_A = '請輸入正確的身分證字號';
window._cm.lang.VALIDATE_REQUIRED = '這個欄位必填';
window._cm.lang.VALIDATE_REMOTE = '請完成這個欄位';
window._cm.lang.VALIDATE_EMAIL = '請輸入正確的E-mail格式 範例：example@example.com';
window._cm.lang.VALIDATE_URL = '請輸入正確的連結 範例：http://www.example.com/';
window._cm.lang.VALIDATE_DATE = '請輸入正確的日期格式 範例：2011-01-01';
window._cm.lang.VALIDATE_DATE_ISO = '請輸入正確的日期格式(ISO) 範例：2011-01-01';
window._cm.lang.VALIDATE_NUMBER = '這個欄位只能輸入數字';
window._cm.lang.VALIDATE_DIGITS = '這個欄位只能輸入整數';
window._cm.lang.VALIDATE_EQUAL_TO = '請再輸入一次相同的值';
window._cm.lang.VALIDATE_MAX_LENGTH = '請輸入少於 {0} 字';
window._cm.lang.VALIDATE_MIN_LENGTH = '請輸入至少 {0} 字';
window._cm.lang.VALIDATE_RANGE_LENGTH = '請輸入介於 {0} ~ {1} 個字元';
window._cm.lang.VALIDATE_RANGE = '請輸入介於 {0} ~ {1} 數字';
window._cm.lang.VALIDATE_MAX = '請輸入小於 {0} 的數字';
window._cm.lang.VALIDATE_MIN = '請輸入大於 {0} 的數字';
window._cm.lang.ERROR_MODULE_NOT_FOUND = '找不到指定的模組';
window._cm.lang.ALERT_MESSAGE_TITLE = '系統訊息';
window._cm.lang.CONFIRM_MESSAGE_TITLE = '請確認';
window._cm.lang.CONFIRM_MESSAGE_CLOSE_BUTTON = '取消';
window._cm.lang.CONFIRM_MESSAGE_CONFIRM_BUTTON = '確定';
window._cm.lang.UNLOAD_TITLE = '你確定要離開此頁嗎';
window._cm.lang.UNLOAD_CONFIRM = '你有尚未儲存的更新。你確定要繼續嗎？';
window._cm.lang.UNLOAD_CLOSE_BUTTON = '留在此頁';
window._cm.lang.UNLOAD_CONFIRM_BUTTON = '離開頁面';
window._cm.lang.UNLOAD_SAVE_BUTTON = '存檔後離開頁面';
window._cm.lang.EDITOR_LOADING = '<img src="styles/images/ajax_loader.gif" align="absmiddle" />&nbsp;編輯器載入中，請稍候';
window._cm.lang.UPLOAD_FILE_UPLOAD_BTN = '本機上傳';
window._cm.lang.UPLOAD_FILE_UPLOAD_BTN_TITLE = '從電腦上傳檔案';
window._cm.lang.UPLOAD_FILE_SELECT_BTN = '從檔案庫選擇';
window._cm.lang.UPLOAD_FILE_SELECT_BTN_TITLE = '從已經上傳的檔案選擇';
window._cm.lang.UPLOAD_FILE_RESORT_BTN = '排序反轉';
window._cm.lang.UPLOAD_FILE_RESORT_BTN_TITLE = '檔案上傳列表排序反轉';
window._cm.lang.UPLOAD_FILE_REMOVE_ALL_BTN = '全部移除';
window._cm.lang.UPLOAD_FILE_REMOVE_ALL_BTN_TITLE = '移除此欄位所有上傳檔案';
window._cm.lang.UPLOAD_FILE_PREVIEW_BTN = '預覽檔案';
window._cm.lang.UPLOAD_FILE_EDIT_BTN = '編輯檔案';
window._cm.lang.UPLOAD_FILE_REMOVE_BTN = '移除檔案';
window._cm.lang.UPLOAD_FILE_REMOVE_CONFIRM = '確定要移除這個檔案嗎?';
window._cm.lang.UPLOAD_FILE_ERROR_TOO_BIG = '檔案太大( %s)，超過限制的大小 %s';
window._cm.lang.UPLOAD_FILE_ERROR_TOO_SMALL = '檔案太小(%s)，小於限制的大小 %s';
window._cm.lang.UPLOAD_FILE_ERROR_COUNT = '檔案數量已經超過允許的數量，請取消一些檔案';
window._cm.lang.UPLOAD_FILE_ERROR_EXT = '檔案副檔名不在允許的副檔名內';
window._cm.lang.EDITOR_FILE_HEADLINE = '上傳的檔案列表';
window._cm.lang.REMOVE_FILE_SUCCESS = '刪除檔案完成';
window._cm.lang.CLOSE_BTN = '關閉';
window._cm.lang.PREV_IMAGE_BTN = '上一張';
window._cm.lang.NEXT_IMAGE_BTN = '下一張';
window._cm.lang.PAYMENT_REPLACE_CONFIRM = '這個動作將會移除已填寫的付款人資料，確定執行?';
window._cm.lang.ADDRESS_REPLACE_CONFIRM = '這個動作將會移除已填寫的收件人資料，確定執行?';

window._cm.path.ROOT = '';
window._cm.path.UPLOAD = 'upload/';
window._cm.path.UPLOAD_CACHE = 'upload/cache/';
window._cm.path.SITE_ROOT = 'website/';
window._cm.path.SITE_TMPL = 'website/tmpl/';
window._cm.path.SITE_PAGE = 'website/page/';
window._cm.path.SITE_JS = 'website/tmpl/js/';
window._cm.path.SITE_CSS = 'website/tmpl/css/';
window._cm.path.SITE_IMG = 'website/tmpl/img/';
window._cm.path.SITE_THEMES = 'website/tmpl/themes/';
window._cm.path.SITE_PLUGINS = 'website/tmpl/plugins/';
window._cm.path.HTTP_SERVER = 'http://eradio.ner.gov.tw/';
window._cm.setting.CURRENT_LANG = 'zh-tw';
window._cm.setting.MODE = 'debug_server';