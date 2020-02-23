<?php
/**
 * A web API module for checking the spelling of text.
 * Requires the pspell library and installed dictionaries.
 *
 * @file
 * @ingroup Extensions
 * @author Amir E. Aharoni, 2013
 * @author Anish Patil, 2013
 * @author Niklas Laxström, 2013
 *
 * @license GPL v2 or later
 */

use MediaWiki\MediaWikiServices;

class ApiQuerySpellcheck extends ApiBase {
	protected $langCode;

	public function execute() {
		$params = $this->extractRequestParams();

		if ( $params['langcode'] ) {
			$this->langCode = $params['langcode'];
		} else {
			$this->langCode = MediaWikiServices::getInstance()->getContentLanguage()->getCode();
		}

		$result = $this->spellCheck( $params['text'] );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}

	private function spellCheck( $text ) {
		$pspell = pspell_new( $this->langCode );

		if ( $pspell === false ) {
			$this->dieUsage(
				"Spelling dictionary for language '" . $this->langCode . "' could not be initialized",
				'pspellnewerror'
			);
		}

		$stripped = strip_tags( $text );
		// TODO: Make it smarter for languages that don't use spaces
		// and for punctuation.
		$words = explode( ' ', $stripped );
		$result = array();

		foreach ( $words as $word ) {
			if ( pspell_check( $pspell, $word ) ) {
				$result[] = $word;
			} else {
				$result[] = "<span class='misspelled'>$word</span>";
			}
		}

		return implode( ' ', $result );
	}

	public function getAllowedParams() {
		return array(
			'text' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'langcode' => array (
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => false
			),
		);
	}
}
