function share(obj)
{
        var url = encodeURIComponent(document.URL)+"?from="+obj;
        var title = encodeURIComponent(document.title);
        switch(obj)
        {
            case 0:
                window.open("http://v.t.sina.com.cn/share/share.php?appkey=793752398&title="+title+"&url="+url+"&source=bookmark","_blank","width=450,height=400");break;
            case 1:
                window.open("http://www.facebook.com/sharer/sharer.php?u="+url+"&t="+title,"_blank","width=650,height=400");break;
            case 2:
                window.open("http://twitter.com/home?status="+url+"%20"+title,"_blank","width=650,height=400");break;
            case 3:
                window.open("http://www.douban.com/recommend/?url="+url+"&title="+title,"_blank","width=450,height=400");break;
            case 4:
                window.open("http://www.kaixin001.com/repaste/bshare.php?rtitle="+title+"&rurl="+url+"&rcontent=","_blank","width=450,height=400");break;
            case 5:
                window.open("http://share.renren.com/share/buttonshare.do?link="+url+"&title="+title,"_blank","width=450,height=400");break;
            case 6:
                window.open("http://v.t.qq.com/share/share.php?title="+title+"&url="+url+"&source=1000000&appkey=2e21c3153a32ad0af309c74ed3bf6043&site=http://www.passit.cn&pic=","_blank","width=450,height=400");break;
            case 7:
                window.open("http://www.plurk.com/?qualifier=shares&status="+url+"%20("+title+")","_blank","width=450,height=400");break;
            case 8:
                window.open("http://myweb.cn.yahoo.com/popadd.html?url="+url+"&title="+title,"_blank","width=450,height=400");break;
            case 9:
                window.open("http://share.jianghu.taobao.com/share/addShare.htm?url="+url+"&title="+title+"&content","_blank","width=450,height=400");break;
            case 10:
                window.open("http://www.hemidemi.com/user_bookmark/new?url="+url+"&title="+title+"&via=&description=","_blank","width=450,height=400");break;                
            case 11:
                window.open("http://delicious.com/save?url="+url+"&title="+title+"&notes","_blank","width=450,height=400");break;
            case 12:
                window.open("http://t.sohu.com/third/post.jsp?&url="+url+"&title="+title+"&content=utf-8&pic=&source=VCfjCRgKSw","_blank","width=450,height=400");break;
            case 13:
                window.open("http://t.ifeng.com/interface.php?_c=share&_a=share&sourceUrl="+url+"&title="+title+"&pic=&source=Passit","_blank","width=450,height=400");break;
            case 14:
                window.open("http://profile.live.com/badge?url="+url+"?from=msn&title="+title+"&description=&wa=wsignin1.0&screenshot=","_blank","width=450,height=400");break;                
            case 15:
                window.open("http://www.google.com/bookmarks/mark?op=add&bkmk="+url+"&title="+title,"_blank","width=450,height=400");break;
            case 16:
                window.open("https://skydrive.live.com/sharefavorite.aspx/.SharedFavorites??url="+url+"&title="+title,"_blank","width=450,height=400");break;
            case 17:
                window.open("http://tk.mop.com/api/post.htm?url="+url+"&title="+title+"&desc=","_blank","width=450,height=400");break;
            case 18:
                window.open("http://fanfou.com/sharer?u="+url+"&t="+title+"&d=","_blank","width=450,height=400");break;
        }
}