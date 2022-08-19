<?php
declare( strict_types=1 );
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use TheresNoTime\IPAValidator\Validator;

final class ValidatorTest extends TestCase {
	/**
	 * @covers TheresNoTime\IPAValidator\Validator::__construct
	 */
	public function testCanBeCreatedFromIPA(): void {
		$this->assertInstanceOf(
			Validator::class,
			new Validator( '/pʰə̥ˈkj̊uːliɚ/' )
		);
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator::validate
	 */
	public function testValidation(): void {
		$this->assertTrue( ( new Validator( '/pʰə̥ˈkj̊uːliɚ/', true, true, true ) )->valid );
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator::normalize
	 */
	public function testNormalization(): void {
		$this->assertEquals(
			'phəˈkjuːliɚ',
			( new Validator( '/pʰə̥ˈkj̊uːliɚ/', true, true, true ) )->normalizedIPA
		);
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator::validate
	 */
	public function testException(): void {
		$this->expectException( Exception::class );
		( new Validator( '/pʰə̥ˈkj̊uːliɚ/', false, false, true ) )->normalizedIPA;
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator::stripIPA
	 */
	public function testStripIPA(): void {
		$this->assertEquals(
			'pʰə̥ˈkj̊uːliɚ',
			( new Validator( '/pʰə̥ˈkj̊uːliɚ/', true ) )->normalizedIPA
		);
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator
	 */
	public function testOriginalIPA(): void {
		$this->assertEquals(
			'/pʰə̥ˈkj̊uːliɚ/',
			( new Validator( '/pʰə̥ˈkj̊uːliɚ/', true, true, true ) )->originalIPA
		);
	}

	/**
	 * @covers TheresNoTime\IPAValidator\Validator
	 */
	public function testCorpus(): void {
		$this->assertEquals(
			'phəˈkjuːliɚ',
			( new Validator( 'pʰə̥ˈkj̊uːliɚ', true, true, true ) )->normalizedIPA
		);

		$this->assertNotEquals(
			'pʰə̥ˈkj̊uːliɚ',
			( new Validator( 'pʰə̥ˈkj̊uːliɚ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'sotʃiˈmilko',
			( new Validator( 'sotʃiˈmilko', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'tenoːtʃˈtitɬan',
			( new Validator( 'tenoːt͡ʃˈtit͡ɬan', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'dʒəˈneɪ',
			( new Validator( 'dʒəˈneɪ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈælbəˌkɜːrki',
			( new Validator( 'ˈælbəˌkɜːrki', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈɦaɪdaraːbaːd',
			( new Validator( 'ˈɦaɪ̯daraːbaːd', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈmɪnhɑːdʒ',
			( new Validator( 'ˈmɪnhɑː(d)ʒ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'paɾanɡaɾikutiɾiˈmikwaɾo',
			( new Validator( 'paɾanɡaɾikutiɾiˈmikwaɾo', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'mexiko',
			( new Validator( 'mexiko', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ɑ.ti.kɔs.ti.ty.sjɔ.nɛl.mɑ',
			( new Validator( 'ɑ̃.ti.kɔ̃s.ti.ty.sjɔ.nɛl.mɑ̃', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈsmɶɐˌpʁœðˀ',
			( new Validator( 'ˈsmɶɐ̯ˌpʁœðˀ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈsʌtəl',
			( new Validator( 'ˈsʌt(ə)l', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈdʒuːəlɹi',
			( new Validator( 'ˈdʒuːəlɹi', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈhæmbɝɡɚ',
			( new Validator( 'ˈhæmbɝɡɚ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ɪbɪˈbiːəʊ',
			( new Validator( 'ɪbɪˈbiːəʊ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈɔːfl',
			( new Validator( 'ˈɔːfɫ̩', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'flaɪ',
			( new Validator( 'flaɪ̯', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈkætnnɪp',
			( new Validator( 'ˈkætⁿnɪp', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈæpt',
			( new Validator( 'ˈæp̚t', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈspɒtllɨs',
			( new Validator( 'ˈspɒtˡlɨs', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'kənˈfjuːʒən',
			( new Validator( 'kənˈfjuːʒən', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'θɪŋ',
			( new Validator( 'θɪŋ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈwɪən',
			( new Validator( 'ˈwɪən', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'nə.məs.teː',
			( new Validator( 'nə.məs.t̪eː', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'nanri',
			( new Validator( 'n̪anri', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈʃɪbəlɛθ',
			( new Validator( 'ˈʃɪbəlɛθ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ef.xa.ɾiˈsto',
			( new Validator( 'ef.xa.ɾiˈsto', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈsʊʃi',
			( new Validator( 'ˈsʊʃi', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'spɐˈsjibə',
			( new Validator( 'spɐˈsʲibə', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'suːpəˌkælɨˌfɹædʒɨˌlɪstɪkˌɛkspɪˌælɨˈdəʊʃəs',
			( new Validator( 'suːpəˌkælɨˌfɹædʒɨˌlɪstɪkˌɛkspɪˌælɨˈdəʊʃəs', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈkɔːrnwɔːl',
			( new Validator( 'ˈkɔːrnwɔːl', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'tɛmz',
			( new Validator( 'tɛmz', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ɡʌnˈwɒləʊ',
			( new Validator( 'ɡʌnˈwɒləʊ', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˌpɔːrθˈlɛvən',
			( new Validator( 'ˌpɔːrθˈlɛvən', true, true, true ) )->normalizedIPA
		);

		$this->assertEquals(
			'ˈsʌmərsɛt',
			( new Validator( 'ˈsʌmərsɛt', true, true, true ) )->normalizedIPA
		);
	}
}
