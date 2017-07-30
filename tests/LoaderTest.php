<?php
namespace FluentDOM\HTML5 {

  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../vendor/autoload.php';

  class LoaderTest extends TestCase {

    /**
     * @covers \FluentDOM\HTML5\Loader
     */
    public function testSupportsExpectingFalse() {
      $loader = new Loader();
      $this->assertTrue($loader->supports('text/html5'));
    }

    /**
     * @covers \FluentDOM\HTML5\Loader
     */
    public function testLoadReturnsImportedDocument() {
      $html = '<html>
        <head>
          <title>TEST</title>
        </head>
        <body id="foo">
          <h1>Hello World</h1>
          <p>This is a test of the HTML5 parser.</p>
        </body>
        </html>';

      $loader = new Loader();
      $this->assertXmlStringEqualsXmlString(
        '<?xml version="1.0"?>
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <title>TEST</title>
          </head>
          <body id="foo">
            <h1>Hello World</h1>
            <p>This is a test of the HTML5 parser.</p>
          </body>
        </html>',
        $loader->load($html, 'text/html5')->saveXML()
      );
    }

    /**
     * @covers \FluentDOM\HTML5\Loader
     */
    public function testLoadReturnsNullFormInvlaidSource() {
      $loader = new Loader();
      $this->assertNull(
        $loader->load(NULL, 'type/invalid')
      );
    }
  }
}