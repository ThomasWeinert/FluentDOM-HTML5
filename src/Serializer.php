<?php
/**
 * Serialize an (XHTML) DOM into a HTML5 string.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2018 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\HTML5 {

  use Masterminds\HTML5 as HTML5Support;

  /**
   * Serialize an (XHTML) DOM into a HTML5 string.
   */
  class Serializer {

    const ENCODE_ENTITIES = 'encode_entities';

    /**
     * @var \DOMNode
     */
    private $_node;

    /**
     * @var array
     */
    private $_options;

    public function __construct(\DOMNode $node, array $options = []) {
      $this->_node = $node;
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
      return (string)$html5->saveHTML($this->_node);
    }
  }
}
