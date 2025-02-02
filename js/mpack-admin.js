jQuery(document).ready( function($) {

	addNewSong($);
	removeSong($);
	initializeDateTimePicker($);
	makeSongListSortable($);
	addNewImageToGallery($);
	makeGalleryElementsSortable($);
	handleDeleteImage($);
	dummyImportNotice($);
	importTemplate($);
});

function addNewSong($) {
    $('#mp_add_song').click(function(e) {
        e.preventDefault();

        var meta_image_frame;

		if (meta_image_frame) {
			meta_image_frame.open();
			return;
		}

		meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
			title: "Add New Audio",
			button: { text:  "Add Audio File" },
			library: { type: 'audio' },
			multiple: true
		});

		meta_image_frame.on('select', function(){
			var audio_selection = meta_image_frame.state().get('selection').toJSON();

			audio_selection.forEach(function(item, index) {
				var media_attachment = item;
				var oldInputVal = $('#album_songs_ids').val();
				$.trim(oldInputVal);
				if (oldInputVal != "") {
					oldInputVal += ",";
				}
				oldInputVal += media_attachment.id;
				$('#album_songs_ids').val(oldInputVal);
				render_audio_list($);
			});
		});

		meta_image_frame.open();

    });
}

function render_audio_list($) {
	var audio_ids = $('#album_songs_ids').val();
	var audio_nonce  = $('#mpack_music_album_audiolist_nonce').val();

	var data = {
				action: 'mp_update_audio_list',
				audio_ids: audio_ids,
				audio_ids_nonce: audio_nonce
		};

	$.post(ajaxurl, data, function(response) {
		var obj;
		
		try {
			obj = $.parseJSON(response);
		}
		catch(e) { 
			/*catch some error*/
		}

		if(obj.success === true) { 
			$('div#audio_list').replaceWith(obj.audio_list);
			//makeElementsSortable($);
		}
		removeSong($);
	});
}

function removeSong($) {
	$('.remove_audio').click(function(e){
		e.preventDefault();
		var deleteID = $(this).attr("rel");
		var idContent = $('#album_songs_ids').val();
		var toDeleteString = deleteID + ",";
		if (idContent.search(deleteID + ",") == -1) {
			/*id is on the latest pos*/
			toDeleteString = "," + deleteID;
		}
		if (idContent.search(',') == -1) {
			/*a single element left*/
			toDeleteString = deleteID;
		}
		idContent = idContent.replace(toDeleteString, "");	
		$('#album_songs_ids').val(idContent);

		$('#audio_list').find('li#' + deleteID).remove();
	});
}

function initializeDateTimePicker($) {
	$(".swp_datepicker").datepicker({
		dateFormat : "yy/mm/dd"
	});

	$("#timepicker").timepicker();
}

function makeSongListSortable($) {
		$( "#ul_sortable_list" ).sortable({
			update: function( event, ui ) {
				var trackOrder = jQuery(this).sortable('toArray').toString();
				$('#album_songs_ids').val(trackOrder);

			}
		});
}

