
/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update the main button
	wp.customize( 'common_tinymce_button_color', function( value ){
		value.bind( function( newval ) {
			var darken = shadeBlendConvert( -0.10,  newval );
			$( 'a.cts-button.accent-color, button.cts-button.accent-color' )
				.css( { 'background': newval, 'border-color': newval } )
				.hover(
					function() {
					    $( this ).css( { 'border-color': darken, 'background': darken } );
					}, function() {
					    $( this ).css( { 'border-color': newval, 'background': newval } );
					}
				);
			$( 'a.cts-ghost-button.accent-color, button.cts-ghost-button.accent-color' )
				.css( { 'border-color': '#FFF', 'background': 'transparent' } )
				.hover(
					function() {
						$( this ).css( { 'border-color': newval, 'background' : newval } );
					}, function() {
						$( this ).css( { 'border-color': '#FFF', 'background': 'transparent' } );
					}
				);
		});
	});
	
	//Update the alt button
	wp.customize( 'common_tinymce_alt_button_color', function( value ){
		value.bind( function( newval ) {
			var darken = shadeBlendConvert( -0.10,  newval );
			$( 'a.cts-button.alt-color, button.cts-button.alt-color' )
				.css( { 'background': newval, 'border-color': newval } )
				.hover(
					function() {
					    $( this ).css( { 'border-color': darken, 'background': darken } );
					}, function() {
					    $( this ).css( { 'border-color': newval, 'background': newval } );
					}
				);
			$( 'a.cts-ghost-button.alt-color, button.cts-ghost-button.alt-color' )
				.css( { 'border-color': newval } )
				.hover(
					function() {
						$( this ).css( { 'background' : newval } );
					}, function() {
						$( this ).css( { 'background': 'transparent' } );
					}
				);
		});
	});

	//Update the message color
	wp.customize( 'common_tinymce_message_color', function( value ) {
		value.bind( function( newval ) {
			$('.cts-message-box:not(.cts-warning-box)' ).css( {'border-top-color': newval, 'color': newval, 'background-color': shadeBlendConvert( .95, newval ) } );
		} );
	} );

	//Update site background color...
	wp.customize( 'common_tinymce_warning_color', function( value ) {
		value.bind( function( newval ) {
			$('.cts-warning-box' ).css( {'border-top-color': newval, 'color': newval, 'background-color': shadeBlendConvert( .95, newval ) } );
		} );
	} );

	// toggle the checkbox on/off
	wp.customize('common_tinymce_fancy_buttons',function( value ) { 
	    value.bind(function(newval) {
	        if( newval ){
	        	$('body').addClass('cts-use-fancy-buttons');
	        } else {
	        	$('body').removeClass('cts-use-fancy-buttons');
	        }
	    });
	});


	// preview the color shading that will happen in SCSS
	function shadeBlendConvert(p, from, to) {
	    if(typeof(p)!="number"||p<-1||p>1||typeof(from)!="string"||(from[0]!='r'&&from[0]!='#')||(typeof(to)!="string"&&typeof(to)!="undefined"))return null; //ErrorCheck
	    if(!this.sbcRip)this.sbcRip=function(d){
	        var l=d.length,RGB=new Object();
	        if(l>9){
	            d=d.split(",");
	            if(d.length<3||d.length>4)return null;//ErrorCheck
	            RGB[0]=i(d[0].slice(4)),RGB[1]=i(d[1]),RGB[2]=i(d[2]),RGB[3]=d[3]?parseFloat(d[3]):-1;
	        }else{
	            switch(l){case 8:case 6:case 3:case 2:case 1:return null;} //ErrorCheck
	            if(l<6)d="#"+d[1]+d[1]+d[2]+d[2]+d[3]+d[3]+(l>4?d[4]+""+d[4]:""); //3 digit
	            d=i(d.slice(1),16),RGB[0]=d>>16&255,RGB[1]=d>>8&255,RGB[2]=d&255,RGB[3]=l==9||l==5?r(((d>>24&255)/255)*10000)/10000:-1;
	        }
	        return RGB;}
	    var i=parseInt,r=Math.round,h=from.length>9,h=typeof(to)=="string"?to.length>9?true:to=="c"?!h:false:h,b=p<0,p=b?p*-1:p,to=to&&to!="c"?to:b?"#000000":"#FFFFFF",f=sbcRip(from),t=sbcRip(to);
	    if(!f||!t)return null; //ErrorCheck
	    if(h)return "rgb("+r((t[0]-f[0])*p+f[0])+","+r((t[1]-f[1])*p+f[1])+","+r((t[2]-f[2])*p+f[2])+(f[3]<0&&t[3]<0?")":","+(f[3]>-1&&t[3]>-1?r(((t[3]-f[3])*p+f[3])*10000)/10000:t[3]<0?f[3]:t[3])+")");
	    else return "#"+(0x100000000+(f[3]>-1&&t[3]>-1?r(((t[3]-f[3])*p+f[3])*255):t[3]>-1?r(t[3]*255):f[3]>-1?r(f[3]*255):255)*0x1000000+r((t[0]-f[0])*p+f[0])*0x10000+r((t[1]-f[1])*p+f[1])*0x100+r((t[2]-f[2])*p+f[2])).toString(16).slice(f[3]>-1||t[3]>-1?1:3);
	}
	
} )( jQuery );