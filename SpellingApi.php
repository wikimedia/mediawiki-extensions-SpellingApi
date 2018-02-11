<?php
/**
 * SpellApi extension for MediaWiki.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Amir E. Aharoni, 2013
 * @license GPL v2 or later
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'SpellingApi' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['SpellingApi'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for the SpellingApi extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the SpellingApi extension requires MediaWiki 1.25+' );
}
