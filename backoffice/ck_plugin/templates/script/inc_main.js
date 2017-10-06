var frm	= {}; // Form
var vl	= {}; // Form
var to	= {}; // Tool
var ae	= {}; // Edit Form
var mn	= {}; // Menu
var tb	= {}; // Tab
var df	= {}; // Default
jQuery.fn.reset = function () {$(this).each (function() { this.reset(); });}
/*=============================================================================================
  :: _Form_ ::
=============================================================================================*/
frm.Login=function(){
	alert('Login');
}
frm.LoadOn=function(load){
	$(".loading").css('display','block');
}

frm.LoadOff=function(){
	$(".loading").css('display','none');
}

frm.MsgBox=function(text, color, delay){
  $('body').append('<div id="MsgBox" class="msgbox" title="!" style=""><br/><font color="'+color+'">'+text+'</font></div>');
  var horizontalPadding = 30;
  var verticalPadding = 30;
  $('#MsgBox').dialog({
    title:'',
    autoOpen:true,
    width:300,
    height:100,
    modal:true,
    // resizable:false,
    // autoResize:false,
    overlay:{opacity:0.5, background:'black'}
  }).width(300 - horizontalPadding).height(100 - verticalPadding);
  // if(delay>0){
    // setTimeout(function(){
      // frm.CloseBox('MsgBox');
    // },delay);
  // }
}

frm.AreaBox=function(id){
  $('body').append('<div id="'+id+'" style="display:none;"></div>');
  var horizontalPadding = 30;
  var verticalPadding = 30;
  $('#'+id).dialog({
    title:'',
	position: ['center',250],
    autoOpen:true,
    width:800,
    height:400,
    modal:true,
    resizable:false,
    autoResize:false,
    overlay:{opacity:0.5, background:'black'}
  }).width(800 - horizontalPadding).height(400 - verticalPadding);
}

frm.CloseBox=function(id){
  $('#'+id).dialog('close');
  $('#'+id).remove();
}
frm.checkboxAll=function(status){
	$(".checkboxAllSelect").each( function() {
		$(this).attr("checked",status);
	})
}

/*=============================================================================================
  :: _Tool_ ::
=============================================================================================*/
to.CreateButton=function(){
	$('.button .BtnSave').button({icons:{primary:'ui-icon-disk'},disabled:false});
	$('.button .BtnReset').button({icons:{primary:'ui-icon-trash'},disabled:false});
}

to.LoadTool=function(){
	to.CreateButton();
	$('.BtnSave').click(function(){});
	$('.BtnReset').click(function(){ $('#frm').reset(); return false;});
}
/*==================================================
  :: _Menu_ ::
==================================================*/
mn.Top=function(){
	if( $('.menu-sidebar').html() != '' ){
		$('.menu-sidebar').children().appendTo('.menu-top');
		$('.menu-sidebar').children().remove();
	}
	$('.sidebar').css('display', 'none');
	$('#switcher').css('background', 'url(../ck.plugin/templates/images/switcher-2col.gif) no-repeat center;');
}
mn.Left=function(){
	if( $('.menu-top').html != '' ){
		$('.menu-top').children().appendTo('.menu-sidebar');
		$('.menu-top').children().remove();
	}
	$('.sidebar').css('display', '');
	$('#switcher').css('background', 'url(../ck.plugin/templates/images/switcher-1col.gif) no-repeat center;');
}

mn.SelectMenu=function(id){
	$('#menu-'+id).addClass('ui-widget-header');
}

mn.MenuHover=function(){
	$('.menu li').hover(
		function() {$(this).addClass('ui-state-hover');},
		function() {$(this).removeClass('ui-state-hover');}
	);
}

mn.LoadMenu=function(){
	mn.SwitchMenu();
	mn.MenuHover();
}
/*=============================================================================================
  :: _Tab_ ::
=============================================================================================*/
/*tb.LoadTab=function(){
	$( "#tabs" ).tabs().tabs({
		load: function(event, ui){
			$('#'+ui.panel.id).css('display', '');
		},
		selected: tb.tab
	});
}
/*=============================================================================================
  :: _DEFAULT_ ::
=============================================================================================*/
/*df.SetTab=function(){
	if( $('#SetTab').attr('rel') )
		tb.tab = parseFloat($('#SetTab').attr('rel'));
	else
		tb.tab = 0;
	$('#lnk-FormsViewList').click(function(){
		frm.LoadOn();ae.sub = '';
		vl.ReloadList();return false;
	});
	$('#lnk-FormsAddEdit').click(function(){
		frm.LoadOn();ae.sub = '';
		ae.LoadAdd();return false;
	});
		
}*/
df.SetTitle=function(){
	$('#nav').html('<a href="javascript:void(0)"> '+$('#SetTitle').html()+'</a>');
}
df.SetPageHeader=function(){
	$('#headerPage').html($('#SetPageHeader').html());
}
df.LoadDefault=function(){
	df.SetPageHeader();
	df.SetTitle();
	df.LoadOnline(parseInt($('#online').attr('rel')));
	$("#checkAll").click(function(){frm.checkboxAll($(this).is(':checked'));});
}
df.LoadOnline=function(t){
	t++;
	dh=Math.floor((((t/60)/60)%60));if(dh<10) dh='0'+dh;
	dm=Math.floor(((t/60)%60));if(dm<10) dm='0'+dm;
	ds=Math.floor(t%60);if(ds<10) ds='0'+ds;
	$('#online').html(dh+':'+dm+':'+ds);
	setTimeout("df.LoadOnline("+t+")",1000);
}


/*=============================================================================================
  :: _Add and list menu_ ::
=============================================================================================*/


/*=============================================================================================
  :: _LoadReady_ ::
=============================================================================================*/
$(document).ready(function(){
	//frm.LoadOn();
	df.LoadDefault();
	to.LoadTool();
	//mn.LoadMenu();
	//tb.LoadTab();
	frm.LoadOff();
	$('#lnk-FormsViewList').click(function(){
		$('#FormsViewList').css('display', 'block');
		$('#FormsAddEdit').css('display', 'none');
	});
	$('#lnk-FormsAddEdit').click(function(){
		$('#FormsViewList').css('display', 'none');
		$('#FormsAddEdit').css('display', 'block');
	});
	
	$('#add-FormsAddEdit').click(function(){
		$('#FormsViewList').css('display', 'none');
		$('#FormsAddEdit').css('display', 'block');
	});
	$().on('click', '#edit-FormsAddEdit', function(){
		$('#FormsViewList').css('display', 'none');
		$('#FormsAddEdit').css('display', 'block');
	});
	$('#del-FormsAddEdit').click(function(){
		$('#FormsViewList').css('display', 'none');
		$('#FormsAddEdit').css('display', 'block');
	});
});


