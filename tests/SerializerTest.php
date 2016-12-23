<?php
namespace FluentDOM\HTML5 {

  use FluentDOM\Document;
  use FluentDOM\TestCase;

  require_once(__DIR__.'/../vendor/autoload.php');

  class SerializerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers \FluentDOM\HTML5\Serializer
     */
    public function testLoadReturnsImportedDocument() {
      $xhtml = '<?xml version="1.0"?>
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <title>TEST</title>
          </head>
          <body id="foo">
            <h1>Hello World</h1>
            <p>This is a test of the HTML5 parser.</p>
          </body>
        </html>';

      $dom = new Document();
      $dom->preserveWhiteSpace = FALSE;
      $dom->loadXml($xhtml);

      $serializer = new Serializer($dom);

      $html =
        '<!DOCTYPE html>'.PHP_EOL.
        '<html>'.
          '<head>'.
            '<title>TEST</title>'.
          '</head>'.
          '<body id="foo">'.
            '<h1>Hello World</h1>'.
            '<p>This is a test of the HTML5 parser.</p>'.
          '</body>'.
        '</html>'.PHP_EOL;

      $this->assertEquals(
        $html,
        (string)$serializer
      );
    }

    public function testToStringCatchesExceptionAndReturnEmptyString() {
      $serializer = new Serializer_TestProxy(new Document());
      $this->assertEquals(
        '', (string)$serializer
      );
    }
  }

  class Serializer_TestProxy extends Serializer {

    public function asString() {
      throw new \LogicException('Catch It.');
    }
  }
}