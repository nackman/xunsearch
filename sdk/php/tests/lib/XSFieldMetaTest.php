<?php
require_once dirname(__FILE__) . '/../../lib/XS.class.php';
require_once dirname(__FILE__) . '/../../lib/XSFieldScheme.class.php';

/**
 * Test class for XSFieldMeta.
 * Generated by PHPUnit on 2011-09-15 at 17:19:35.
 */
class XSFieldMetaTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var XS
	 */
	protected $xs;

	/**
	 * @var XSFieldScheme
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->xs = new XS(end($GLOBALS['fixIniData']));
		$this->object = $this->xs->scheme;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
		$this->xs = new XS(end($GLOBALS['fixIniData']));
		$this->object = $this->xs->scheme;
	}

	public function test__toString()
	{
		$pid = $this->object->getField('pid');
		$this->assertEquals('pid', $pid . '');
	}

	public function testVal()
	{
		$pid = $this->object->getField('pid');
		$date = $this->object->getField('date');

		$this->assertEquals('pid', $pid->val('pid'));
		$this->assertEquals(date('Ymd'), $date->val(time()));
		$this->assertEquals(date('Ymd'), $date->val(date('Y-m-d')));
		$this->assertEquals(date('Ymd'), $date->val(date('Y-m-d H:i:s')));
		$this->assertEquals(date('Ymd'), $date->val('today'));
		$this->assertEquals('20110915', $date->val('2011-09-15'));
		$this->assertEquals('20110915', $date->val('2011-9-15'));
	}

	public function testWithPos()
	{
		$pid = $this->object->getField('pid');
		$subject = $this->object->getField('subject');
		$message = $this->object->getField('message');
		$this->assertFalse($pid->withPos());
		$this->assertFalse($subject->withPos());
		$this->assertTrue($message->withPos());
	}

	public function testIsBoolIndex()
	{
		$pid = $this->object->getField('pid');
		$date = $this->object->getField('date');
		$this->assertTrue($pid->isBoolIndex());
		$this->assertTrue($date->isBoolIndex());
		$this->assertFalse($this->object->getFieldTitle()->isBoolIndex());
	}

	public function testIsNumeric()
	{
		$pid = $this->object->getField('pid');
		$chrono = $this->object->getField('chrono');
		$this->assertFalse($pid->isNumeric());
		$this->assertTrue($chrono->isNumeric());
	}

	public function testIsSpeical()
	{
		$this->assertTrue($this->object->getFieldTitle()->isSpeical());
		$this->assertFalse($this->object->getField('other')->isSpeical());
	}

	public function testHasIndex()
	{
		$this->assertTrue($this->object->getFieldTitle()->hasIndex());
		$this->assertFalse($this->object->getField('chrono')->hasIndex());
	}

	public function testHasIndexMixed()
	{
		$this->assertFalse($this->object->getField('chrono')->hasIndexMixed());
		$this->assertFalse($this->object->getField('subject')->hasIndexMixed());
		$this->assertFalse($this->object->getField('message')->hasIndexMixed());
	}

	public function testHasIndexSelf()
	{
		$this->assertFalse($this->object->getField('chrono')->hasIndexSelf());
		$this->assertTrue($this->object->getField('subject')->hasIndexSelf());
		$this->assertTrue($this->object->getField('message')->hasIndexSelf());
	}

	public function testHasCustomTokenizer()
	{
		$this->assertTrue($this->object->getField('date')->hasCustomTokenizer());
		$this->assertFalse($this->object->getField('subject')->hasCustomTokenizer());
		$this->assertTrue($this->object->getField('pid')->hasCustomTokenizer());
	}

	public function testGetCustomTokenizer()
	{
		$this->assertInstanceOf('XSTokenizerSplit', $this->object->getField('date')->getCustomTokenizer());
		$this->assertInstanceOf('XSTokenizerFull', $this->object->getField('pid')->getCustomTokenizer());
	}
}
