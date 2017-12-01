bnum1 = $(".extra a").length;
bnum2 = $(".extra span").length;
bmax = 0;
bnum = bnum1+bnum2;
//if(bnum1 > bnum2)
$(".extra a").css("display","none");
$(".extra span").css("display","none");
$(".extra a:eq(0)").css("display","block");
$(".extra span:eq(0)").css("display","block");
setInterval(function(){
  bchange();
}, 3000);
function bchange(){
  $(".extra a:eq("+bmax+")").css("display","none");
  $(".extra span:eq("+bmax+")").css("display","none");
  bmax++;
  if(bmax == bnum)
    bmax = 0;
  $(".extra a:eq("+(bmax)+")").css("display","block"); 
  $(".extra span:eq("+(bmax)+")").css("display","block");
  //console.log(bnum);
  //console.log(bmax);
}
