<?php
namespace FluentDOM\HTML5 {

  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../../vendor/autoload.php';

  class Issue3Test extends TestCase {

    public function testLoadAndSaveFragment() {
      $html5 = '<div id="a"><span id="b"></span></div>';

      $this->assertTrue(
        \FluentDOM::Query(
          $html5,
          'html5',
          [
            Loader::IS_FRAGMENT => TRUE
          ]
        )->is('self::html:div')
      );
    }
  }
}