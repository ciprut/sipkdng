// JavaScript Document
jQuery.fn.tabel = function(options){
	var sett = $.extend({
		 'title':'&nbsp;',
		 'widths':'',
		 'message':'',
		 'scrolling':'no'
  },options);

	return this.each(function(){
		var e = $(this);
		e.addClass('tabelku');
		e.wrap("<div style='background:#FFFFFF;font-size:14px;color:#333;padding-top:30px'></div>");
		e.before("<div style='background:#fafafa;height:45px;line-height:45px;text-align:center;'>"+sett.title+"</div>");
		var record = $("tbody tr",this).length;
		var lebar = sett.widths;
		var pesan = sett.message;
		/*
		$("th", e).each(function(){
			
				$(this).css({
					"padding":"0px",
					"height":"10px"
				});
				$(this).append('<div style="position:absolute;margin-top:-50px;height:40px;line-height:40px;margin-left:5px">'+$(this).text()+'</div>');
		});*/
		if(lebar.length > 0){
			header = $("th", this);
			for (var i = 0; i < lebar.length; i++) {
				arr = lebar[i];
				nilai = arr['value'];
				kolom = arr['col'];
				header.eq(kolom).css({
					"width":nilai+"px"
				});
			}
		}
		if(record == 0){
			if(pesan == ''){
				m = 'Tidak ada data yang ditampilkan';
			}else{
				m = "<b>"+pesan+"</b>";
			}
			$("tbody",this).append("<tr><td colspan='100%' align='center'>"+m+"</td></tr>");
		}
		
		e.after("<div style='background:#fafafa;height:45px;line-height:45px;padding-right:20px;font-size:11px;color:#666;text-align:right'>Menampilkan "+record+" baris data</div>");
		e.css({
			"margin-top":"0px",
			"margin-bottom":"0px"
		});
	});
};

jQuery.fn.initForm = function(options){
	var sett = $.extend({
		 'readonly':'',
		 'required':'',
		 'number':'',
		 'scrolling':'no'
  },options);

	return this.each(function(){
		var e = $(this);
		var ro = sett.readonly;
		var req = sett.required;
		var nmr = sett.number;
		if(ro.length > 0){
			for (var i = 0; i < ro.length; i++) {
				$("#"+ro[i]).attr('readonly','readonly').css({"border":"1px solid #333333","background-color":"#FFFFFF","color":"#666666"});
			}
		}
		
		/// type nomer
		if(nmr.length > 0){
			for (var i = 0; i < nmr.length; i++) {
				$("#"+nmr[i]).css({"border":"1px solid #666666","background-color":"#FFFFFF","color":"#666666","text-align":"right"}).addClass("number");
				if(isNaN($("#"+nmr[i]).val())){
					$("#"+nmr[i]).val("0");
				}
			}
		}
		$(".number").each(function(){
			$(this).on('blur keyup', function(){
				nilai = parseFloat($(this).val());
				$(this).val(nilai);
				if(isNaN($(this).val())){
					$(this).val("0");
				}
			});
		});
		
		if(req.length > 0){
			for (var i = 0; i < req.length; i++) {
				$("#"+req[i]).attr('required','required').css({"border":"1px solid #B71C1C","background-color":"#FFFFFF"});

				$("#"+req[i]).keyup(function(){
					if($(this).val() != ''){
						$(this).css({"border":"1px solid #666666","background-color":"#FFFFFF"});
					}else{
						$(this).css({"border":"1px solid #B71C1C","background-color":"#FFFFFF"});
					}
				});
			}
		}
	});
};

