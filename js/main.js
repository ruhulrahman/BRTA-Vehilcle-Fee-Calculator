$(document).ready(function(){
	$('#nav').slicknav();
	
	
	$(".ruhul_area").mouseover(function(){
		$(".ruhul").show("slow");
		$(".ruhul_area img").show("slow");
	});
	$(".ruhul_area").mouseout(function(){
		$(".ruhul").hide();
		$(".ruhul_area img").hide();
	});



});