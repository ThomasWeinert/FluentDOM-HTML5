<?php
namespace FluentDOM\HTML5 {

  use PHPUnit\Framework\TestCase;

  require_once __DIR__.'/../../vendor/autoload.php';

  class Issue3Test extends TestCase {

    public function testLoadFragmentRegisteringNamespace() {
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

    public function testLoadFragmentDisableNamespace() {
      $html5 = '<div id="a"><span id="b"></span></div>';

      $this->assertTrue(
        \FluentDOM::Query(
          $html5,
          'html5',
          [
            Loader::IS_FRAGMENT => TRUE,
            Loader::DISABLE_HTML_NAMESPACE => TRUE
          ]
        )->is('self::div')
      );
    }

    /**
     * @param $selector
     * @testWith
     *  ["html|div"]
     *  ["*|div"]
     */
    public function testLoadFragmentAndValidateUsingCSSSelector($selector) {
      $html5 = '<div id="a"><span id="b"></span></div>';

      $this->assertTrue(
        \FluentDOM::QueryCss(
          $html5,
          'html5',
          [
            Loader::IS_FRAGMENT => TRUE
          ]
        )->is($selector)
      );
    }
  }
}