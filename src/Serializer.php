<?php
/**
 * Serialize an (XHTML) DOM into a HTML5 string.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\HTML5 {

  use Masterminds\HTML5 as HTML5Support;

  /**
   * Serialize an (XHTML) DOM into a HTML5 string.
   *
   * @license http://www.opensource.org/licenses/mit-license.php The MIT License
   * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
   */
  class Serializer {

    /**
     * @var \DOMDocument
     */
    private $_document = NULL;

    /**
     * @var array
     */
    private $_options = [];

    public function __construct(\DOMDocument $document, array $options = []) {
      $this->_document = $document;
      $this->_options = $options;
    }

    public function __toString() {
      try {
        return $this->asString();
      } catch (\Exception $e) {
        return '';
      }
    }

    public function asString() {
      $html5 = new HTML5Support($this->_options);
      return (string)$html5->saveHTML($this->_document);
    }
  }
}
