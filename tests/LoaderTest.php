<?php /** @noinspection HttpUrlsUsage */

namespace FluentDOM\HTML5 {

  use FluentDOM\Exceptions\InvalidSource;
  use FluentDOM\Exceptions\UnattachedNode;
  use FluentDOM\Loader\Result;
  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../vendor/autoload.php';

  /**
   * @covers \FluentDOM\HTML5\Loader
   */
  class LoaderTest extends TestCase {

    public function testSupportsExpectingFalse(): void {
      $loader = new Loader();
      $this->assertTrue($loader->supports('text/html5'));
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadReturnsImportedDocument(): void {
      $html = '<html lang="en">
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
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <title>TEST</title>
          </head>
          <body id="foo">
            <h1>Hello World</h1>
            <p>This is a test of the HTML5 parser.</p>
          </body>
        </html>',
        $loader->load($html, 'text/html5')->getDocument()->saveXML()
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadReturnsImportedDocumentWithoutNamespaces(): void {
      $html = '<html lang="en">
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
        <html lang="en">
          <head>
            <title>TEST</title>
          </head>
          <body id="foo">
            <h1>Hello World</h1>
            <p>This is a test of the HTML5 parser.</p>
          </body>
        </html>',
        $loader->load($html, 'text/html5', [Loader::DISABLE_HTML_NAMESPACE => TRUE])->getDocument()->saveXML()
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadReturnsNullFormInvalidSource(): void {
      $loader = new Loader();
      $this->assertNull(
        $loader->load(NULL, 'type/invalid')
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithValidHtmlFragment(): void {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<div>Test</div>Text<input>',
          'text/html5-fragment'
        )
      );
      /** @noinspection CheckTagEmptyBody */
      /** @noinspection HtmlExtraClosingTag */
      $this->assertEquals(
        '<div xmlns="http://www.w3.org/1999/xhtml">Test</div>Text<input xmlns="http://www.w3.org/1999/xhtml"></input>',
        $result->getDocument()->saveHTML()
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithValidHtmlFragmentDefinedByOption(): void {
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
      /** @noinspection CheckTagEmptyBody */
      /** @noinspection HtmlExtraClosingTag */
      $this->assertEquals(
        '<div xmlns="http://www.w3.org/1999/xhtml">Test</div>Text<input xmlns="http://www.w3.org/1999/xhtml"></input>',
        $result->getDocument()->saveHTML()
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithXMLNamespacesSupportEnabled(): void {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<t:tag xmlns:t="http://www.example.com"/>',
          'text/html5',
          [
            Loader::ENABLE_XML_NAMESPACES => TRUE,
            Loader::IS_FRAGMENT => TRUE
          ]
        )
      );
      $this->assertEquals(
        'http://www.example.com',
        $result->getDocument()->documentElement->namespaceURI
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithXMLNamespacesSupportDisabled(): void {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<t:tag xmlns:t="http://www.example.com"/>',
          'text/html5',
          [
            Loader::ENABLE_XML_NAMESPACES => FALSE,
            Loader::IS_FRAGMENT => TRUE
          ]
        )
      );
      $this->assertNull(
        $result->getDocument()->documentElement->namespaceURI
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithImplicitNamespaces(): void {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<t:tag/>',
          'text/html5',
          [
            Loader::IMPLICIT_NAMESPACES => [
              't' => 'http://www.example.com'
            ],
            Loader::IS_FRAGMENT => TRUE
          ]
        )
      );
      $this->assertEquals(
        'http://www.example.com',
        $result->getDocument()->documentElement->namespaceURI
      );
    }

    /**
     * @throws InvalidSource
     * @throws UnattachedNode
     */
    public function testLoadWithoutImplicitNamespaces(): void {
      $loader = new Loader();
      $this->assertInstanceOf(
        Result::class,
        $result = $loader->load(
          '<t:tag/>',
          'text/html5',
          [
            Loader::IMPLICIT_NAMESPACES => [],
            Loader::IS_FRAGMENT => TRUE
          ]
        )
      );
      $this->assertNull(
        $result->getDocument()->documentElement->namespaceURI
      );
    }
  }
}