jQuery.fn.validate = function(options){

	var result = true;
	$(this).each(function(){
		var e = $(this);
		var input = $("input", e);
		var sel = $("select", e);
		var ta = $("textarea", e);
		var errors = 0;

		var inputs = input.length;
		var sels = sel.length;
		var tas = ta.length;

		if(inputs > 0){
			for (var i = 0; i < inputs; i++) {
				a = input.eq(i);
				if(a.prop('required')){
					if(a.val() == ''){
						errors ++;
						a.focus();
					}
				}
			}
		}
		
		if(sels > 0){
			for (var i = 0; i < sels; i++) {
				a = sel.eq(i);
				if(a.prop('required')){
					if(a.val() == ''){
						errors ++;
						a.focus();
					}
				}
			}
		}
		
		if(tas > 0){
			for (var i = 0; i < tas; i++) {
				a = ta.eq(i);
				if(a.prop('required')){
					if(a.val() == ''){
						errors ++;
						a.focus();
					}
				}
			}
		}
		
		if(errors == 0){
			result = true;
		}
	
	});
	return result;
};

jQuery.fn.getArrayTR = function(options){
	var sett = $.extend({
		 'to':''
  },options);
	
	var target = sett.to;
	var e = $(this);
	
	e.each(function(){
		$(this).click(function(){
			var vals = new Array();
			
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
				$('td',$(this)).removeClass('tr-selected');
			}else{
				$(this).addClass('selected');
				$('td',$(this)).addClass('tr-selected');
			}
			
			$('.selected').each(function(){
				vals.push($(this).data('elm'));
			});
	$('#'+target).val(vals.toString());
			
		})
	});
};

jQuery.fn.web_tab = function(options){
	var sett = $.extend({
		 'jenis':'default',
		 'judul':'&nbsp;',
		 'scrolling':'no'
  },options);

	return this.each(function(){
		var e = $(this);
		if(e.hasClass("web-tab")){
		}else{
			e.addClass("web-tab");
		}
		e.prepend("<div style='background:#438EB9;margin-bottom:45px;padding-right:20px;text-align:right;height:45px;line-height:45px;font-size:14px;color:#FFF'>"+sett.judul+"</div>");
		var w = "<div style='margin:20px auto;padding:10px;width:60%'></div>";
		var hw = "<div class='hw'></div>";
		var jenisTab = sett.jenis;
		var scr = sett.scrolling;
		var jum_header = $(".web-tab-header li",e).length;

		for(n=0;n<jum_header;n++){
			$(".web-tab-header li a",e).eq(n).attr("data-id",n);
			if($(".web-tab-header li a",e).eq(n).html() == "#"){
				$(".web-tab-header li a",e).eq(n).hide();
			}
		}
		
		if(jenisTab == "form"){
			$(".web-tab-header li a",e).addClass("disable-tab-header");
		}
		
		if(scr == "yes"){
			for(n=0;n<jum_header;n++){
				$("#tab-"+n,e).css({
					"height":"500px",
					"overflow-y":"auto"
				});
			}
		}
		
		//$(".web-tab-header",e).wrap(hw);
		$(".hw",e).after("<div style='float:none;clear:both;height:0px;'></div>");

		//sembunyikan
		$(".web-tab-header li a",e).eq(0).removeClass("disable-tab-header");
		$(".web-tab-header li a",e).eq(0).addClass("active-tab-header");
		

		$(".web-tab-header li a",e).each(function(){
			t = $(this);
			//cari tab-container nya
			var tc = t.attr("href");
			$(tc).addClass("web-tab-container");
			t.addClass("tab-name-header"); //t.addClass("tab-name-header transition");
			
			$(tc).hide();
			//$(tc).css("margin-top":"-100px");
			$(".web-tab-container").eq(0).show();
			//t.eq(0).addClass("active-tab-header");
			
			t.click(function(){
				if($(this).hasClass("disable-tab-header")){
					return false;
				}
				if(jenisTab == "form"){
					nn = parseInt($(this).data("id"));
					for(i=(nn+1);i<jum_header;i++){
						$(".web-tab-header li a",e).eq(i).addClass("disable-tab-header");
						$(".web-tab-header li a",e).eq(i).hide();
						$(".web-tab-header li a",e).eq(i).html("");
					}
				}
				$(".tab-name-header").removeClass("active-tab-header");
				$(this).addClass("active-tab-header");
				
				var container = $(this).attr("href");
				$(".web-tab-container").hide();
				$(container).show();
				return false;
			});
		});
	});
};

