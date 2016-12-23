<?php
/**
 * Load a DOM document from a HTML5 string or file
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2014 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\HTML5 {

  use FluentDOM\Document;
  use FluentDOM\Loadable;
  use FluentDOM\Loader\Options;
  use FluentDOM\Loader\Supports;

  use Masterminds\HTML5 as HTML5Support;

  /**
   * Load a DOM document from a HTML5 string or file
   */
  class Loader implements Loadable {

    use Supports;

    /**
     * @return string[]
     */
    public function getSupported() {
      return ['html5', 'text/html5'];
    }

    /**
     * Load a HTML5 file and copy it into a FluentDOM\Document
     *
     * @codeCoverageIgnore
     *
     * @see Loadable::load
     * @param string $source
     * @param string $contentType
     * @param array|\Traversable|Options $options
     * @return Document|NULL
     */
    public function load($source, $contentType, $options = []) {
      if ($this->supports($contentType)) {
        $html5 = new HTML5Support();
        $settings = $this->getOptions($options);
        $settings->isAllowed($sourceType = $settings->getSourceType($source));
        switch ($sourceType) {
        case Options::IS_FILE :
          $document = $html5->loadHTMLFile($source);
          break;
        case Options::IS_STRING :
        default :
          $document = $html5->loadHTML($source);
        }
        if (!$document instanceof Document) {
          $import = new Document();
          if ($document->documentElement instanceof \DOMElement) {
            $import->appendChild($import->importNode($document->documentElement, TRUE));
          }
          $document = $import;
        }
        $document->registerNamespace(
          'html', 'http://www.w3.org/1999/xhtml'
        );
        return $document;
      }
      return NULL;
    }

    private function getOptions($options) {
      $result = new Options(
        $options,
        [
          Options::CB_IDENTIFY_STRING_SOURCE => function($source) {
            return $this->startsWith($source, '<');
          }
        ]
      );
      return $result;
    }

    public function loadFragment($source, $contentType, $options = []) {
      if ($this->supports($contentType)) {
        $html5 = new HTML5Support();
        return $html5->loadHTMLFragment($source);
      }
      return NULL;
    }
  }
}