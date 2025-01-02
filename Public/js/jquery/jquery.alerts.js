// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .01,                // transparency level of overlay
		overlayColor: '#FFF',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;确定&nbsp;',         // text for the OK button
		cancelButton: '取消', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', callback);
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', callback);
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', callback);
		},
		
		jkb_alert: function(message, style, callback) {
			$.alerts._jkb_show(message, style, callback);
		},		
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' + 
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);
			
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text());
			
			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});
			
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						if(callback)
						{
							callback(true);
						}
						return false;
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /><span style="margin:0 10px;">或</span><a href="" id="popup_cancel">' + $.alerts.cancelButton + '</a></div>');
					$("#popup_ok").click( function() {
						if( callback )
						{
							if (callback(true))
							{
								$.alerts._hide();
							}
						}
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback(false);
						return false;
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /><span style="margin:0 10px;">或</span><a href="" id="popup_cancel">' + $.alerts.cancelButton + '</a></div>');
					$("#popup_message").before('<div style="margin: 6px;width:270px;" id="msg_container_popup"></div>');;
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();
						if( callback )
						{
							if (callback(val))
							{
								$.alerts._hide();
							}
						}
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
						return false;
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_jkb_show: function(msg, style, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			var msg_html = '';
			msg_html = 	'<table class="popup_layer" cellpadding="0" cellspacing="0" border="0" id="popup_layer">' +
				  '<tbody>' +
					  '<tr>' +
						  '<td class="t_l"></td>' +
						  '<td class="t_m"></td>' +
						  '<td class="t_r"></td>' +
					  '</tr>' +
					  '<tr>' +
						  '<td class="m_l"></td>' +
						  '<td class="m_m">' +
							  '<div class="m_box">' +
								  '<div class="top"><a href="#" id="popup_close"></a></div>' +
								  '<div class="content">';
								
								if(style == 'ok'){
									msg_html += '<div class="success">' + msg + '</div>';
									msg_html += '<div class="button"><a href="" id="jkb_alert_popup_ok"><span>确认</span></a></div>';
								}else if(style == 'error'){
									msg_html += '<div class="error">' + msg + '</div>';
									msg_html += '<div class="button"><a href="" id="jkb_alert_popup_ok"><span>确认</span></a></div>';
								}else{
									msg_html += msg;
								}
								  
						msg_html += '</div>' + 
								'</div>' +
						  '</td>' +
						  '<td class="m_r"></td>' +
					  '</tr>' +
					  '<tr>' +
						  '<td class="b_l"></td>' +
						  '<td class="b_m"></td>' +
						  '<td class="b_r"></td>' +
					  '</tr>' +
				  '</tbody>' +
			  '</table>'			
			
			$("BODY").append(msg_html);
			
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_layer").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			
			$("#popup_layer").css({
				minWidth: $("#popup_layer").outerWidth(),
				maxWidth: $("#popup_layer").outerWidth()
			});
			
			$.alerts.jkb_reposition();
			
			$("#popup_close").click( function() {
				$.alerts._jkb_hide();
				if( callback ) {
					if(typeof(callback) == 'string' || typeof(callback) == 'String'){
						eval(callback + '( null )');
					}else{
						callback( null );	
					}
				}
				return false;
			});
			$("#jkb_alert_popup_ok").click( function() {
				$.alerts._jkb_hide();
				if( callback ) {
					if(typeof(callback) == 'string' || typeof(callback) == 'String'){
						eval(callback + '( null )');
					}else{
						callback( null );	
					}
				}
				return false;
			});
		},		
		
		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_jkb_hide: function() {
			$("#popup_layer").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},		
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: '#000',
						opacity: 0.1
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		jkb_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_layer").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_layer").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_layer").css({
				top: top + 'px',
				left: left + 'px'
			});
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	
	jkbAlert = function(message, style, callback) {
		$.alerts.jkb_alert(message, style, callback);
	};
	
	jkbAlertHide = function() {
		$.alerts._jkb_hide();;
	};	
	
})(jQuery);