function gotoTab(n,j){
	e = $(this);
	pr = e.closest("web-tab").attr("id");
	$(".web-tab-header li a",pr).eq(n).removeClass("disable-tab-header");
	if(typeof j != 'undefined'){
		$(".web-tab-header li a",pr).eq(n).text(j);
	}
	$(".web-tab-header li a",pr).eq(n).click();
	$(".web-tab-header li a",pr).eq(n).fadeIn();
	return false;
}

jQuery.fn.mydatepicker = function(options){
	var settings = $.extend({
	   'altField':'none','def':'none'
  },options);
	
	return this.each(function(){
		var af = settings.altField;
		var def = settings.def;
				
		var bulan = Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var dd = $(af).val();
		
		if(af != "none"){
			if(dd == ""){
				var t = new Date();
				var bln = t.getMonth()+1;
				var tg = t.getDate()+1;
				if(bln<10){bl = "0"+bln;}else{bl = bln;}
				if(tg<10){tl = "0"+tg;}else{tl = tg;}
		
				var thi = t.getDate()+" "+bulan[(t.getMonth())]+" 1930";//+t.getFullYear();
				$(af).val(t.getFullYear()+""+bl+""+tl);
			}else{
				$(this).val(tgl(dd));
				var thi = tgl(dd);
			}
		}else{
				var t = new Date();
				var bln = t.getMonth()+1;
				var tg = t.getDate()+1;
				if(bln<10){bl = "0"+bln;}else{bl = bln;}
				if(tg<10){tl = "0"+tg;}else{tl = tg;}
		
				var thi = t.getDate()+" "+bulan[(t.getMonth())]+" 1930";//+t.getFullYear();
				$(this).val(thi);
		}
		
		var e = $(this);
		if(af == 'none'){
			e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true"});
		}else{
			e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true","altField":af,"altFormat":"yymmdd"});
		}
		
		if(settings.def == "none"){
			e.each(function(){
				e.val(thi);
			});
		}
	});
};

