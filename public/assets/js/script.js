	var xskpd;
	var xasal;
	var xdata;
	var dipilih = "";
	var kd_prog,kd_keg = "";
	var kd_prog,nm_prog,kd_keg,nm_keg,kd_rek = "";
	var tunggu = "<div style='padding:15px;margin:auto;width:120px;text-align:center;border:0px solid #cecece;border-radius:0px;text-align=center;background:#FFF;border:1px solid #666'><img src='images/loading.gif' height='10px'><br>Loading</div>";
	var loading = "<div style='padding:15px;margin:auto;width:120px;text-align:center;border:0px solid #cecece;border-radius:5px;text-align=center'><img src='images/loading3.gif' height='15px'></div>";
	var wrapper = "<div id='system_form_wrapper' style='width:100%;height:100%;z-index:16000;background:rgba(0, 0, 0, 0.1);position:fixed;left:0;top:0'>";
	var general_wrapper = "<div class='general_wrapper' style='width:100%;height:100%;z-index:9999;background:rgba(0, 0, 0, 0.5);position:fixed;left:0;top:0'>";
	var modal_wrapper = "<div class='general_wrapper' style='width:100%;height:100%;z-index:10000;background:rgba(0, 0, 0, 0.5);position:fixed;left:0;top:0'>";
	var tgg = "<div style='padding:15px;margin:auto;width:120px;text-align:center;border:0px solid #cecece;border-radius:0px;text-align=center;background:#FFF;border:1px solid #666'>Loading</div>";
	var tunggu = "<div class='overlay' id='div-tgg' style='background:#333'><br>Loading</div>";
//////////////------------- this is global function
	function jq(){
	//	clearTimeout(autorefresh);
		clear_form();
		web_alert();
		centhangTR();
		square();
		$("#div-tgg").remove();
		$("tr.data").css({"cursor":"pointer"});

		$('input[type=text]').keypress(function(event){
			if (event.keyCode === 10 || event.keyCode === 13){
				event.preventDefault();
			}
		});
		$("#div-tgg").each(function(){
			$(this).remove();
		});
		$(document).find(".searchTable").searchTable();

		$(".data").mousedown(function(e){
			e.preventDefault();
		});
	}

	function cek_form(frmID){
		var ret = true;
		$("#"+frmID+" .required").each(function(){
			e = $(this);
			if(e.val() == ""){
				ret = false;
				e.css("border","1px solid #B71C1C");
			}else{
				e.css("border","1px solid #AED581");
			}
		});
		return ret;
	}

	function bubble(e,t){
		var a = $("#"+e).offset().top - $(document).scrollTop() - 100;
		var l = $("#"+e).offset().left;
		$(".bubble").css({"left":l+"px","top":a+"px"});
		$(".bubble").fadeIn();
		$("#bubble-content").html(t);
	}
	function cariDiTabel(text,tabel){
		$("#"+text).on("keyup", function() {
	    var value = $(this).val().toLowerCase();
  	  $("#"+tabel+" tr").filter(function() {
    	  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    	});
  	});
	}

	function jqForm(){
		centhangTR();
		$("tr.data").css({"cursor":"pointer"});
	}

	function toTitleCase(str){
		return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
	}

	function square(){
		$(".square").each(function(){
			l = $(this).outerWidth();
			$(this).css({"height":l+"px"});
		});
	}

	function nextOption(id){
		$('#'+id+' option:selected').next().attr('selected', 'selected');
		$("#"+id).change();
	}

	function prevOption(id){
		$('#'+id+' option:selected').prev().attr('selected', 'selected');
		$("#"+id).change();
	}

	function printMousePos(e) {
    var cursorX = e.pageX;
    var cursorY = e.pageY;
		return cursorX+"__"+cursorY;
	}

	function web_alert(){
		if($("#web-alert-container").hasClass("web-alert-show")){
			exit();
		}else{
			$("#web-alert-container").addClass("web-alert-show");
			$("#web-alert-container").css({ //web-alert-container
				"position":"absolute",
				"width":"60%",
				"left":"20%",
				"top":"150px",
				"padding":"10px",
				"background":"#FFF"
			});
			$("#web-alert-container").wrap(general_wrapper);
			$(".general_wrapper").click(function(){
				$("#web-alert-container").removeClass("web-alert-show");
				$(this).fadeOut(200,function(){$(this).remove();});
			});
		}
	}

	function gulung(){
		document.getElementById("page-inner").scrollIntoView();
		//alert("Asdf");
	}

	function scrollElm(n){
 		ofs = $("#page-wrapper").scrollTop() - ($("#page-wrapper").offset().top - $(n).offset().top)-10;
  	ofs = parseInt(ofs);
  	//alert(n);
  	$("#page-wrapper").animate({scrollTop : ofs}, 300);
	}

	function webAlert(title,content){
		if($("#web-modal").hasClass("web-alert-show")){
			exit();
		}else{
			$("#web-modal").addClass("web-alert-show");
		$("#web-modal").css({ //web-alert-container
			"position":"absolute",
			"width":"60%",
			"left":"20%",
			"top":"150px",
		});
		ttl = "<div class='material-icons' style='text-align:center;float:left'>remove_circle</div>";
		ttl += "<div style='padding-left:10px;font-size:18px;line-height:28px;height:28px;display:inline-block'>"+title+"</div>";
//		$("#web-modal").show();
		$("#web-modal").wrap(modal_wrapper);
		$("#web-modal-title").html(ttl);
		$("#web-modal").fadeIn();
		c = content;
		$("#web-modal-content").html(c);
		$("#closeModal").click(function(){
			$("#web-modal").addClass("web-alert-show");
			$(".general_wrapper").fadeOut(200,function(){
				$("#web-modal").hide();
				$("#web-modal").unwrap(modal_wrapper);
				$(".general_wrapper").remove();
			});
		});
		}
	}

	function centhangTR(){
		$("tr.data input:checkbox").hide();

		$("tr.data:has(input:checkbox)").click(function(){
			var e = $(this);
			var nilai = $("input:checkbox",e).prop('checked');
			if(nilai){
				e.removeClass("dataSelected");
				$("input:checkbox",e).prop('checked',false);
				nilai = false;
			}else{
				$("input:checkbox",e).prop('checked',true);
				e.addClass("dataSelected");
				nilai = true;
			}
		});
	}

	//DISABLE DBL_CLICK
	function noClick(elm){
		$(elm).mousedown(function(e){
			e.preventDefault();
		});
	}
	//OVERWRITE OLD SELECTOR CONTAINS


