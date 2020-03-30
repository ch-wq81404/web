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
}