!function($){function Timepicker(){this.debug=!0,this._curInst=null,this._disabledInputs=[],this._timepickerShowing=!1,this._inDialog=!1,this._dialogClass="ui-timepicker-dialog",this._mainDivId="ui-timepicker-div",this._inlineClass="ui-timepicker-inline",this._currentClass="ui-timepicker-current",this._dayOverClass="ui-timepicker-days-cell-over",this.regional=[],this.regional[""]={hourText:"Hour",minuteText:"Minute",amPmText:["AM","PM"],closeButtonText:"Done",nowButtonText:"Now",deselectButtonText:"Deselect"},this._defaults={showOn:"focus",button:null,showAnim:"fadeIn",showOptions:{},appendText:"",beforeShow:null,onSelect:null,onClose:null,timeSeparator:":",periodSeparator:" ",showPeriod:!1,showPeriodLabels:!0,showLeadingZero:!0,showMinutesLeadingZero:!0,altField:"",defaultTime:"now",myPosition:"left top",atPosition:"left bottom",onHourShow:null,onMinuteShow:null,hours:{starts:0,ends:23},minutes:{starts:0,ends:55,interval:5},rows:4,showHours:!0,showMinutes:!0,optionalMinutes:!1,showCloseButton:!1,showNowButton:!1,showDeselectButton:!1},$.extend(this._defaults,this.regional[""]),this.tpDiv=$('<div id="'+this._mainDivId+'" class="ui-timepicker ui-widget ui-helper-clearfix ui-corner-all " style="display: none"></div>')}function extendRemove(a,b){$.extend(a,b);for(var c in b)null!=b[c]&&void 0!=b[c]||(a[c]=b[c]);return a}$.extend($.ui,{timepicker:{version:"0.3.2"}});var PROP_NAME="timepicker",tpuuid=(new Date).getTime();$.extend(Timepicker.prototype,{markerClassName:"hasTimepicker",log:function(){this.debug&&console.log.apply("",arguments)},_widgetTimepicker:function(){return this.tpDiv},setDefaults:function(a){return extendRemove(this._defaults,a||{}),this},_attachTimepicker:function(target,settings){var inlineSettings=null;for(var attrName in this._defaults){var attrValue=target.getAttribute("time:"+attrName);if(attrValue){inlineSettings=inlineSettings||{};try{inlineSettings[attrName]=eval(attrValue)}catch(a){inlineSettings[attrName]=attrValue}}}var nodeName=target.nodeName.toLowerCase(),inline="div"==nodeName||"span"==nodeName;target.id||(this.uuid+=1,target.id="tp"+this.uuid);var inst=this._newInst($(target),inline);inst.settings=$.extend({},settings||{},inlineSettings||{}),"input"==nodeName?(this._connectTimepicker(target,inst),this._setTimeFromField(inst)):inline&&this._inlineTimepicker(target,inst)},_newInst:function(a,b){var c=a[0].id.replace(/([^A-Za-z0-9_-])/g,"\\\\$1");return{id:c,input:a,inline:b,tpDiv:b?$('<div class="'+this._inlineClass+' ui-timepicker ui-widget  ui-helper-clearfix"></div>'):this.tpDiv}},_connectTimepicker:function(a,b){var c=$(a);b.append=$([]),b.trigger=$([]),c.hasClass(this.markerClassName)||(this._attachments(c,b),c.addClass(this.markerClassName).keydown(this._doKeyDown).keyup(this._doKeyUp).bind("setData.timepicker",function(a,c,d){b.settings[c]=d}).bind("getData.timepicker",function(a,c){return this._get(b,c)}),$.data(a,PROP_NAME,b))},_doKeyDown:function(a){var b=$.timepicker._getInst(a.target),c=!0;if(b._keyEvent=!0,$.timepicker._timepickerShowing)switch(a.keyCode){case 9:$.timepicker._hideTimepicker(),c=!1;break;case 13:return $.timepicker._updateSelectedValue(b),$.timepicker._hideTimepicker(),!1;case 27:$.timepicker._hideTimepicker();break;default:c=!1}else 36==a.keyCode&&a.ctrlKey?$.timepicker._showTimepicker(this):c=!1;c&&(a.preventDefault(),a.stopPropagation())},_doKeyUp:function(a){var b=$.timepicker._getInst(a.target);$.timepicker._setTimeFromField(b),$.timepicker._updateTimepicker(b)},_attachments:function(a,b){var c=this._get(b,"appendText"),d=this._get(b,"isRTL");b.append&&b.append.remove(),c&&(b.append=$('<span class="'+this._appendClass+'">'+c+"</span>"),a[d?"before":"after"](b.append)),a.unbind("focus.timepicker",this._showTimepicker),a.unbind("click.timepicker",this._adjustZIndex),b.trigger&&b.trigger.remove();var e=this._get(b,"showOn");if("focus"!=e&&"both"!=e||(a.bind("focus.timepicker",this._showTimepicker),a.bind("click.timepicker",this._adjustZIndex)),"button"==e||"both"==e){var f=this._get(b,"button");$(f).bind("click.timepicker",function(){return $.timepicker._timepickerShowing&&$.timepicker._lastInput==a[0]?$.timepicker._hideTimepicker():b.input.is(":disabled")||$.timepicker._showTimepicker(a[0]),!1})}},_inlineTimepicker:function(a,b){var c=$(a);c.hasClass(this.markerClassName)||(c.addClass(this.markerClassName).append(b.tpDiv).bind("setData.timepicker",function(a,c,d){b.settings[c]=d}).bind("getData.timepicker",function(a,c){return this._get(b,c)}),$.data(a,PROP_NAME,b),this._setTimeFromField(b),this._updateTimepicker(b),b.tpDiv.show())},_adjustZIndex:function(a){a=a.target||a;var b=$.timepicker._getInst(a);b.tpDiv.css("zIndex",$.timepicker._getZIndex(a)+1)},_showTimepicker:function(a){if(a=a.target||a,"input"!=a.nodeName.toLowerCase()&&(a=$("input",a.parentNode)[0]),!$.timepicker._isDisabledTimepicker(a)&&$.timepicker._lastInput!=a){$.timepicker._hideTimepicker();var b=$.timepicker._getInst(a);$.timepicker._curInst&&$.timepicker._curInst!=b&&$.timepicker._curInst.tpDiv.stop(!0,!0);var c=$.timepicker._get(b,"beforeShow");extendRemove(b.settings,c?c.apply(a,[a,b]):{}),b.lastVal=null,$.timepicker._lastInput=a,$.timepicker._setTimeFromField(b),$.timepicker._inDialog&&(a.value=""),$.timepicker._pos||($.timepicker._pos=$.timepicker._findPos(a),$.timepicker._pos[1]+=a.offsetHeight);var d=!1;$(a).parents().each(function(){return d|="fixed"==$(this).css("position"),!d}),d&&$.browser.opera&&($.timepicker._pos[0]-=document.documentElement.scrollLeft,$.timepicker._pos[1]-=document.documentElement.scrollTop);var e={left:$.timepicker._pos[0],top:$.timepicker._pos[1]};if($.timepicker._pos=null,b.tpDiv.css({position:"absolute",display:"block",top:"-1000px"}),$.timepicker._updateTimepicker(b),!b.inline&&"object"==typeof $.ui.position){b.tpDiv.position({of:b.input,my:$.timepicker._get(b,"myPosition"),at:$.timepicker._get(b,"atPosition"),collision:"flip"});var e=b.tpDiv.offset();$.timepicker._pos=[e.top,e.left]}if(b._hoursClicked=!1,b._minutesClicked=!1,e=$.timepicker._checkOffset(b,e,d),b.tpDiv.css({position:$.timepicker._inDialog&&$.blockUI?"static":d?"fixed":"absolute",display:"none",left:e.left+"px",top:e.top+"px"}),!b.inline){var f=$.timepicker._get(b,"showAnim"),g=$.timepicker._get(b,"duration"),h=function(){$.timepicker._timepickerShowing=!0;var a=$.timepicker._getBorders(b.tpDiv);b.tpDiv.find("iframe.ui-timepicker-cover").css({left:-a[0],top:-a[1],width:b.tpDiv.outerWidth(),height:b.tpDiv.outerHeight()})};$.timepicker._adjustZIndex(a),$.effects&&$.effects[f]?b.tpDiv.show(f,$.timepicker._get(b,"showOptions"),g,h):b.tpDiv.show(f?g:null,h),f&&g||h(),b.input.is(":visible")&&!b.input.is(":disabled")&&b.input.focus(),$.timepicker._curInst=b}}},_getZIndex:function(a){for(var c,d,b=$(a);b.length&&b[0]!==document;){if(c=b.css("position"),("absolute"===c||"relative"===c||"fixed"===c)&&(d=parseInt(b.css("zIndex"),10),!isNaN(d)&&0!==d))return d;b=b.parent()}},_refreshTimepicker:function(a){var b=this._getInst(a);b&&this._updateTimepicker(b)},_updateTimepicker:function(a){a.tpDiv.empty().append(this._generateHTML(a)),this._rebindDialogEvents(a)},_rebindDialogEvents:function(a){var b=$.timepicker._getBorders(a.tpDiv),c=this;a.tpDiv.find("iframe.ui-timepicker-cover").css({left:-b[0],top:-b[1],width:a.tpDiv.outerWidth(),height:a.tpDiv.outerHeight()}).end().find(".ui-timepicker-minute-cell").unbind().bind("click",{fromDoubleClick:!1},$.proxy($.timepicker.selectMinutes,this)).bind("dblclick",{fromDoubleClick:!0},$.proxy($.timepicker.selectMinutes,this)).end().find(".ui-timepicker-hour-cell").unbind().bind("click",{fromDoubleClick:!1},$.proxy($.timepicker.selectHours,this)).bind("dblclick",{fromDoubleClick:!0},$.proxy($.timepicker.selectHours,this)).end().find(".ui-timepicker td a").unbind().bind("mouseout",function(){$(this).removeClass("ui-state-hover"),this.className.indexOf("ui-timepicker-prev")!=-1&&$(this).removeClass("ui-timepicker-prev-hover"),this.className.indexOf("ui-timepicker-next")!=-1&&$(this).removeClass("ui-timepicker-next-hover")}).bind("mouseover",function(){c._isDisabledTimepicker(a.inline?a.tpDiv.parent()[0]:a.input[0])||($(this).parents(".ui-timepicker-calendar").find("a").removeClass("ui-state-hover"),$(this).addClass("ui-state-hover"),this.className.indexOf("ui-timepicker-prev")!=-1&&$(this).addClass("ui-timepicker-prev-hover"),this.className.indexOf("ui-timepicker-next")!=-1&&$(this).addClass("ui-timepicker-next-hover"))}).end().find("."+this._dayOverClass+" a").trigger("mouseover").end().find(".ui-timepicker-now").bind("click",function(a){$.timepicker.selectNow(a)}).end().find(".ui-timepicker-deselect").bind("click",function(a){$.timepicker.deselectTime(a)}).end().find(".ui-timepicker-close").bind("click",function(a){$.timepicker._hideTimepicker()}).end()},_generateHTML:function(a){var b,d,e,f,i=1==this._get(a,"showPeriod"),j=1==this._get(a,"showPeriodLabels"),k=1==this._get(a,"showLeadingZero"),l=1==this._get(a,"showHours"),m=1==this._get(a,"showMinutes"),n=this._get(a,"amPmText"),o=this._get(a,"rows"),p=0,q=0,r=0,s=0,t=0,u=0,v=Array(),w=this._get(a,"hours"),x=null,y=0,z=this._get(a,"hourText"),A=this._get(a,"showCloseButton"),B=this._get(a,"closeButtonText"),C=this._get(a,"showNowButton"),D=this._get(a,"nowButtonText"),E=this._get(a,"showDeselectButton"),F=this._get(a,"deselectButtonText"),G=A||C||E;for(b=w.starts;b<=w.ends;b++)v.push(b);if(x=Math.ceil(v.length/o),j){for(y=0;y<v.length;y++)v[y]<12?r++:s++;y=0,p=Math.floor(r/v.length*o),q=Math.floor(s/v.length*o),o!=p+q&&(r&&(!s||!p||q&&r/p>=s/q)?p++:q++),t=Math.min(p,1),u=p+1,x=0==p?Math.ceil(s/q):0==q?Math.ceil(r/p):Math.ceil(Math.max(r/p,s/q))}if(f='<table class="ui-timepicker-table ui-widget-content ui-corner-all"><tr>',l){for(f+='<td class="ui-timepicker-hours"><div class="ui-timepicker-title ui-widget-header ui-helper-clearfix ui-corner-all">'+z+'</div><table class="ui-timepicker">',d=1;d<=o;d++){for(f+="<tr>",d==t&&j&&(f+='<th rowspan="'+p.toString()+'" class="periods" scope="row">'+n[0]+"</th>"),d==u&&j&&(f+='<th rowspan="'+q.toString()+'" class="periods" scope="row">'+n[1]+"</th>"),e=1;e<=x;e++)j&&d<u&&v[y]>=12?f+=this._generateHTMLHourCell(a,void 0,i,k):(f+=this._generateHTMLHourCell(a,v[y],i,k),y++);f+="</tr>"}f+="</table></td>"}if(m&&(f+='<td class="ui-timepicker-minutes">',f+=this._generateHTMLMinutes(a),f+="</td>"),f+="</tr>",G){var H='<tr><td colspan="3"><div class="ui-timepicker-buttonpane ui-widget-content">';C&&(H+='<button type="button" class="ui-timepicker-now ui-state-default ui-corner-all"  data-timepicker-instance-id="#'+a.id.replace(/\\\\/g,"\\")+'" >'+D+"</button>"),E&&(H+='<button type="button" class="ui-timepicker-deselect ui-state-default ui-corner-all"  data-timepicker-instance-id="#'+a.id.replace(/\\\\/g,"\\")+'" >'+F+"</button>"),A&&(H+='<button type="button" class="ui-timepicker-close ui-state-default ui-corner-all"  data-timepicker-instance-id="#'+a.id.replace(/\\\\/g,"\\")+'" >'+B+"</button>"),f+=H+"</div></td></tr>"}return f+="</table>"},_updateMinuteDisplay:function(a){var b=this._generateHTMLMinutes(a);a.tpDiv.find("td.ui-timepicker-minutes").html(b),this._rebindDialogEvents(a)},_generateHTMLMinutes:function(a){var b,c,d="",e=this._get(a,"rows"),f=Array(),g=this._get(a,"minutes"),h=null,i=0,j=1==this._get(a,"showMinutesLeadingZero"),k=this._get(a,"onMinuteShow"),l=this._get(a,"minuteText");for(g.starts||(g.starts=0),g.ends||(g.ends=59),b=g.starts;b<=g.ends;b+=g.interval)f.push(b);if(h=Math.round(f.length/e+.49),k&&0==k.apply(a.input?a.input[0]:null,[a.hours,a.minutes]))for(i=0;i<f.length;i+=1)if(b=f[i],k.apply(a.input?a.input[0]:null,[a.hours,b])){a.minutes=b;break}for(d+='<div class="ui-timepicker-title ui-widget-header ui-helper-clearfix ui-corner-all">'+l+'</div><table class="ui-timepicker">',i=0,c=1;c<=e;c++){for(d+="<tr>";i<c*h;){var b=f[i],m="";void 0!==b&&(m=b<10&&j?"0"+b.toString():b.toString()),d+=this._generateHTMLMinuteCell(a,b,m),i++}d+="</tr>"}return d+="</table>"},_generateHTMLHourCell:function(a,b,c,d){var e=b;b>12&&c&&(e=b-12),0==e&&c&&(e=12),e<10&&d&&(e="0"+e);var f="",g=!0,h=this._get(a,"onHourShow");return void 0==b?f='<td><span class="ui-state-default ui-state-disabled">&nbsp;</span></td>':(h&&(g=h.apply(a.input?a.input[0]:null,[b])),f=g?'<td class="ui-timepicker-hour-cell" data-timepicker-instance-id="#'+a.id.replace(/\\\\/g,"\\")+'" data-hour="'+b.toString()+'"><a class="ui-state-default '+(b==a.hours?"ui-state-active":"")+'">'+e.toString()+"</a></td>":'<td><span class="ui-state-default ui-state-disabled '+(b==a.hours?" ui-state-active ":" ")+'">'+e.toString()+"</span></td>")},_generateHTMLMinuteCell:function(a,b,c){var d="",e=!0,f=this._get(a,"onMinuteShow");return f&&(e=f.apply(a.input?a.input[0]:null,[a.hours,b])),d=void 0==b?'<td><span class="ui-state-default ui-state-disabled">&nbsp;</span></td>':e?'<td class="ui-timepicker-minute-cell" data-timepicker-instance-id="#'+a.id.replace(/\\\\/g,"\\")+'" data-minute="'+b.toString()+'" ><a class="ui-state-default '+(b==a.minutes?"ui-state-active":"")+'" >'+c+"</a></td>":'<td><span class="ui-state-default ui-state-disabled" >'+c+"</span></td>"},_destroyTimepicker:function(a){var b=$(a),c=$.data(a,PROP_NAME);if(b.hasClass(this.markerClassName)){var d=a.nodeName.toLowerCase();$.removeData(a,PROP_NAME),"input"==d?(c.append.remove(),c.trigger.remove(),b.removeClass(this.markerClassName).unbind("focus.timepicker",this._showTimepicker).unbind("click.timepicker",this._adjustZIndex)):"div"!=d&&"span"!=d||b.removeClass(this.markerClassName).empty()}},_enableTimepicker:function(a){var b=$(a),c=b.attr("id"),d=$.data(a,PROP_NAME);if(b.hasClass(this.markerClassName)){var e=a.nodeName.toLowerCase();if("input"==e){a.disabled=!1;var f=this._get(d,"button");$(f).removeClass("ui-state-disabled").disabled=!1,d.trigger.filter("button").each(function(){this.disabled=!1}).end()}else if("div"==e||"span"==e){var g=b.children("."+this._inlineClass);g.children().removeClass("ui-state-disabled"),g.find("button").each(function(){this.disabled=!1})}this._disabledInputs=$.map(this._disabledInputs,function(a){return a==c?null:a})}},_disableTimepicker:function(a){var b=$(a),c=$.data(a,PROP_NAME);if(b.hasClass(this.markerClassName)){var d=a.nodeName.toLowerCase();if("input"==d){var e=this._get(c,"button");$(e).addClass("ui-state-disabled").disabled=!0,a.disabled=!0,c.trigger.filter("button").each(function(){this.disabled=!0}).end()}else if("div"==d||"span"==d){var f=b.children("."+this._inlineClass);f.children().addClass("ui-state-disabled"),f.find("button").each(function(){this.disabled=!0})}this._disabledInputs=$.map(this._disabledInputs,function(b){return b==a?null:b}),this._disabledInputs[this._disabledInputs.length]=b.attr("id")}},_isDisabledTimepicker:function(a){if(!a)return!1;for(var b=0;b<this._disabledInputs.length;b++)if(this._disabledInputs[b]==a)return!0;return!1},_checkOffset:function(a,b,c){var d=a.tpDiv.outerWidth(),e=a.tpDiv.outerHeight(),f=a.input?a.input.outerWidth():0,g=a.input?a.input.outerHeight():0,h=document.documentElement.clientWidth+$(document).scrollLeft(),i=document.documentElement.clientHeight+$(document).scrollTop();return b.left-=this._get(a,"isRTL")?d-f:0,b.left-=c&&b.left==a.input.offset().left?$(document).scrollLeft():0,b.top-=c&&b.top==a.input.offset().top+g?$(document).scrollTop():0,b.left-=Math.min(b.left,b.left+d>h&&h>d?Math.abs(b.left+d-h):0),b.top-=Math.min(b.top,b.top+e>i&&i>e?Math.abs(e+g):0),b},_findPos:function(a){for(var b=this._getInst(a),c=this._get(b,"isRTL");a&&("hidden"==a.type||1!=a.nodeType);)a=a[c?"previousSibling":"nextSibling"];var d=$(a).offset();return[d.left,d.top]},_getBorders:function(a){var b=function(a){return{thin:1,medium:2,thick:3}[a]||a};return[parseFloat(b(a.css("border-left-width"))),parseFloat(b(a.css("border-top-width")))]},_checkExternalClick:function(a){if($.timepicker._curInst){var b=$(a.target);b[0].id==$.timepicker._mainDivId||0!=b.parents("#"+$.timepicker._mainDivId).length||b.hasClass($.timepicker.markerClassName)||b.hasClass($.timepicker._triggerClass)||!$.timepicker._timepickerShowing||$.timepicker._inDialog&&$.blockUI||$.timepicker._hideTimepicker()}},_hideTimepicker:function(a){var b=this._curInst;if(b&&(!a||b==$.data(a,PROP_NAME))&&this._timepickerShowing){var c=this._get(b,"showAnim"),d=this._get(b,"duration"),e=function(){$.timepicker._tidyDialog(b),this._curInst=null};$.effects&&$.effects[c]?b.tpDiv.hide(c,$.timepicker._get(b,"showOptions"),d,e):b.tpDiv["slideDown"==c?"slideUp":"fadeIn"==c?"fadeOut":"hide"](c?d:null,e),c||e(),this._timepickerShowing=!1,this._lastInput=null,this._inDialog&&(this._dialogInput.css({position:"absolute",left:"0",top:"-100px"}),$.blockUI&&($.unblockUI(),$("body").append(this.tpDiv))),this._inDialog=!1;var f=this._get(b,"onClose");f&&f.apply(b.input?b.input[0]:null,[b.input?b.input.val():"",b])}},_tidyDialog:function(a){a.tpDiv.removeClass(this._dialogClass).unbind(".ui-timepicker")},_getInst:function(a){try{return $.data(a,PROP_NAME)}catch(a){throw"Missing instance data for this timepicker"}},_get:function(a,b){return void 0!==a.settings[b]?a.settings[b]:this._defaults[b]},_setTimeFromField:function(a){if(a.input.val()!=a.lastVal){var b=this._get(a,"defaultTime"),c="now"==b?this._getCurrentTimeRounded(a):b;if(0==a.inline&&""!=a.input.val()&&(c=a.input.val()),c instanceof Date)a.hours=c.getHours(),a.minutes=c.getMinutes();else{var d=a.lastVal=c;if(""==c)a.hours=-1,a.minutes=-1;else{var e=this.parseTime(a,d);a.hours=e.hours,a.minutes=e.minutes}}$.timepicker._updateTimepicker(a)}},_optionTimepicker:function(a,b,c){var d=this._getInst(a);if(2==arguments.length&&"string"==typeof b)return"defaults"==b?$.extend({},$.timepicker._defaults):d?"all"==b?$.extend({},d.settings):this._get(d,b):null;var e=b||{};"string"==typeof b&&(e={},e[b]=c),d&&(this._curInst==d&&this._hideTimepicker(),extendRemove(d.settings,e),this._updateTimepicker(d))},_setTimeTimepicker:function(a,b){var c=this._getInst(a);c&&(this._setTime(c,b),this._updateTimepicker(c),this._updateAlternate(c,b))},_setTime:function(a,b,c){var d=a.hours,e=a.minutes;if(b instanceof Date)a.hours=b.getHours(),a.minutes=b.getMinutes();else{var b=this.parseTime(a,b);a.hours=b.hours,a.minutes=b.minutes}d==a.hours&&e==a.minutes||c||a.input.trigger("change"),this._updateTimepicker(a),this._updateSelectedValue(a)},_getCurrentTimeRounded:function(a){var b=new Date,c=b.getMinutes(),d=5*Math.round(c/5);return b.setMinutes(d),b},parseTime:function(a,b){var c=new Object;if(c.hours=-1,c.minutes=-1,!b)return"";var d=this._get(a,"timeSeparator"),e=this._get(a,"amPmText"),f=this._get(a,"showHours"),g=this._get(a,"showMinutes"),h=this._get(a,"optionalMinutes"),i=1==this._get(a,"showPeriod"),j=b.indexOf(d);if(j!=-1?(c.hours=parseInt(b.substr(0,j),10),c.minutes=parseInt(b.substr(j+1),10)):!f||g&&!h?!f&&g&&(c.minutes=parseInt(b,10)):c.hours=parseInt(b,10),f){var k=b.toUpperCase();c.hours<12&&i&&k.indexOf(e[1].toUpperCase())!=-1&&(c.hours+=12),12==c.hours&&i&&k.indexOf(e[0].toUpperCase())!=-1&&(c.hours=0)}return c},selectNow:function(a){var b=$(a.target).attr("data-timepicker-instance-id"),c=$(b),d=this._getInst(c[0]),e=new Date;d.hours=e.getHours(),d.minutes=e.getMinutes(),this._updateSelectedValue(d),this._updateTimepicker(d),this._hideTimepicker()},deselectTime:function(a){var b=$(a.target).attr("data-timepicker-instance-id"),c=$(b),d=this._getInst(c[0]);d.hours=-1,d.minutes=-1,this._updateSelectedValue(d),this._hideTimepicker()},selectHours:function(a){var b=$(a.currentTarget),c=b.attr("data-timepicker-instance-id"),d=parseInt(b.attr("data-hour")),e=a.data.fromDoubleClick,f=$(c),g=this._getInst(f[0]),h=1==this._get(g,"showMinutes");if($.timepicker._isDisabledTimepicker(f.attr("id")))return!1;b.parents(".ui-timepicker-hours:first").find("a").removeClass("ui-state-active"),b.children("a").addClass("ui-state-active"),g.hours=d;var i=this._get(g,"onMinuteShow");return i&&this._updateMinuteDisplay(g),this._updateSelectedValue(g),g._hoursClicked=!0,(g._minutesClicked||e||0==h)&&$.timepicker._hideTimepicker(),!1},selectMinutes:function(a){var b=$(a.currentTarget),c=b.attr("data-timepicker-instance-id"),d=parseInt(b.attr("data-minute")),e=a.data.fromDoubleClick,f=$(c),g=this._getInst(f[0]),h=1==this._get(g,"showHours");return!$.timepicker._isDisabledTimepicker(f.attr("id"))&&(b.parents(".ui-timepicker-minutes:first").find("a").removeClass("ui-state-active"),b.children("a").addClass("ui-state-active"),g.minutes=d,this._updateSelectedValue(g),g._minutesClicked=!0,!(!g._hoursClicked&&!e&&0!=h)&&($.timepicker._hideTimepicker(),!1))},_updateSelectedValue:function(a){var b=this._getParsedTime(a);a.input&&(a.input.val(b),a.input.trigger("change"));var c=this._get(a,"onSelect");return c&&c.apply(a.input?a.input[0]:null,[b,a]),this._updateAlternate(a,b),b},_getParsedTime:function(a){if(a.hours==-1&&a.minutes==-1)return"";(a.hours<a.hours.starts||a.hours>a.hours.ends)&&(a.hours=0),(a.minutes<a.minutes.starts||a.minutes>a.minutes.ends)&&(a.minutes=0);var b="",c=1==this._get(a,"showPeriod"),d=1==this._get(a,"showLeadingZero"),e=1==this._get(a,"showHours"),f=1==this._get(a,"showMinutes"),g=1==this._get(a,"optionalMinutes"),h=this._get(a,"amPmText"),i=a.hours?a.hours:0,j=a.minutes?a.minutes:0,k=i?i:0,l="";k==-1&&(k=0),j==-1&&(j=0),c&&(0==a.hours&&(k=12),a.hours<12?b=h[0]:(b=h[1],k>12&&(k-=12)));var m=k.toString();d&&k<10&&(m="0"+m);var n=j.toString();return j<10&&(n="0"+n),e&&(l+=m),!e||!f||g&&0==n||(l+=this._get(a,"timeSeparator")),!f||g&&0==n||(l+=n),e&&b.length>0&&(l+=this._get(a,"periodSeparator")+b),l},_updateAlternate:function(a,b){var c=this._get(a,"altField");c&&$(c).each(function(a,c){$(c).val(b)})},_getTimeAsDateTimepicker:function(a){var b=this._getInst(a);return b.hours==-1&&b.minutes==-1?"":((b.hours<b.hours.starts||b.hours>b.hours.ends)&&(b.hours=0),(b.minutes<b.minutes.starts||b.minutes>b.minutes.ends)&&(b.minutes=0),new Date(0,0,0,b.hours,b.minutes,0))},_getTimeTimepicker:function(a){var b=this._getInst(a);return this._getParsedTime(b)},_getHourTimepicker:function(a){var b=this._getInst(a);return void 0==b?-1:b.hours},_getMinuteTimepicker:function(a){var b=this._getInst(a);return void 0==b?-1:b.minutes}}),$.fn.timepicker=function(a){$.timepicker.initialized||($(document).mousedown($.timepicker._checkExternalClick).find("body").append($.timepicker.tpDiv),$.timepicker.initialized=!0);var b=Array.prototype.slice.call(arguments,1);return"string"!=typeof a||"getTime"!=a&&"getTimeAsDate"!=a&&"getHour"!=a&&"getMinute"!=a?"option"==a&&2==arguments.length&&"string"==typeof arguments[1]?$.timepicker["_"+a+"Timepicker"].apply($.timepicker,[this[0]].concat(b)):this.each(function(){"string"==typeof a?$.timepicker["_"+a+"Timepicker"].apply($.timepicker,[this].concat(b)):$.timepicker._attachTimepicker(this,a)}):$.timepicker["_"+a+"Timepicker"].apply($.timepicker,[this[0]].concat(b))},$.timepicker=new Timepicker,$.timepicker.initialized=!1,$.timepicker.uuid=(new Date).getTime(),$.timepicker.version="0.3.2",window["TP_jQuery_"+tpuuid]=$}(jQuery);