$.expr[':'].Contains = function(x, y, z){
    return jQuery(x).text().toUpperCase().indexOf(z[3].toUpperCase())>=0;
};



//////////////-------------

	function ganti(id,txt){
		var caretPos = document.getElementById(id).selectionStart;
		var caretEnd = document.getElementById(id).selectionEnd;
    var textAreaTxt = jQuery("#"+id).val();
    var textAreaEnd = jQuery("#"+id).val().length;
    var txtToAdd = txt;
		var newVal =
    jQuery("#"+id).val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretEnd,textAreaEnd) );
	}

	String.prototype.replaceAll = function(search, replacement) {
		var target = this;
		return target.replace(new RegExp(search, 'g'), replacement);
	};

	function gabungkan(arr, lem){
		if(lem === undefined){
			lem = " ";
		}
		a = arr.split("__");
		n = a.length;
		ret = "";
		sep = "";
		for(i=0;i<n;i++){
			if(a[i] != ""){
				ret += sep+a[i];
				sep = lem;
			}
		}
		return ret;
	}

	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	function kali(arr){
		a = arr.split(",");
		n = a.length;

		ret = a[0];
		for(i=1;i<n;i++){
			if(a[i] > 0){
				ret = ret*a[i];
			}
		}
		return ret;
	}

	function dmyy(txt){
		var nilai = txt.substr(6,2)+"-"+txt.substr(4,2)+"-"+txt.substr(0,4);
		return nilai;
	}

	function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
	}

	function tgl(txt){
		var bulan = Array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		var nilai = txt.substr(6,2)+" "+bulan[parseInt(txt.substr(4,2))]+" "+txt.substr(0,4);
		return nilai;
	}

	function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
	}

	function grupTotal(){
		$(".gruptotal").each(function(){
			var e = $(this);
			var subClass = e.attr("id");
			var subTot = 0;

			$(".sub_"+subClass).each(function(){
				subTot += $(this).data("val");
			});

			e.text(addCommas(subTot));
		});
	}
	function clear_form(n){
		$("#form-content").html("");
		if(n != "noclear"){
			fntunggu_selesai();
		}
		$("#system_form").unwrap();
		$("#system_form_wrapper").remove();
		if($(".alert_ok").size() > 0){
			$(".alert_ok").css("top","0");
			$(".alert_ok").tengah();
		}
		$("#system_form").slideUp(function(){

			//$(".alert, .alert_ok").delay(1000).hide();
			$(".alert, .alert_ok").hide();
		});
	}

	function messi_confirm(txt,cb,title){
		if(title){
			judul = title;
		}else{
			judul = "Konfirmasi";
		}
		new Messi(txt, {title: judul, buttons: [
		{id: 0, label: 'Ya', val: 'Y'},
		{id: 1, label: 'Batal', val: 'N'}],
		callback: function(f) {
			if(f == 'Y'){
				alert(val);
				//cb;
			}
		}});
	}

	function log_it(dat){
		$.ajax({
			type:"POST",
			url:"sse_write.php",
			data:"dat="+dat
		});
	}
