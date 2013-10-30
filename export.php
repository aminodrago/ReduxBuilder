<?php

function export($panel) {
    header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
    header( "Pragma: no-cache ");
    header( "Content-Description: File Transfer" );
    header( 'Content-Disposition: attachment; filename="theme-options.php"');
    header( "Content-Type: application/octet-stream");
    header( "Content-Transfer-Encoding: binary" );

    $content = '<?php

/**
	ReduxFramework Config File
	For full documentation, please visit http://reduxframework.com/docs/
	Generated '.date("F j, Y @ g:i a").'
**/


// Function to initialize the Redux panel
function custom_theme_options() {
';	

	if ( !empty( $panel['args'] ) ) {
		$content .= '

	$args = ' . objectToHTML( $panel['args'] ) . ';';
	}	

	if ( !empty( $panel['tabs'] ) ) {
		$content .= '

	$tabs = ' . objectToHTML( $panel['tabs'] ) . ';';
	}	

	if ( !empty( $panel['sections'] ) ) {
		$content .= '

	$sections = ' . objectToHTML( $panel['sections'] ) . ';';
	}		

	$content .= '

	// Create the Redux Framework Object
	new ReduxFramework($sections, $args, $tabs);
}
add_action( "init", "custom_theme_options" );
';
	echo $content;    	
}

function objectToHTML($object) {
	// create html
	$html = var_export($object, true);
	
	// change double spaces to tabs
	$html = str_replace("  ", "\t", $html);
	
	// correctly formats "=> array("
	$html = preg_replace('/([\t\r\n]+?)array/', 'array', $html);
	
	// Remove number keys from array
	$html = preg_replace('/[0-9]+ => array/', 'array', $html);
	
	// add extra tab at start of each line
	return str_replace("\n", "\n\t", $html);
}

export( json_encode( file_get_contents('panel.json' ) ) );