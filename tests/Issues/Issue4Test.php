<?php
namespace FluentDOM\HTML5 {

  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../../vendor/autoload.php';

  class Issue4Test extends TestCase {

    public function testLoadRegisteringXMLNamespace() {
      $html5 = '<t:tag xmlns:t="http://www.example.com"/>';

      $node = \FluentDOM::Query(
        $html5,
        'html5',
        [
          Loader::ENABLE_XML_NAMESPACES => TRUE
        ]
      )->find('//*[local-name() = "tag"]')->get(0);

      $this->assertEquals(
        'http://www.example.com',
        $node->namespaceURI
      );
    }
  }
}