function goTab(n,j){
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

function tab_klik(sel){
	$("a[href='#tabs-"+sel+"']").click();
	var n = $("#tabs ul li a").size();
	for(i=(sel+1);i<n;i++){
		$("#tabs-"+i).html("&nbsp;");
		$("#tabs ul li a[href='#tabs-"+i+"']").html("&nbsp;");//.html(i+1)
		atur_tinggi();
	}
	cls();
}

function load_to_tab(idx,url,ttl){
	plswait();
	if(idx){
		idt = idx;
		$("a[href='#tab-"+idt+"']").show();
				if(ttl){
					gotoTab(idt,ttl);
					$("a[href='#tab-"+idt+"']").html(ttl);
				}else{
					gotoTab(idt,ttl);
				}
		$.ajax({
			type:"POST",
			url:url,
			success:function(dat){
				$("#tab-"+idt).html(dat+"<div class='clear'></div>");
				//$("#div-tgg").remove();
				logActivity(url);
			}
		});
	}
	$("#div-tgg").remove();
	siap();
}

function cb(){
	if($(".callback").length > 0){
		$(".callback").show().delay(3000).fadeOut(400,function(){
			$(".callback").remove();
		});
	}
}

function tab(idx){
	//cari banyaknya tab
	tab = $("#tabs ul li").length;
	//hapus tab dan judul tab
	for(i=idx;i<10;i++){
		$("#tabs ul li").has("a[href='#tabs-"+i+"']").hide();
	}
}

function load_to_content(content,url){
//	$("#"+content).html(tunggu);
	plswait();
  $("#"+content).load(url,function(){
		$("#"+content).attr("halaman",url);
		$("#div_system").fadeOut();
		$("#div-tgg").remove();
		siap();
	});
}

	function plswait(){
		pesan = "<b>Mohon menunggu, permintaan Anda sedang diproses...</b>";

		var tunggu = "<div id='div-tgg' style='z-index:16000;position:fixed;display:block;top:0px;right:0px;bottom:0px;left:0px;text-align:center;background:rgba(0,0,0,.5);line-height:100%;color:#FFF;padding-top:200px'>";
		tunggu += "<img src='assets/js/puff.svg'/>";
		tunggu += "<div style='width:20%;margin:auto;margin-top:20px;background:#FFFFFF;padding:20px;border-radius:3px;border:2px solid #ff3547;color:#666666'>Mohon menunggu..</div>";
		tunggu += "</div>";
	}

	function siap(){
		$("#mtx").css({"left":"-10000px"});
	}

function post_to_tab(idx,url,data,ttl,callBack,clea){
	plswait();
	if(clea == "1"){
//		$("#tab-"+idx).html("");
	}else{
		$("#tab-"+idx).html("");
	}
	if(parseInt(idx) > 0){
		bef = parseInt(idx)-1;
		tinggi = $("#tab-"+bef).height();
		$("#tab-"+idx).css("min-height", tinggi+"px");
	}
	if(idx){
		idt = idx;
		$("a[href='#tab-"+idt+"']").show();
				if(ttl){
					gotoTab(idt,ttl);
					$("a[href='#tab-"+idt+"']").html(ttl);
				}else{
					gotoTab(idt,ttl);
				}
		$.ajax({
			type:"POST",
			url:url,
			data: data,
			success:function(dat){
				$("#tab-"+idt).html(dat+"<div class='clear'></div>");
				siap();
			}
		});
	}
	$("#div-tgg").remove();
	hide_form();
}

function update_tab(idx,url,data,ttl,callBack,clea){
	if(clea == "1"){
//		$("#tab-"+idx).html("");
	}else{
		$("#tab-"+idx).html("");
	}
	if(parseInt(idx) > 0){
		bef = parseInt(idx)-1;
		tinggi = $("#tab-"+bef).height();
		$("#tab-"+idx).css("min-height", tinggi+"px");
	}
	if(idx){
		idt = idx;
		$.ajax({
			type:"POST",
			url:url,
			data: data,
			success:function(dat){
				$("#tab-"+idt).html(dat+"<div class='clear'></div>");
			}
		});
	}
}

function post_to_dat(url,data,callBack){
	var h;
	$.ajax({
		type:"POST",
		url:url,
		data:data,
		success:function(hasil){
			h = hasil;
			if(typeof callBack == "function"){
				callBack.call();
			}
		}
	});
	cls();
	return h;
}

function post_to_content(content,url,variabel,loading){
	plswait();
	if(content){
		isi = content;
	}else{
		isi = "content";
	}
	if(loading){
		$("#"+isi).html("<center>...loading...</center>");
	}
	var hal = $("#"+content).attr("hal");
	$.ajax({
		type:"POST",
		url:url,
		data:variabel,
		success:function(dat){
			$("#"+isi).html(dat);
			if(typeof callBack == "function"){
				callBack.call();
			}
		}
	});
	$("#div-tgg").remove();
	siap();
}

function post_to_modal(url,variabel,judul,lebar=''){
	plswait();
	$("#modal-judul-view").html(judul);
	if(lebar != ''){
		$('.modal-dialog').css('width','80%');
	}else{
		$('.modal-dialog').css('width','900px');
	}
	
	$.ajax({
		type:"POST",
		url:url,
		data:variabel,
		success:function(dat){
			$("#modal-body").html(dat);
			$('#centralModalDanger').modal('show');
			$("#modal-body").animate({ scrollTop: 0 }, "fast");
			$("#centralModalDanger").css("z-index", "100000");
		}
	});
}

function closeModal(){
	$('.modal-dialog').css('width','900px');
	$('#centralModalDanger').modal('hide');
}

function post_to_val(content,url,variabel,callBack){
	if(content){
		isi = content;
	}else{
		isi = "content";
	}
	$.ajax({
		type:"POST",
		url:url,
		data:variabel,
		success:function(dat){
			$("#"+isi).val(dat);
			if(typeof callBack == "function"){
				callBack.call();
			}
		}
	});
}

function postFile_to_content(content,url,variabel){
	if(content){
		isi = content;
	}else{
		isi = "content";
	}
	$("#"+isi).html(tunggu);

	var hal = $("#"+content).attr("hal");
	$.ajax({
		type:"POST",
		url:url,
		data:variabel,
		contentType: false,
    processData: false,
		success:function(dat){
			$("#"+isi).html(dat);
		}
	});
}

function cls(){
	$(".dipilih").removeClass("dipilih");
	$(".pil").attr("disabled",true);
	$(".unpil").removeAttr("disabled");
}

function jmd(){
	var d = new Date();
	var jmd = pjg(d.getHours(),2)+""+pjg(d.getMinutes(),2)+""+pjg(d.getSeconds(),2);
	return jmd;
}

function goto_tab(n){
	$("a[href='#tabs-"+n+"']").click();
}


//unit kerja
var xkd1,xkd2,xkd3,xkd4,xkd5;
// program / kegiatan
var xkd_prog,xid_prog,xkd_keg,xid_keg;

function html_to_content(content,url){
  $("#"+content).html(url);
}

function koma(n){
  p = n.length;
  i = 0;
  txt = "";
  for (x=p;x>=0;x--){
    txt = n.substr(x,1)+txt;

    if(i == 3 && x > 0){
      txt = ","+txt;
      i = 0;
    }
    i ++;
  }

  return txt;
}

function jqplugin(){
	$(".grid").grid();
	$(".tabel").tabel();
	$(".form").fnform();
	$(".buttonset").button_set();
}


function show_dialog(url,head){
	var d = $("#dialog");
	d.attr("title",":: Data PPTK SKPD::");
	d.attr("title",head);
	d.load(url,function(){
		$("#dialog").dialog({ height: 400,width: 700,modal: true });
	});
}

function kode_skpd(){
	var skpd = $(this).attr("id").split(".");
	xkd1 = skpd[0];
	xkd2 = skpd[1];
	xkd3 = skpd[2];
	xkd4 = skpd[3];
	var xskpd = "kd1="+skpd[0]+"&kd2="+skpd[1]+"&kd3="+skpd[2]+"&kd4="+skpd[3];
	return xskpd;
}

function popup(url){
	var width = 750;
	var height = 500;
	var left = (screen.width - width) / 2;
	var top = (screen.height - height) / 2;
	var params = 'width = '+width+',height='+height+',top='+top+',left='+left+',directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no';
	window.open(url,"Tabel Referensi",params);
}

function clear_check(){
	$(".data").removeClass("dipilih");
	$(".data input[type='checkbox']").removeAttr("checked");
	dipilih = "";
}

function judul_tab(n,txt){
	$("a[href='#tabs-"+n+"']").html(":: "+txt+" ::");
}

function tab_goto(page){
	$("#tabs").tabs("option","selected",page);
	var x = $("#tabs ul li a").size();
	$("#tabs ul li a[href='#tabs-"+page+"']").click();
}

function clear_tab(){
	$( "#tabs" ).wrap( "<div class=''></div>" );
	var sel = $("#tabs").tabs( "option", "selected" );

	tab = $("#tabs ul li").length;
	//hapus tab dan judul tab
	for(i=(sel+1);i<10;i++){
		$("#tabs ul li").has("a[href='#tabs-"+i+"']").hide();
	}

	$("#tabs ul li a").click(function(){
		var sel = $("#tabs").tabs( "option", "selected" );
		var n = $("#tabs ul li a").size();
		for(i=(sel+1);i<n;i++){
			$("#tabs-"+i).html("&nbsp;");
			$("#tabs ul li a[href='#tabs-"+i+"']").html("&nbsp;");//.html(i+1)
			$("#tabs ul li").has("a[href='#tabs-"+i+"']").hide();
			atur_tinggi();
		}
	})
}

function sub_container(text){
	$("#sub_container").fadeOut("fast",function(){
			$("#sub_container").html("");
			$("#dialog").html(text);
			$("#dialog").dialog({width:300});
		});
}

function perhatian(text,judul){
	$("#dialog").html(text);
	if(judul == null ){
		$("#dialog").dialog({width:300,modal:true,title:judul});
	}else{
		$("#dialog").dialog({width:300,modal:true,title:":: PERHATIAN ::"});
	}
}

function toFloat(val){
	var txt = val.replace(/,/g,"");
	return txt;
}

function toInt(val){
	var txt = val.replace(/,/g,"");
	txt = txt.split(".");
	txt = txt[0];
	return txt;
}

function fnalert(txt){
	h = "<div class='modal-header col-header'>Permintaan Ditolak</div>";

	if(!txt){
		c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>Permintaan Anda sedang diproses... Mohon tunggu..</div>";
	}else{
		c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>"+txt+"</div>";
	}

	$("#div_system").html(h+c).show().delay(2000).fadeOut();
	$("#div_system").tengah();
}

function fninfo(txt,judul){
	w = "<div class=wrapper></div>";
	if(!judul){
		j = "I N F O R M A S I";
	}else{
		j = judul;
	}
	h = "<div class='modal-header col-header' style='text-align:center'>";
	h += j+"</div>";
	c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>"+txt+"</div>";
	f = "<div class='modal-footer'><input type=button class=button id=btn_info value='Tutup' style='padding-left:20px;padding-right:20px'></div>";
	$("#div_system").wrap(w);
	//$(".wrapper").css({'height':$(document).height()+'px'});
	$("#div_system").html(h+c+f).show();
	$("#div_system").tengah();


	$("#btn_info").click(function(){
		$("#div_system").unwrap();
		$("#div_system").fadeOut(function(){
			$("#div_system").html("");
		});
	});
	return false;
}

function fnmodal(txt,judul){
	w = "<div class=wrapper></div>";
	if(!judul){
		j = "I N F O R M A S I";
	}else{
		j = judul;
	}
	h = "<div class='modal-header col-header'>";
	h += j+"</div>";
	c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>"+txt+"</div>";
	$("#div_system").wrap(w);
	$(".wrapper").css({'height':$(document).height()+'px'});
	$("#div_system").html(h+c);
	$("#div_system").show();
	$("#div_system").tengah();
	return false;
}

function fntunggu(txt){
	h = "<div class='modal-header col-header'>Mohon Tunggu</div>";

	if(!txt){
		c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>Permintaan Anda sedang diproses... Mohon tunggu..</div>";
	}else{
		c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>"+txt+"</div>";
	}
	wait = "<div style='display:block;padding:10px'><img src='images/loading.gif'></div>";
//	$("#div_system").html(h+c).show();
	$("#div_system").html(wait).show();
	$("#div_system").tengah();
}

function fnconfirm(txt,judul){
	w = "<div class=wrapper></div>";
	if(!judul){
		j = "KONFIRMASI";
	}else{
		j = judul;
	}
	h = "<div class='modal-header col-header'>";
	h += j+"</div>";
	c = "<div style='display:block;padding:30px 20px;border-top:1px solid #FFF'>"+txt+"</div>";
	f = "<div class='modal-footer'>";
	f += "<input type=button class=button id=btn_confirm_ok value='OK' style='padding-left:20px;padding-right:20px'>";
	f += "<input type=button class=button id=btn_confirm_cancel value='BATAL' style='padding-left:20px;padding-right:20px'>";
	f += "</div>";
	$("#div_system").wrap(w);
	$(".wrapper").css({'height':$(document).height()+'px'});
	$("#div_system").html(h+c+f).show();
	$("#div_system").tengah();

	$("#btn_confirm_ok").click(function(){
		$("#div_system").unwrap();
		$("#div_system").fadeOut(function(){
			$("#div_system").html("");
		});
		return true;
	});

	$("#btn_confirm_cancel").click(function(){
		$("#div_system").unwrap();
		$("#div_system").fadeOut(function(){
			$("#div_system").html("");
		});
		return false;
	});
}

function fntunggu_selesai(){
	$("#div_system").fadeOut(function(){
		$("#div_system").html("");
	});
}

function fndisable(){
	$(this).attr("DISABLED","DISABLED");
}

function fnenable(id){
	$("#"+id).removeAttr("DISABLED");
}

function fnajaxresult(txt){
	p = txt.split("<script>");
	return p[0];
}

function optionresult(txt){
	p = txt.split(" - ");
	return p[1];
}

function clearSelect(id,title){
	$("#"+id).html("<option value=''>"+title+"</option>");
}

function post_form(urlnya,datanya,judulnya,l){
	plswait();
	$("#form-content").html("<div id='formstart'></div>");
	$("#form-close").show();
			if(judulnya){
				//judulnya = judulnya.toUpperCase();
				$("#form-container #form-title").html(judulnya);
			}else{
				$("#form-container #form-title").html("&nbsp;");
			}

	$.ajax({
		type:"POST",
		url:urlnya,
		data:datanya,
		success:function(dat){
			$("#form-content").html(dat);
			$("#form-content").animate({ scrollTop: 0 }, "fast");
			$("#div-tgg").remove();
			$("#form-container").show();
			$("#form-content").click();
			siap();
		}
	});
	$("#form-container").css('width','400px');
	if(l == '2'){
		$("#form-container").css({'width':'630px','background-color':'#FFff00'});
	}
	if(l == '3'){
		$("#form-container").css({'width':'960px','background-color':'#FFff00'});
	}
}

function form_fill(urlnya,datanya,judulnya,l){
	$.ajax({
		type:"POST",
		url:urlnya,
		data:datanya,
		success:function(dat){
			$("#form-content").html(dat);
		}
	});
}

function show_form(judulnya,l){
	//$("#form-container").wrap(wrapper);
	$("#form-close").hide();
	if(judulnya){
		$("#form-container #form-title").html(judulnya);
	}else{
		$("#form-container #form-title").html("&nbsp;");
	}
	//$("#form-container").tengah();
	$("#form-container").show();
}

function form_fadeOut(){
	$("#form-container").unwrap();
	$("#system_form_wrapper").remove();
	if($(".alert_ok").size() > 0){
		$(".alert_ok").css("top","0");
		$(".alert_ok").tengah();
	}
	$("#form-container").fadeOut(function(){
		$(".alert, .alert_ok").delay(1000).fadeOut();
	});
}

function clear_forms(){
	//$("#form-container").unwrap();
	$("#system_form_wrapper").remove();
	if($(".alert_ok").size() > 0){
		$(".alert_ok").css("top","0");
		$(".alert_ok").tengah();
	}
	$("#form-container").hide(function(){
		$("#form-content").html("");
		//$(".alert, .alert_ok").delay(1000).fadeOut();
		$(".alert, .alert_ok").hide();
	});
}

function hide_form(){
	fntunggu_selesai();
	//$("#form-container").unwrap();
	//$("#system_form_wrapper").remove();
	if($(".alert_ok").size() > 0){
		$(".alert_ok").css("top","0");
		$(".alert_ok").tengah();
	}
	$("#form-container").fadeOut(function(){
		$(".alert, .alert_ok").delay(1000).fadeOut();
	});
}

var t = new Date();
var tahunini = t.getFullYear()+1;
/*
jQuery(function($){
	$.datepicker.regional['id'] = {
		closeText: 'Tutup',
		prevText: '&#x3C;mundur',
		nextText: 'maju&#x3E;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
		'Juli','Agustus','September','Oktober','Nopember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun',
		'Jul','Agus','Sep','Okt','Nop','Des'],
		dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
		dayNamesShort: ['Min','Sen','Sel','Rab','kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','jm','Sb'],
		weekHeader: 'Mg',
		dateFormat: 'dd MM yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearRange: '2010:'+tahunini+'',
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['id']);
});
*/
function number_format (number, decimals, decPoint, thousandsSep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number;
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep;
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint;
  var s = '';

  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec);
    return '' + (Math.round(n * k) / k);
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }

  return s.join(dec);
}

