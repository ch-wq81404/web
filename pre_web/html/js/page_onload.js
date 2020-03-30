// JavaScript Document
function page_onload(title){
	var article_title_list=document.getElementsByClassName("article-title");
	var auther_name_list=document.getElementsByClassName("auther-name");
	var publish_date_list=document.getElementsByClassName("publish-date");
	var publish_time_list=document.getElementsByClassName("publish-time");
	var num_heart=document.getElementById("arheart");
	var num_comment=document.getElementById("arcomment");
	var detail=document.getElementById("detail");
	
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	if(xmlhttp!=null)
	{
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var data=xmlhttp.responseText;
				var str=data.split('}');
				str[0]+="}";
				str[0]=JSON.parse(str[0]);
				article_title_list[0].innerHTML=str[0]['title'];
				str[0]['autherID']="No."+str[0]['autherID'];
				auther_name_list[0].innerHTML=str[0]['autherID'];
				publish_date_list[0].innerHTML=str[0]['date_time'].substring(0,10);
				publish_time_list[0].innerHTML=str[0]['date_time'].substring(11);
				num_heart.innerHTML=str[0]['arheart'];
				num_comment.innerHTML=str[0]['arcomment'];
				detail.innerHTML=str[0]['artext'];
			}
		}
		xmlhttp.open("GET","http://localhost/php/talk_load.php?title="+title,true);
		xmlhttp.send();
	}
}