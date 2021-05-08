<?php

namespace FluentDOM\HTML5 {

  \FluentDOM::registerLoader(
    new Loader(),
    'text/html5',
    'html5',
    'text/html5-fragment',
    'html5-fragment'
  );
  \FluentDOM::registerSerializerFactory(
    function(\DOMNode $node, string $contentType) {
      return new Serializer($node, [], $contentType);
    },
    'text/html5',
    'html5',
    'text/html5-fragment',
    'html5-fragment'
  );
}