function urutTabel(namaTabel,pembanding,angka) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(namaTabel);
	ang = typeof angka == 'undefined' ? "1" : "0";

  switching = true;
  /* Make a loop that will continue until no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
//    for (i = 1; i < 10; i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare, one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[pembanding];
      y = rows[i + 1].getElementsByTagName("TD")[pembanding];
      // Check if the two rows should switch place:
			if(ang = "1"){
				xx = parseInt(x.innerHTML);
				yy = parseInt(y.innerHTML);
			}else{
				xx = x.innerHTML.toLowerCase();
				yy = y.innerHTML.toLowerCase();
			}
      if (xx > yy) {
        // If so, mark as a switch and break the loop:
        shouldSwitch= true;
        break;
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function hitungElm(elm){
	el = elm.split(",");
	salah = 0;
	jum = 0;
	arr = new Array();
	for(i=0;i< el.length;i++){
		if(parseInt($("#"+el[i]).val()) > 0){
			arr.push(parseInt($("#"+el[i]).val()));
		}else{
			arr.push(0);
		}
	}
	for(i=0;i< el.length;i++){
		if(i == 0){
			jum = arr[i];
		}else{
			jum = (jum*arr[i]);
		}
	}
	return jum;
}


function showModal(modal,callback){
	var color = ("color" in modal) ?  modal["color"] : "danger" ;
	var judul = ("judul" in modal) ? modal["judul"] : "Perhatian";
	var icon = ("icon" in modal) ? modal["icon"] : "check";
	var isi = ("isi" in modal) ? modal["isi"] : "Maaf, proses tidak dapat dilanjutkan.";

	html = "<div class='modal fade' id='centralModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

  html += "<div class='modal-dialog modal-notify modal-"+color+"' role='document'>";

  html += "<div class='modal-content'>";
  html += "<div class='modal-header'>";
  html += "<p class='heading lead'>"+judul+"</p>";

  html += "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
  //html += "<span aria-hidden='true' class='white-text'>&times;</span>";
  html += "</button>";
  html += "</div>";

  html += "<div class='modal-body'>";
  html += "<div class='text-center'>";
  html += "<i class='fa fa-"+icon+" fa-4x mb-3 animated rotateIn'></i>";
  html += "<p>"+isi+"</p>";
  html += "</div>";
  html += "</div>";

  html += "<div class='modal-footer justify-content-center'>";
  html += "<a type='button' class='btn btn-outline-"+color+" waves-effect'  id='modalClose' data-dismiss='modal'>Tutup! <i class='fa fa-times ml-1 text-red'></i></a>";
  html += "<a type='button' class='btn btn-"+color+"' id='modalPositive' data-dismiss='modal'>Lanjutkan <i class='fa fa-check ml-1 text-white'></i></a>";
  html += "</div>";
  html += "</div>";
  html += "</div>";
 	html += "</div>";

 	$("#modalContent").html(html);
 	$("#centralModal").modal("show");
 	if(typeof callback === "function"){
 		$("#modalPositive").click(function(){
 			callback.call();
 			//$("#modalClose").click();
 		});
 	} 	
}

function showAlert(modal){
	var color = ("color" in modal) ?  modal["color"] : "danger" ;
	var judul = ("judul" in modal) ? modal["judul"] : "Perhatian";
	var icon = ("icon" in modal) ? modal["icon"] : "times-circle";
	var isi = ("isi" in modal) ? modal["isi"] : "Maaf, proses tidak dapat dilanjutkan.";

	html = "<div class='modal fade' id='centralModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

  html += "<div class='modal-dialog modal-notify modal-"+color+"' role='document'>";

  html += "<div class='modal-content'>";
  html += "<div class='modal-header bg-"+color+"'>";
  html += "<p class='heading lead' style='float:left'>"+judul+"</p>";
  html += "</div>";

  html += "<div class='modal-body'>";
  html += "<div class='text-center'>";
  html += "<i class='fa fa-"+icon+" fa-4x mb-3 bg-"+color+"' style='border-radius:50%;width:70px;height:70px;color:#FFF;line-height:70px;margin-bottom:30px;margin-top:30px'></i>";
  html += "<p>"+isi+"</p>";
  html += "</div>";
  html += "</div>";

  html += "<div class='modal-footer justify-content-center' style='background-color:#efefef;border-top:1px solid #ccc'>";
  html += "<a type='button' class='btn btn-outline-"+color+" waves-effect'  id='modalClose' data-dismiss='modal'>OK! <i class='fa fa-check ml-1 text-red'></i></a>";
  html += "</div>";
  html += "</div>";
  html += "</div>";
 	html += "</div>";

 	$("#modalContent").html(html);
 	$("#centralModal").modal("show");
}

function showModals(title,col){
		if($("#web-modal").hasClass("web-alert-show")){
			exit();
		}else{
			$("#web-modal").addClass("web-alert-show");
			$("#web-modal").css({ //web-alert-container
				"position":"absolute",
				"width":"80%",
				"left":"10%",
				"top":"0px",
			});
			//web-modal-title
			if(col){
				$("#web-modal-title").css("background-color","#"+col);
				$("#web-modal-footer").css("background-color","#ffebee");
			}else{
				$("#web-modal-title").css("background-color","#333");
				$("#web-modal-footer").css("background-color","#e0e0e0");
			}
			ttl = "<div class='material-icons' style='text-align:center;float:left'>remove_circle</div>";
			ttl += "<div style='padding-left:10px;font-size:18px;line-height:28px;height:28px;display:inline-block'>"+title+"</div>";
//		$("#web-modal").show();
			$("#web-modal").wrap(modal_wrapper);
			$("#web-modal-title").html(ttl);
			$("#web-modal").show();
			$("#web-modal").animate({top: "20px"});

			$("#closeModal").click(function(){
				$("#web-modal").removeClass("web-alert-show");
				$(".general_wrapper").fadeOut(200,function(){
				$("#web-modal-title").css("background-color","#b71c1c");
					$("#web-modal-footer").css("background-color","#ffebee");
					$("#web-modal").hide();
					$("#web-modal").unwrap(modal_wrapper);
					$(".general_wrapper").remove();
				});
			});
		}
	}


	//bootbox
	function bconfirm(judul,pesan,callback){
		bootbox.confirm({
	    title: judul,
	    message: '<i class="fas fa-question-circle fa-4x mb-3 animated rotateIn" style="color:#33b5e5"></i><p>'+pesan+"</p>",
	    centerVertical: true,
	    className: 'fadeIn animated',
	    buttons: {
	        cancel: {
	            label: '<i class="fa fa-times"></i> &nbsp;&nbsp;Batal',
	            className: 'btn-light'
	        },
	        confirm: {
	            label: '<i class="fa fa-check"></i> &nbsp;&nbsp;Lanjutkan',
	            className: 'btn-info'
	        }
	    },
	    callback: function (result) {
	    	if(typeof callback == "function" && result == true){
	    		callback.call();
	    	}
	    }
    });
	}

	(function($) {
	$.fn.columnsToJs = function(options) {
        var _this = this,
			j_this =  $(_this)
        //parametry wejĹciowe
      	_this = $.extend( {
         	count: 3,
         	check: 0,
         	gap: 20,
         	fixed: true,
         	debug: false,
         	interval: false
        }, options);


      	// MoĹźliwosc wiÄcej niĹź jednej kolumny na stronie
      	this.each(function() {

			_this.child = j_this.children();

	 		if(_this.check == "all"){
	 			_this.check = _this.child.length;
	 		}
	        if(_this.check < _this.count + 2){
	        	_this.check = _this.count + 2;
	        }

			_this.bodywidth = $(window).width();

			_this.ifInPostiton = function(left, top, lastPostion){
				var ifPosible = true;
				for (var i = lastPostion.length - 1; i >= 0; i--) {
					// console.log("ifInPostiton i                 : "+i);
					// console.log("ifInPostiton max               : "+max);
					// console.log("ifInPostiton lastPostion.length: "+lastPostion.length);
					if(lastPostion[i][0] == top && lastPostion[i][1] == left){
						return false
					}
				}
				return true
			}


			$(_this.child).css('transition', 'none');
			_this.init = function(){
      			_this.gapNumber = _this.count - 1;
				_this.parentWidth = j_this.width();
				_this.rowWidth = (_this.parentWidth - _this.gapNumber * _this.gap ) / _this.count;
		        _this.getBest = 0;
				j_this.css({
					'column-count': '1',
					'column-gap': '0',
					'position': 'relative'
				});
				children = j_this.children().filter(":visible");
				if(_this.debug){
					console.log("INIT!!!");
					console.log(_this);
				}
				var landigLeft = 0;
				var lastPostion = [];

				var memorycalc = [];

		        children.each(function() {
		        	var element = $(this),
		        		position = [0,0], // TOP, LEFT
		        		index = element.filter(":visible").index();

		        	var elementMemoru = memorycalc[index];



					// Nadaj szerokoĹÄ css
					// musi byÄ wywoĹana wczeĹnie bo ma wpĹyw na wysokoĹÄ elementu
		        	element.css({
						width: _this.rowWidth+'px',
					});



		        	if(_this.fixed){
		        		// Ustaw wedĹug jak najbardziej optymalnie

		        		// Ustaw pierwszy rzÄd po staremu
						if(index>_this.count-1) {
							var topPositon = -1;
							var leftPositon = -50;
			        		// console.log(index);
			        		// position[0] = brotherTop.position().top + brotherTop.outerHeight(true);
			        		if(_this.debug){
			        			children.css('background', '');
			        		}
			        		var check = _this.check;
			        		if(check>index){
			        			check=index;
			        		}
			        		for (var i = index; i >= index - check +1; i--) {


			        			var forI = Math.abs(i-1);
			        			var brother = children.filter(":visible").eq(forI);

			        			if(memorycalc[forI]){
				        			// console.log("AAAAAAAAAAAA");
				        			if(_this.debug){
				        				console.log(forI+" szukam na poziomie "+index);
				        			}


				        			var brotherTop = memorycalc[forI].top+brother.outerHeight(true);
				        			var brotherLeft = memorycalc[forI].left;

									// var brotherTop = 0;
				        			// var brotherLeft = 0;

					        		if(_this.debug){
						        		console.log("brotherTop: ", brotherTop);
						        		console.log("brotherLeft: ", brotherLeft);
					        			element.css('background', 'pink');
					        			brother.css('background', 'red');
				        			}
				        			if(topPositon == -1 || brotherTop<=topPositon){
				        				if(_this.ifInPostiton(brotherLeft,brotherTop,lastPostion)){
											if(_this.debug){
					        					console.log("USTAW");
					        					brother.css('background', 'blue');
					        				}
				        					topPositon = brotherTop;
											leftPositon = brotherLeft;
				        				}
				        			}
				        		}

			        		}
			        		if(_this.debug){
				        		console.log("topPositon: ", topPositon);
				        		console.log("leftPositon: ", leftPositon);
				        	}
			        		position[0] = topPositon;
			        		position[1] = leftPositon;
			        		lastPostion.push(position);
			        	} else {
			        		position[1] = landigLeft * (_this.rowWidth + _this.gap);
			        	}

		        	} else {
		        		// Ustaw wedĹug standardowego poĹoĹźenia

			        	// USTAW odstÄp od lewej
			        	position[1] = landigLeft * (_this.rowWidth + _this.gap);

			        	// USTAW odstÄp od gĂłry
			        	// NIe ustawiaj pierwszego rzÄdu
			        	if(index>_this.count-1) {
			        		var brotherTop = children.filter(":visible").eq(index-_this.count);
			        		position[0] = memorycalc[index-_this.count].top + brotherTop.outerHeight(true);
			        	} else {
			        		// console.log("N"+index);
			        	}
		        	}


		        	memorycalc[index] = {left: position[1], top: position[0]};


					// NastÄpny rzÄd
					landigLeft += 1;
					if(landigLeft>=_this.count){
						landigLeft = 0;
					}



					// Ustaw koniec girda
		        	if(memorycalc[index].top + element.outerHeight(true) > _this.getBest){
		        		_this.getBest = memorycalc[index].top + element.outerHeight(true);
		        	}
		        	// console.log("getBest: ", _this.getBest);


		        });
		        j_this.css('height',_this.getBest+'px');


				children.each(function() {

		        	var element = $(this),
		        		index = element.filter(":visible").index();

		        	var elementMemoru = memorycalc[index];




		        	// Nadaj pozycje css
		        	if(elementMemoru){
						element.css({
							position: 'absolute',
							top: elementMemoru.top+'px',
							left: elementMemoru.left+'px'
						});
					}

		        });
		        $(_this.child).css('transition', '');
			}


			_this.init();
			// $(_this.child).css('transition', 'none');
			// setTimeout(function() {
			// 	$(_this.child).css('transition', '');
			// }, 1000);
			if(_this.interval){
				setInterval(function(){
					_this.init();
				}, _this.interval);
			}
			setTimeout(function() {
				_this.init();
			}, 500);


			_this.off = function(){

				j_this.css({
					'column-count': '',
					'column-gap': '',
					'position': '',
					'min-height': ''
				});
				_this.child.each(function() {
		        	var element = $(this);

					element.css({
						width: '',
						position: '',
						top: '',
						left: ''
					});
		        });
			}
			$( window ).resize(function() {
				if(_this.debug){
					console.log("window!!!");
				}
				if(_this.bodywidth != $(window).width()){
					$(_this.child).css('transition', 'none');
					_this.bodywidth = $(window).width();
					_this.init();
				}
			});
			// $(_this.child).resize(function() {

			// 	// $(_this.child).css('transition', 'none');
			// 	console.log("elment!!!");
			// 	_this.init();
			// });


			// if(_this.interval){
			// 	$(_this.child).off('transitionend webkitTransitionEnd oTransitionEnd');
			// } else {
			// 	$(_this.child).on('transitionend webkitTransitionEnd oTransitionEnd', function () {
			// 		// $(_this.child).css('transition', 'none');
			// 		_this.init();
			// 	});
			// 	$(window).bind("load", function() {
			// 		$(_this.child).css('transition', 'none');
			// 		_this.init();

			// 	});
			// }




		});
		return _this
    }
    // $('[data-columnstojs]').each(function() {
    // 	var el = $(this);
    // 	var json = el.data('columnstojs');
    // 	json = json.replace(/'/g , '"');
    // 	console.log(json);
    // 	el.columnsToJs(JSON.parse(json));
    // });
})(jQuery);
