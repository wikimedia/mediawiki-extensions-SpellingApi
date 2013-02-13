<?php
/**
 * SpellApi extension for MediaWiki.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Amir E. Aharoni, 2013
 * @license GPL v2 or later
 * @version 0.1
 */

$wgExtensionCredits[ 'api' ][] = array(
	'path' => __FILE__,
	'name' => 'SpellingApi',
	'version' => '0.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SpellingApi',
	'author' => array(
		'Amir E. Aharoni',
		'Anish Patil',
		'Niklas Laxström',
	),
	'descriptionmsg' => 'spellingapi-desc'
);

/* Setup */

// Register files
$wgAutoloadClasses[ 'ApiQuerySpellcheck' ] = __DIR__ . '/api/ApiQuerySpellcheck.php';
$wgExtensionMessagesFiles[ 'SpellingApi' ] = __DIR__ . '/SpellingApi.i18n.php';

// Register the API module
$wgAPIModules['spellingapi'] = 'ApiQuerySpellcheck';
