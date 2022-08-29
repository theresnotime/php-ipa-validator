<?php
/**
 * IPA Validator class
 *
 * PHP version 7
 *
 * @package   IPA Validator
 * @author    TheresNoTime <sam@theresnotime.co.uk>
 * @copyright 2022 TheresNoTime
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-2.0-or-later
 */
declare( strict_types=1 );
namespace TheresNoTime\IPAValidator;

require_once __DIR__ . '/../vendor/autoload.php';

use Exception;

/**
 * IPA Validator class
 *
 * @package  IPA Validator
 * @author   TheresNoTime <sam@theresnotime.co.uk>
 * @license  https://opensource.org/licenses/GPL-3.0 GPL-2.0-or-later
 */
class Validator {

	/** @var string */
	protected $ipaRegex = <<<EOD
	/^[().a-z|æçðøħŋœǀ-ǃɐ-ɻɽɾʀ-ʄʈ-ʒʔʕʘʙʛ-ʝʟʡʢʰʲʷʼˀˈˌːˑ˞ˠˡˤ-˩̴̘̙̜̝̞̟̠̤̥̩̪̬̯̰̹̺̻̼̀́̂̃̄̆̈̊̋̌̏̽̚͜͡βθχ᷄᷅᷈‖‿ⁿⱱ]+$/ui
	EOD;

	/** @var string */
	protected $stripRegex = "/[\/\[\]]/ui";

	/** @var string */
	protected $diacriticsRegex = "/[\x{0300}-\x{036f}]/ui";

	/** @var bool */
	protected $strip;

	/** @var bool */
	protected $normalize;

	/** @var bool */
	protected $google;

	/** @var string */
	public $originalIPA;

	/** @var string */
	public $normalizedIPA;

	/** @var bool */
	public $valid;

	/**
	 * Constructor
	 *
	 * @param string $ipa IPA to validate
	 * @param bool $strip Remove delimiters
	 * @param bool $normalize Normalize IPA
	 * @param bool $google Normalize IPA for Google TTS
	 * @return void
	 */
	public function __construct( $ipa, $strip = true, $normalize = false, $google = false ) {
		$this->originalIPA = strval( $ipa );
		$this->normalizedIPA = strval( $ipa );
		$this->strip = boolval( $strip );
		$this->normalize = boolval( $normalize );
		$this->google = boolval( $google );
		$this->valid = boolval( $this->validate() );
	}

	/**
	 * Remove diacritics from the IPA string
	 *
	 * @return string
	 */
	private function removeDiacritics() {
		if ( $this->strip ) {
			$this->stripIPA();
		}

		$this->normalizedIPA = preg_replace( $this->diacriticsRegex, '', $this->normalizedIPA );

		return $this->normalizedIPA;
	}

	/**
	 * Normalize the IPA string
	 *
	 * @return string
	 */
	private function normalizeIPA() {
		if ( $this->strip ) {
			$this->stripIPA();
		}

		/*
		 * I'm going to guess Google's normalization is weird
		 * and different from what anyone else will want.
		 */
		if ( $this->google ) {
			/** @var string[] */
			$charmap = [
				[ '(', '' ],
				[ ')', '' ],
				[ "'", 'ˈ' ],
				[ ':', 'ː' ],
				[ ',', 'ˌ' ],
				// 207F
				[ 'ⁿ', 'n' ],
				// 02B0
				[ 'ʰ', 'h' ],
				// 026B
				[ 'ɫ', 'l' ],
				// 02E1
				[ 'ˡ', 'l' ],
				// 02B2
				[ 'ʲ', 'j' ],
			];
			foreach ( $charmap as $char ) {
				$this->normalizedIPA = str_replace( $char[0], $char[1], $this->normalizedIPA );
			}
			$this->removeDiacritics();
		} else {
			/** @var string[] */
			$charmap = [
				[ "'", 'ˈ' ],
				[ ':', 'ː' ],
				[ ',', 'ˌ' ],
			];
			foreach ( $charmap as $char ) {
				$this->normalizedIPA = str_replace( $char[0], $char[1], $this->normalizedIPA );
			}
		}

		return $this->normalizedIPA;
	}

	/**
	 * Strip delimiters from the IPA string
	 *
	 * @return string
	 */
	private function stripIPA() {
		$this->normalizedIPA = preg_replace( $this->stripRegex, '', $this->normalizedIPA );

		return $this->normalizedIPA;
	}

	/**
	 * Validate the IPA string
	 *
	 * @return bool
	 */
	private function validate() {
		if ( $this->strip ) {
			$this->stripIPA();
		}

		if ( $this->normalize ) {
			$this->normalizeIPA();
		}

		if ( $this->google && !$this->normalize ) {
			throw new Exception( 'Google normalization being enabled also requires normalization to also be enabled' );
		}

		return preg_match( $this->ipaRegex, $this->normalizedIPA );
	}
}
