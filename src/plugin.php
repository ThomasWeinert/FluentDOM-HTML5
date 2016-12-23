<?php

namespace FluentDOM\HTML5 {

  \FluentDOM::registerLoader(
    new Loader(),
    'text/html5',
    'html5'
  );
  \FluentDOM::registerSerializerFactory(
    function($contentType, \DOMNode $node) {
      return new Serializer($node);
    },
    'text/html5',
    'html5'
  );
}