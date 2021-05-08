<?php
namespace FluentDOM\HTML5 {

  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../../vendor/autoload.php';

  class Issue2Test extends TestCase {

    public function testLoadAndSaveFragment(): void {
      $fd = \FluentDOM::Query(
        '<b>Hello</b><i>World!</i>', 'html5-fragment'
      );
      $this->assertSame(
        '<b>Hello</b><i>World!</i>',
        (string)$fd
      );
    }
  }
}
