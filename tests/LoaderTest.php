<?php
namespace FluentDOM\HTML5 {

  use FluentDOM\Loader\Result;
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
    public function testLoadReturnsImportedDocumentWithoutNamespaces() {
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
        <html>
          <head>
            <title>TEST</title>
          </head>
          <body id="foo">
            <h1>Hello World</h1>
            <p>This is a test of the HTML5 parser.</p>
          </body>
        </html>',
        $loader->load($html, 'text/html5', [Loader::DISABLE_HTML_NAMESPACE => TRUE])->saveXML()
      );
    }

    /**
     * @covers \FluentDOM\HTML5\Loader
     */
    public function testLoadReturnsNullFormInvalidSource() {
      $loader = new Loader();
      $this->assertNull(
        $loader->load(NULL, 'type/invalid')
      );
    }

    /**
     * @covers \FluentDOM\Loader\Html
     * @covers \FluentDOM\Loader\Supports
     */
    public function testLoadWithValidHtmlFragment() {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<div>Test</div>Text<input>',
          'text/html5-fragment'
        )
      );
      $this->assertEquals(
        '<div xmlns="http://www.w3.org/1999/xhtml">Test</div>Text<input xmlns="http://www.w3.org/1999/xhtml"></input>',
        $result->getDocument()->saveHTML()
      );
    }

    /**
     * @covers \FluentDOM\Loader\Html
     * @covers \FluentDOM\Loader\Supports
     */
    public function testLoadWithValidHtmlFragmentDefinedByOption() {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<div>Test</div>Text<input>',
          'text/html5',
          [
            Loader::IS_FRAGMENT => TRUE
          ]
        )
      );
      $this->assertEquals(
        '<div xmlns="http://www.w3.org/1999/xhtml">Test</div>Text<input xmlns="http://www.w3.org/1999/xhtml"></input>',
        $result->getDocument()->saveHTML()
      );
    }
  }
}