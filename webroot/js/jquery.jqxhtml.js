/*
JQXHTML V 0.3
Author : Alaa-eddine KADDOURI     (alaa.eddine AT    G M A I L    DOT   C O M )

History
v 0.1 : first release
v 0.2 : fixed br, hr, and area tags for IE
v 0.3 : Firefox doesn't return valid xhtml for img, input, area, br and hr when original html is not valid !  (fixed)

Jqxhtml is a jquery extension that fix innerHTML non valid code.
it can be used like jquery html() methode . 
the approach of jqxhtml is not to really validate the html code : all buggy/malformed code can be enumerated (a same version of a browser uses the same rendering engine => same bugs)
the approach is to enumerate all case where invalid code is generated and fix them using regular expressions


this is a beta release  I only tested ir on some html examples with IE6, IE7 and firefox


comments and suggestions are welcome
*/

jQuery.fn.extend({
xhtml: function( val ) {

	function lower() {			
		return '<'+arguments[1].toLowerCase()+arguments[2] +'>';
	}	
	
	function quoteAttr() {
		attributes = arguments[2];
		attributes = attributes.replace(/(.+)=([^"].+[^"])\s+/ig, '$1="$2" '); 
		attributes = attributes.replace(/\s+(.+)=([^"].+[^"])/ig, ' $1="$2"'); 
		return '<' + arguments[1].toLowerCase() + ' ' + attributes +'>';
	}	

	
	if (val == undefined)
	{
		if (this.length == 0) return null;
		string = this[0].innerHTML;
		if (jQuery.browser.msie) 
		{
			string = string.replace(/<(\/?\w+)(\s*[^>]*)>/igm, lower); //lower case				
			
			//fix tags that don't need closing tags
			string = string.replace(/<(img|input|area|br|hr)\s(.*)\B>/igm,'<$1 $2/>'); 
			string = string.replace(/<(img|input|area|br|hr)(\s*)>/igm,'<$1 />');
			string = string.replace(/<\/(img|input)>/igm,''); 
			 
	
			//TODO : is there a way to do it without callback ?
			string = string.replace(/<(\/?\w+)\s+([^>]*)>/igm, quoteAttr); //fix attributes : add quotes
			
			string = string.replace(/<li>/igm,'</li>\n<li>'); //fix lists : first add closing /LI to all list elements
			string = string.replace(/(<ul>(\s*)<\/li>)/igm,'<ul>'); //fix lists : then remove the one folowing UL
			string = string.replace(/(<\/li>(\s*)<\/li>)/igm,'</li>'); //fix lists : then remove the one folowing UL
			
		}
		if (jQuery.browser.mozilla)
		{
			//fix tags that don't need closing tags
			string = string.replace(/<(img|input|area|br|hr)\s(.*)\B>/igm,'<$1 $2/>'); 
			string = string.replace(/<(img|input|area|br|hr)(\s*)>/igm,'<$1 />');
			string = string.replace(/<\/(img|input)>/igm,''); 		
		}
		return string;		
	}
	else this.empty().append( val );
}

});
