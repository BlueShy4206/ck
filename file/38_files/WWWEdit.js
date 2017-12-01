///
///前台產生後台編輯按鈕
///

$(function () {
    if (window.addEventListener) {
        window.addEventListener("message", receiveMessage, false);
    } else {
        window.attachEvent("onmessage", receiveMessage);
    }

    function receiveMessage(event) {
        if (event.data == 'WWWEdit_Refresh') {
            WWWEdit_Refresh();
        } else if (event.data == 'WWWEdit_DoLogin') {
            WWWEdit_DoLogin();
        }
    }
    if (CheckisLogin()) {
        //編輯按鈕
        var sbutton = '<a class="WWWEdit_Edit">編輯頁面</a>';
        var button = $(sbutton).click(function () {
            Edit_Click()
        });
        $('#WWWEdit').append(button);



        //網站選單編輯按鈕
        var BE_Url_WebArchiveEdit = $('.footer_Login').attr("BE_Url_WebArchiveEdit");
        if (BE_Url_WebArchiveEdit != "") {
            var sbuttonWebArchiveEdit = '<a class="WWWEdit_HomeEdit" >網站選單編輯</a>';
            var buttonWebArchiveEdit = $(sbuttonWebArchiveEdit).click(function () {
                OpenEdit(BE_Url_WebArchiveEdit);
            });
            $('.footer_Login').append(buttonWebArchiveEdit);
        }


        //首頁編輯按鈕
        var HomeEdithref = $('.footer_Login').attr("BE_Url_HomeEdit");
        if (HomeEdithref != "") {
            var sbuttonHomeEdit = '<a class="WWWEdit_HomeEdit" >首頁編輯</a>';
            var buttonHomeEdit = $(sbuttonHomeEdit).click(function () {
                OpenEdit(HomeEdithref);
            });
            $('.footer_Login').append(buttonHomeEdit);
        }

        //登出按鈕
        var sbuttonLogout = '<a class="WWWEdit_Logout" >登出</a>';
        var buttonLogout = $(sbuttonLogout).click(function () {
            WWWEdit_Logout();
        });
        $('.footer_Login').append(buttonLogout);
    } else {
        //登入按鈕
        var sbuttonLogin = '<a class="WWWEdit_Login" >登入</a>';
        var buttonLogin = $(sbuttonLogin).click(function () {
            var href = $('.footer_Login').attr("BE_Url");
            $.fancybox.open({
                padding: 0,
                href: href,
                type: 'iframe',
                width: screen.width - 50,
                height: screen.height - 50
            });
        });
        $('.footer_Login').append(buttonLogin);
    }
})

function OpenEdit(sHref) {
    var now = new Date();
    $.cookie("WWWEditLoginTime", now);//如果有點選 再加上時間
    $.fancybox.open({
        padding: 0,
        href: sHref,
        type: 'iframe',
        width: screen.width - 50,
        height: screen.height - 50,
        afterClose: function () {
            WWWEdit_Refresh();
        }
    });
    
}
function Edit_Click() {
    var href = $('#WWWEdit').attr("BE_Url");
    if (CheckisLogin() && href != "") {
        OpenEdit(href);
        return;
    }
     alert("登入逾時");
    WWWEdit_Refresh();
}
function WWWEdit_Refresh() {
    $.fancybox.close();
    window.location.reload();
}
function WWWEdit_Logout() {
    $.cookie("WWWEditLoginTime", null);
    WWWEdit_Refresh();
}
function WWWEdit_DoLogin() {
    var now = new Date();
    $.cookie("WWWEditLoginTime", now);    
    WWWEdit_Refresh();
}
function CheckisLogin() {
    var WWWEditLoginTime = $.cookie("WWWEditLoginTime");
    if (WWWEditLoginTime != null) {
        var d1 = new Date(WWWEditLoginTime);
        var d2 = new Date();
        var d3 = (d2 - d1) ;
        if (d3 / 1000 <= 60 * 20) {
            return true;
        }
        return false;
    } else {
        return false;

    }
}