$.fn.tanggalUI = function(options){
	var settings = $.extend({
	   'altField':'none',
		 'def':'none',
		 'format':'none',
		 'defaultDate': 'none'
  },options);
	
	return this.each(function(){
		var af = settings.altField;
		var def = settings.def;
		var ftx = settings.format;
		var defaultDate = settings.defaultDate;
		
		var e = $(this);
		var bulan = Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var dd = $("#"+af).val();
		
		var t = new Date();
		var bln = t.getMonth()+1;
		var tg = t.getDate()+1;
		if(bln<10){bl = "0"+bln;}else{bl = bln;}
		if(tg<10){tl = "0"+tg;}else{tl = tg;}
		
		var thi = t.getDate()+" "+bulan[(t.getMonth())]+" "+t.getFullYear();

	function tgl(txt){
		var bulan = Array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var nilai = txt.substr(6,2)+" "+bulan[parseInt(txt.substr(4,2))]+" "+txt.substr(0,4);
		return nilai;
	}
		if(af != "none"){
			if(dd == ""){
				if(ftx == "none"){
					$(af).val(t.getFullYear()+""+bl+""+tl);
				}else if(ftx == "msSql"){
					$(af).val(bl+"/"+tl+"/"+t.getFullYear()+" 00:00:00 AM");
				}else{
					$(af).val(t.getFullYear()+"-"+bl+"-"+tl+" 00:00:00");
				}
			}else{
				$(this).val(tgl(dd));
				var thi = tgl(dd);
			}
			
			if(ftx == "none"){
				e.datepicker({
					dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true","altField":"#"+af,"altFormat":"yymmdd"});
			}else if(ftx == "msSql"){
				e.datepicker({
					dateFormat: 'm/d/yy',
					"changeMonth":"true",
					"changeYear":"true",
					"altField":"#"+af,
					"ampm": true,
					"altFormat":"m/d/yy"
				});
			}else{
				//01/01/01
				if(defaultDate != "none"){
					e.datepicker({
						dateFormat: 'dd MM yy',
						"changeMonth":"true",
						"changeYear":"true",
						"altField":"#"+af,
						"altFormat":"yy-mm-dd",
						"defaultDate": defaultDate
					});
				}else{
					e.datepicker({
						dateFormat: 'dd MM yy',
						"changeMonth":"true",
						"changeYear":"true",
						"altField":"#"+af,
						"altFormat":"yy-mm-dd"
					});
				}
			}
		}
				if(ftx == "none"){
					$(af).val(t.getFullYear()+""+bl+""+tl);
				}else if(ftx == "msSql"){
					$(af).val(bl+"/"+tl+"/"+t.getFullYear()+" 00:00:00 AM");
				}else if(ftx == "mysql"){
					$(af).val(t.getFullYear()+"-"+bl+"-"+tl+" 00:00:00");
				}
		
		if(af == "none"){
			e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true"});
		}		

	});
};

$.fn.tanggalMySQL = function(options){
	var settings = $.extend({
	   'altField':'none',
		 'def':'none',
		 'format':'none',
		 'defaultDate': 'none'
  },options);
	
	return this.each(function(){
		var af = settings.altField;
		var def = settings.def;
		var ftx = settings.format;
		var defaultDate = settings.defaultDate;
		
		var e = $(this);
		var bulan = Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var dd = $("#"+af).val();
		
		var t = new Date();
		var bln = t.getMonth()+1;
		var tg = t.getDate()+1;
		if(bln<10){bl = "0"+bln;}else{bl = bln;}
		if(tg<10){tl = "0"+tg;}else{tl = tg;}
		
		var thi = t.getDate()+" "+bulan[(t.getMonth())]+" "+t.getFullYear();

		function tgl(txt){
			var bulan = Array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			var nilai = txt.substr(6,2)+" "+bulan[parseInt(txt.substr(4,2))]+" "+txt.substr(0,4);
			return nilai;
		}

		if(af == "none"){
			e.datepicker({dateFormat: 'yy-mm-dd',"changeMonth":"true","changeYear":"true"});
		}		

	});
};

//Tanggal MsSQL
$.fn.tanggalMsSQL = function(options){
	var settings = $.extend({
	   'altField':'none',
		 'def':'none',
		 'format':'none'
  },options);
	
	return this.each(function(){
		var af = settings.altField;
		var def = settings.def;
		var ftx = settings.format;
		var e = $(this);
		
		var bulan = Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var dd = $("#"+af).val();
		
		var t = new Date();
		var bln = t.getMonth()+1;
		var tg = t.getDate()+1;
		if(bln<10){bl = "0"+bln;}else{bl = bln;}
		if(tg<10){tl = "0"+tg;}else{tl = tg;}
		
		var thi = t.getDate()+" "+bulan[(t.getMonth())]+" "+t.getFullYear();

		if(af != "none"){
			if(dd == ""){
				if(ftx == "none"){
					$(af).val(t.getFullYear()+""+bl+""+tl);
				}else{
					$(af).val(t.getFullYear()+"-"+bl+"-"+tl+" 00:00:00");
				}
			}else{
				$(this).val(tgl(dd));
				var thi = tgl(dd);
			}
			
			if(ftx == "none"){
				e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true","altField":"#"+af,"altFormat":"yymmdd"});
			}else{
				e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true","altField":"#"+af,"altFormat":"yy-mm-dd"});
			}
		}
				if(ftx == "none"){
					$(af).val(t.getFullYear()+""+bl+""+tl);
				}else{
					$(af).val(t.getFullYear()+"-"+bl+"-"+tl+" 00:00:00");
				}
		
		if(af == "none"){
			e.datepicker({dateFormat: 'dd MM yy',"changeMonth":"true","changeYear":"true"});
		}		
	});
};


