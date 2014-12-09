<?php
namespace FluentDOM\HTML5 {

  use FluentDOM\TestCase;

  require_once(__DIR__.'/../vendor/autoload.php');

  class LoaderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers FluentDOM\Loader\Html
     * @covers FluentDOM\Loader\Supports
     */
    public function testSupportsExpectingFalse() {
      $loader = new Loader();
      $this->assertTrue($loader->supports('text/html5'));
    }
  }
}