<?php
/**
 * Load a DOM document from a HTML5 string or file
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright Copyright (c) 2009-2018 Bastian Feder, Thomas Weinert
 */

namespace FluentDOM\HTML5 {

  use FluentDOM\DOM\Document;
  use FluentDOM\Loadable;
  use FluentDOM\Loader\Options;
  use FluentDOM\Loader\Result;
  use FluentDOM\Loader\Supports;

  use Masterminds\HTML5 as HTML5Support;

  /**
   * Load a DOM document from a HTML5 string or file
   */
  class Loader implements Loadable {

    use Supports;

    const IS_FRAGMENT = 'is_fragment';
    const DISABLE_HTML_NAMESPACE = 'disable_html_ns';
    const ENABLE_XML_NAMESPACES = 'xml_namespaces';
    const IMPLICIT_NAMESPACES = 'implicit_namespaces';

    /**
     * @return string[]
     */
    public function getSupported(): array {
      return ['html5', 'text/html5', 'html5-fragment', 'text/html5-fragment'];
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
     * @return Document|Result|NULL
     */
    public function load($source, string $contentType, $options = []) {
      if ($this->supports($contentType)) {
        $html5 = new HTML5Support(
          [
            'xmlNamespaces' => isset($options[self::ENABLE_XML_NAMESPACES])
              ? (bool)$options[self::ENABLE_XML_NAMESPACES] : FALSE
          ]
        );
        $settings = $this->getOptions($options);
        if ($this->isFragment($contentType, $settings)) {
          $document = new Document();
          $document->append(
            $html5->loadHTMLFragment($source, $this->getLibraryOptions($settings))
          );
          $document->registerNamespace('html', 'http://www.w3.org/1999/xhtml');
          return new Result($document, 'text/html5-fragment', $document->evaluate('/node()'));
        }
        $settings->isAllowed($sourceType = $settings->getSourceType($source));
        switch ($sourceType) {
          case Options::IS_FILE :
            $document = $html5->loadHTMLFile($source, $this->getLibraryOptions($settings));
          break;
          case Options::IS_STRING :
          default :
            $document = $html5->loadHTML($source, $this->getLibraryOptions($settings));
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

    private function isFragment(string $contentType, $options): bool {
      return (
        $contentType === 'html5-fragment' ||
        $contentType === 'text/html5-fragment' ||
        $options[self::IS_FRAGMENT]
      );
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

    public function loadFragment($source, string $contentType, $options = []) {
      if ($this->supports($contentType)) {
        $html5 = new HTML5Support();
        return $html5->loadHTMLFragment($source, $this->getLibraryOptions($this->getOptions($options)));
      }
      return NULL;
    }

    private function getLibraryOptions($settings) {
      $libraryOptions = [
        'disable_html_ns' => (bool)$settings[self::DISABLE_HTML_NAMESPACE]
      ];
      if (\is_array($settings[self::IMPLICIT_NAMESPACES ])) {
        $libraryOptions['implicitNamespaces'] =  $settings[self::IMPLICIT_NAMESPACES];
      }
      return $libraryOptions;
    }
  }
}