function addNewImageToGallery($) {
    $('#js_swp_add_image_gallery_cpt').click(function(e){
        e.preventDefault();

        var meta_image_frame;
 
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Add Image To Gallery",
            button: { text:  "Add Image" },
            library: { type: 'image' },
            multiple: true
        });
 
        meta_image_frame.on('select', function(){
        	var img_selection = meta_image_frame.state().get('selection').toJSON();

        	img_selection.forEach(function(item, index) {
				var media_attachment = item; /*meta_image_frame.state().get('selection').first().toJSON();*/
				var oldInputVal = $('#js_swp_gallery_images_id').val();
				$.trim(oldInputVal);
				if (oldInputVal != "") {
					oldInputVal += ",";
				}
				oldInputVal += media_attachment.id;
				$('#js_swp_gallery_images_id').val(oldInputVal);        		
        	});

			/*trigger preview repaint*/
			repaintGalleryPreview($);
         });
 
        meta_image_frame.open();
    });
}

function repaintGalleryPreview($) {
	var imageIds = $('#js_swp_gallery_images_id').val();
	var imageIdsNonce = $('#mpack_gallery_save_nonce').val();

	var data = {
				action: 'mp_update_gallery_preview',
				image_ids: imageIds,
				imageIdsNonce: imageIdsNonce
		};
	
	$.post(ajaxurl, data, function(response) {
		var obj;
		
		try {
			obj = $.parseJSON(response);
		}
		catch(e) { 
			/*catch some error*/
		}

		if(obj.success === true) { 
			$('#js_swp_gallery_content').replaceWith(obj.gallery);
			makeGalleryElementsSortable($);
		}
	});
}

