# Composer package for validating and normalizing IPA
[![PHP](https://github.com/theresnotime/php-ipa-validator/actions/workflows/PHP.yml/badge.svg)](https://github.com/theresnotime/php-ipa-validator/actions/workflows/PHP.yml)


## Installing
Go grab it on [packagist](https://packagist.org/packages/theresnotime/ipa-validator) via
```
composer require theresnotime/ipa-validator
```
## Basic usage
```php
// Load composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load the validator
use TheresNoTime\IPAValidator\Validator;

/*
* Create a new validator with the options:
*  - Remove delimiters (defaults to true)
*  - Normalize IPA (defaults to false)
*  - Normalize to Google TTS standard (defaults to false)
*/
$validator = new Validator( '/pʰə̥ˈkj̊uːliɚ/', true, true, true );

// Check if the IPA is valid
echo $validator->valid;  # true

// Get the normalized IPA
echo $validator->normalizedIPA;  # phəˈkjuːliɚ

// Get the original IPA
echo $validator->originalIPA;  # /pʰə̥ˈkj̊uːliɚ/
```

## Options
When constructing a new `Validator`, you can set the following options:
```php
/**
 * Constructor
 *
 * @param string $ipa IPA to validate
 * @param bool $strip Remove delimiters
 * @param bool $normalize Normalize IPA
 * @param bool $google Normalize IPA for Google TTS
 */
public function __construct( $ipa, $strip = true, $normalize = false, $google = false )
```

### Remove delimiters
This option will remove *some* delimiters from the IPA — currently `/.../` and `[...]`


### Normalize IPA
When `$google` is `false`, this option will normalize the IPA and remove commonly mistaken unicode characters (for example, using `:` instead of `ː` in a word such as `tenoːt͡ʃˈtit͡ɬan`).

### Normalize IPA for Google TTS
As part of a work project, we're feeding IPA to Google's TTS engine — Google is a little opinionated about things like diacritics.
For example, the IPA `ˈɔːfɫ̩` would not render correctly in Google TTS. A custom charmap is used to normalize certain characters:
```php
$charmap = [
    [ '(', '' ],
    [ ')', '' ],
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
```
Setting `$google` to `true` also removes all diacritics from the IPA string.

## Developing
 1. [Fork n' clone](https://docs.github.com/en/get-started/quickstart/contributing-to-projects) this repo
 2. Run `composer install`
 3. Run `composer test` because who knows, maybe its already broken
 4. Hack!

## The Regex
```
^[().a-z|æçðøħŋœǀ-ǃɐ-ɻɽɾʀ-ʄʈ-ʒʔʕʘʙʛ-ʝʟʡʢʰʲʷʼˀˈˌːˑ˞ˠˡˤ-˩̴̘̙̜̝̞̟̠̤̥̩̪̬̯̰̹̺̻̼̀́̂̃̄̆̈̊̋̌̏̽̚͜͡βθχ᷄᷅᷈‖‿ⁿⱱ]+$
```

I've also placed it at https://regex101.com/r/f2Qhuk if you think you can improve it... (**please do**!)