// JavaScript Document
window.onload=function(){
	n_onload();
}
function n_onload(){
	var waiting=document.getElementsByClassName("waiting1");
	var j;
	for (j = 0; j<waiting.length;j++) {
   		waiting[j].style.display="block";
 	};
	var article_title_list=document.getElementsByClassName("article-title");
	var auther_name_list=document.getElementsByClassName("auther-name");
	var publish_date_list=document.getElementsByClassName("publish-date");
	var publish_time_list=document.getElementsByClassName("publish-time");
	var num_heart_list=document.getElementsByClassName("num-heart");
	var num_comment_list=document.getElementsByClassName("num-comment");
	var article_source_list=document.getElementsByClassName("article-source")	
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	var i=0;
	if(xmlhttp!=null)
	{
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{				
					var data=xmlhttp.responseText;
					var str=data.split('}');
					if(str.length==1)
					{
						alert(data);
						return;
					}
						
					for(i;i<10;i++)
					{	
						str[i]+="}";
						str[i]=JSON.parse(str[i]);
						article_title_list[i].innerHTML=str[i]['title'];
						str[i]['autherID']="No."+str[i]['autherID'];
						auther_name_list[i].innerHTML=str[i]['autherID'];
						publish_date_list[i].innerHTML=str[i]['date_time'].substring(0,10);
						publish_time_list[i].innerHTML=str[i]['date_time'].substring(11);
						num_heart_list[i].innerHTML=str[i]['arheart'];
						num_comment_list[i].innerHTML=str[i]['arcomment'];
						article_source_list.innerHTML=str[i]['arsource'];
					}
					for (j = 0; j<waiting.length;j++) {
   						waiting[j].style.display="none";
 					};
				}
			}
	xmlhttp.open("GET","http://localhost/php/widgets_onload.php?index=1&source='王者荣耀'",true);
	xmlhttp.send();
	}
}