function makeGalleryElementsSortable($) {
	if ($( ".js_swp_gallery_cpt_preview" ).length) {
		$(".js_swp_gallery_cpt_preview").sortable({
			update: function(event, ui){
				var photoOrder = $(this).sortable('toArray').toString();
				handleSortableDropImage($, photoOrder);
			}
		});
	}
}

function handleSortableDropImage($, newOrder) {
	$('#js_swp_gallery_images_id').val(newOrder);
}

function handleDeleteImage($) {
	$(".remove_gallery_cpt_image").click(function(e){
		e.preventDefault();
		var deleteIndex = $(this).data("imid");
		var idContent = $('#js_swp_gallery_images_id').val();
		var toDeleteString = deleteIndex+",";
		if (idContent.search(deleteIndex+",") == -1) {
			/*id is on the latest pos*/
			toDeleteString = ","+deleteIndex;
		}
		idContent = idContent.replace(toDeleteString, "" );	

		$('#js_swp_gallery_images_id').val(idContent);
		deleteImageFromPreview($, deleteIndex);
	});
}

function deleteImageFromPreview($, imgId) {
	$("#js_swp_gallery_content").find("li#"+imgId).remove();
}

function dummyImportNotice($) {
	$('.swp_import_dummy_btn').click(function(e){
		e.preventDefault();

		var $btn_import = $(this);
        var data={
        	'action':'mpack_generate_dummy_data',
        	'id':'101',
        }

        $btn_import.text('Generating data in the background, please wait...');

        var $notice = $(this).closest('.swp_notice');

        jQuery.ajax({
            url: swpvars.ajaxurl,
            type: "post",
            data: data,
            dataType: "json",
            async: !0,
            success: function(e) {
                if (e=="success") {
					$btn_import.text('Dummy data generated successfully. Thank you!');
					setTimeout(function(){
							$notice.fadeTo(100, 0, function() {
								$notice.slideUp(100, function() {
									$notice.remove();
								});
							});
	                   }, 1000);

                }
            }
        });
	});

	$('.swp_import_notice_close').click(function(e){
		e.preventDefault();

        var data={
        	'action':'mpack_prevent_dummy_import_notice',
        	'id':'101',
        }

        var $notice = $(this).closest('.swp_notice');

        jQuery.ajax({
            url: swpvars.ajaxurl,
            type: "post",
            data: data,
            dataType: "json",
            async: !0,
            success: function(e) {
                if (e=="success") {
                   	$notice.fadeTo(100, 0, function() {
						$notice.slideUp(100, function() {
							$notice.remove();
						});
					});
                }
            }
        });
	});
}

