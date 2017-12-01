// JavaScript Document

function Marquees(mq, tl)
{
	this.marquees = document.getElementById(mq);
	this.templayer = document.getElementById(tl);
	this.element = this.marquees;
	this.marqueesWidth = 480;
	this.preLeft = 0;
	this.marquees.stopscroll = false;
	
	if(this.marquees.innerHTML == "") return;
	
	this.marquees.onmouseover = new Function("this.stopscroll=true");
	this.marquees.onmouseout = new Function("this.stopscroll=false");
	
	while(this.templayer.offsetWidth < this.marqueesWidth)
	{
		this.templayer.innerHTML += this.marquees.innerHTML;
	}
	//this.marquees.innerHTML = this.templayer.innerHTML + this.templayer.innerHTML;
}

Marquees.prototype = {
	scrollLeft: function ()
	{
		if(this.marquees.stopscroll == true) return;
		if(this.marquees.innerHTML == "") return;
		
		this.preLeft = this.marquees.scrollLeft;
		this.marquees.scrollLeft += 1;
		
		if(this.preLeft == this.marquees.scrollLeft)
		{
			//this.marquees.scrollLeft = this.templayer.offsetWidth - this.marqueesWidth + 1;
			this.marquees.scrollLeft = 0;
		}
	}
};

function checkVoltiForm(obj)
{
	if(obj.page.value == "")
	{
		alert("請輸入頁數！");
		return false;
	}
	if(isNaN(obj.page.value))
	{
		alert("頁數應為數字！");
		return false;
	}
	return true;
}

function checkLoginForm(form){
	if(form.userid.value==""){
		alert("你好像忘了輸入用戶名啦﹗");
		form.userid.focus();
		return false;
	}

	if(form.password.value==""){
		alert("你好像忘了輸入用戶密碼啦﹗");
		form.password.focus();
		return false;
	}
}