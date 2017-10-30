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

$wgExtensionCredits[ 'api' ][] = array(
	'path' => __FILE__,
	'name' => 'SpellingApi',
	'version' => '0.2.0',
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
$wgMessagesDirs['SpellingApi'] = __DIR__ . '/i18n';

// Register the API module
$wgAPIModules['spellingapi'] = 'ApiQuerySpellcheck';