function importTemplate($) {
	$('.mpack_cta_text.import_available').click(function(e){
		e.preventDefault();

		var elt = $(this);
		var please_wait = elt.parent().find('.mpfe_importing');

		$('.mpfe_import_notice').hide();
		elt.hide();
		please_wait.show();

		var json_file = $(this).data('file');
		var n_check = $(this).closest('.mpfe_player_templates').find('#mpack_template_import_nonce').val();

		var data = {
			action: 'mpack_import_template',
			filename: json_file,
			nonce: n_check
		};

		$.post(
			swpvars.ajaxurl, 
			data, 
			function(response) {
				var obj;

				obj = $.parseJSON(response);
				elt.show();
				please_wait.hide();
				$("html, body").animate({ scrollTop: 0 }, "slow");
				if(obj.success === true) { 
					$('.mpfe_import_success').show();
				} else {
					$('.mpfe_import_error_message').remove();
					$('.mpfe_import_failed').append('<div class="mpfe_import_error_message"><strong>' + obj.message + '</strong></div>');
					$('.mpfe_import_failed').show();
				}
			});
	});

	$('.single_templ_tag').click(function(){
		var parent = $('.mpfe_player_templates');
		var tmpl_name = $(this).data('name');

		if ('all' == tmpl_name) {
			parent.find('.mpfe_templ_container').show();
		} else {
			parent.find('.mpfe_templ_container').hide();
			parent.find('.mpfe_templ_container.' + tmpl_name).show();
			
		}

		$(this).parent().find('.single_templ_tag').removeClass('active_tag');
		$(this).addClass('active_tag');
	});
}