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

class ApiQuerySpellcheck extends ApiBase {
	protected $langCode;

	public function execute() {
		$params = $this->extractRequestParams();

		if ( $params['langcode'] ) {
			$this->langCode = $params['langcode'];
		} else {
			global $wgContLang;
			$this->langCode = $wgContLang->getCode();
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

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'pspellnewerror', 'info' => "Spelling dictionary for language '" . $this->langCode . "' could not be initialized" ),
		) );
	}

	public function getDescription() {
		return 'Check the spelling of a text string.';
	}

	public function getParamDescription() {
		return array(
			'text'           => 'Text, the spelling of which you want to check.',
			'langcode'       => 'Language code. The default is the the code of $wgContLang.',
		);
	}
}
