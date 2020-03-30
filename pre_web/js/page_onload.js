window.onload=function(){
	console.log("读取数据库");
	z_onload();
	n_onload();
}

function n_onload(){
	var waiting=document.getElementsByClassName("waiting1");
	var j;
	for (j = 0; j<waiting.length;j++) {
   		waiting[j].style.display="block";
 	};
//	console.log("读取数据库");
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
					for(i;i<3;i++)
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
					for (var j = 0; j<waiting.length;j++) {
   						waiting[j].style.display="none";
 					};
				}
			}
	xmlhttp.open("GET","http://localhost/php/n_load.php",true);
	xmlhttp.send();
	}
}
function z_onload(){
	var waiting=document.getElementsByClassName("waiting2");
	for (var j = 0; j<waiting.length;j++) {
   		waiting[j].style.display="block";
 	};
	
	var z_article_title_list=document.getElementsByClassName("z-article-title");
	var z_auther_name_list=document.getElementsByClassName("z-auther-name");
	var z_publish_date_list=document.getElementsByClassName("z-publish-date");
	var z_publish_time_list=document.getElementsByClassName("z-publish-time");
	var z_num_heart_list=document.getElementsByClassName("z-num-heart");
	var z_num_comment_list=document.getElementsByClassName("z-num-comment");
	var z_article_source_list=document.getElementsByClassName("z-article-source");
	
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
					for(i;i<3;i++)
					{	
						str[i]+="}";
						str[i]=JSON.parse(str[i]);
						z_article_title_list[i].innerHTML=str[i]['title'];
						str[i]['autherID']="No."+str[i]['autherID'];
						z_auther_name_list[i].innerHTML=str[i]['autherID'];
						z_publish_date_list[i].innerHTML=str[i]['date_time'].substring(0,10);
						z_publish_time_list[i].innerHTML=str[i]['date_time'].substring(11);
						z_num_heart_list[i].innerHTML=str[i]['arheart'];
						z_num_comment_list[i].innerHTML=str[i]['arcomment'];
						z_article_source_list.innerHTML=str[i]['arsource'];
					}	
					for (var j = 0; j<waiting.length;j++) {
   						waiting[j].style.display="none";
 					};
				}
			}
	xmlhttp.open("GET","http://localhost/php/z_load.php",true);
	xmlhttp.send();
	}
}

/*1、If the state is UNSENT or OPENED, return 0.（如果状态是UNSENT或者OPENED，返回0）
2、If the error flag is set, return 0.（如果错误标签被设置，返回0）
3、Return the HTTP status code.（返回HTTP状态码）
如果在HTTP返回之前就出现上面两种情况，就出现0了。

先说两个button，一个是url是：file:///E:/test2.html，另外一个是：http://www.baidu.com。



第一个button的url访问只是本地打开没有通过服务器，自己可以用Wireshark捉包（感谢某位高人指点）。

这里面还有一个问题，就是xmlhttp.readyState一直会变，

1: 服务器连接已建立

2: 请求已接收  

3: 请求处理中  

4: 请求已完成，且响应已就绪。*/