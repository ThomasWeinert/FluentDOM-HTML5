<?php
/**
 * Serialize an (XHTML) DOM into a HTML5 string.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2018 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\HTML5 {

  use DOMNode;
  use Exception;
  use Masterminds\HTML5 as HTML5Support;

  /**
   * Serialize an (XHTML) DOM into a HTML5 string.
   */
  class Serializer {

    public const ENCODE_ENTITIES = 'encode_entities';

    /**
     * @var DOMNode
     */
    private $_node;

    /**
     * @var array
     */
    private $_options;

    /**
     * @var bool
     */
    private $_isFragment;

    public function __construct(DOMNode $node, array $options = [], $contentType = 'text/html5') {
      $this->_node = $node;
      $this->_options = $options;
      $this->_isFragment = $contentType === 'text/html5-fragment' ||  $contentType === 'html5-fragment';
    }

    public function __toString() {
      try {
        return $this->asString();
      } catch (Exception $e) {
        return '';
      }
    }

    public function asString(): string {
      $node = $this->_node;
      if ($this->_isFragment && $node instanceof \DOMDocument) {
        $fragment = $node->createDocumentFragment();
        foreach ($node->childNodes as $childNode) {
          if (
            $childNode instanceof \DOMElement ||
            $childNode instanceof \DOMCharacterData ||
            $childNode instanceof \DOMEntityReference
          ) {
            $fragment->appendChild($childNode->cloneNode(TRUE));
          }
        }
        $node = $fragment;
      }
      $html5 = new HTML5Support($this->_options);
      return (string)$html5->saveHTML($node);
    }
  }
}
