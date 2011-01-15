<?php

/*
=========================================================================
 Copyright (c) 2008 Mark Bowen Design
=========================================================================
 File: pi.fetch_current_uri.php V1.0.3
-------------------------------------------------------------------------
 Purpose: Fetch current full URI of page being viewed and render to page
=========================================================================
CHANGE LOG :

10th March 2008
	- Version 1.0.0
	- Creation of initial plugin

10th March 2008
	- Version 1.0.1
	- Addition of extra features

14th April 2008
	- Version 1.0.2
	- Added in option to allow just the text to be output and not to
	- create the link automatically.
	
15th Januaray 2011 (Volker Rose | volker.rose@gmail.com)
	- Version 1.0.3
	- slightly modified to work with ExpressionEngine 2
=========================================================================
*/


$plugin_info = array(
						'pi_name'			=> 'Fetch Current URI',
						'pi_version'		=> '1.0.3',
						'pi_author'			=> 'Mark Bowen',
						'pi_author_url'		=> 'http://www.markbowendesign.com/',
						'pi_description'	=> 'Fetch current URI of page being viewed and render to page',
						'pi_usage'			=> Fetch_current_uri::usage()
					);


class Fetch_current_uri {

    var $return_data;

    function Fetch_current_uri($str = '') {
	
		$ee =& get_instance();
		
		// Fetch our parameters from the plugin tag
		$uri_only = $ee->TMPL->fetch_param('uri-only');
		$text = $ee->TMPL->fetch_param('text');
		$title = $ee->TMPL->fetch_param('title') ? " title='" . $ee->TMPL->fetch_param('title') . "'" : '';
		$id = $ee->TMPL->fetch_param('id') ? " id='" . $ee->TMPL->fetch_param('id') . "'" : '';
		$class = $ee->TMPL->fetch_param('class') ? " class='" . $ee->TMPL->fetch_param('class') . "'" : '';
		$rel = $ee->TMPL->fetch_param('rel') ? " rel='" . $ee->TMPL->fetch_param('rel') . "'" : '';
			
		// Fetch the full page URI
		$full_page_uri = $ee->functions->fetch_current_uri();
		
		if ($uri_only == "" OR $uri_only == "no")
		{
			if ($text == "")
			{
				$text = $full_page_uri;
			}
			$output = '<a href="' . $full_page_uri . '"' . $class . $id . $rel . $title . '>' . $text . '</a>';
		}
		else {
			$output = $full_page_uri;		
		}
		
		$this->return_data = $output;
	}
   
// END


    
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
// Make sure and use output buffering

function usage()
{
ob_start(); 
?>
Fetch the current page URI and render it to the template.
Just place the following plugin tag on the page where you would like the page URI to be displayed.

{exp:fetch_current_uri text="Link Text" title="My Title" class="css-class" id="my-id" rel="internal" uri-only="yes"}

uri-only="yes" or uri-only="no" - If this parameter isn't supplied then the plugin will create links along with the other parameters shown below.
If supplied however then there are two values, yes and no which can be used. Using no is the same as omitting the parameter whereas yes will allow
you to just return the current uri without turning it into a link.

text="Link Text" - text that displays on the page instead of the URI
If you leave the text="" parameter blank then it will instead place the URI in place of any text that you would have wanted!
title="My Title" - text that gets set in the link title (check source code on page)
class="css-class" - sets the class of the link
id="my-id" - sets the id of the link
rel="internal" - sets the rel for the link

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
// END


}
// END CLASS
?>