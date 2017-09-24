$(document).ready(function()
{
	"use strict";
	$('.heart').click(function()
	{
		
		$(this).css("background-position","");
		var D=$(this).attr("rel");
	   
		if(D === 'like') 
		{      
		$(this).addClass("heartAnimation").attr("rel","unlike");
		
		}
		else
		{
		$(this).removeClass("heartAnimation").attr("rel","like");
		$(this).css("background-position","left");
		}
	
	
	});
});
