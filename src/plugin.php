<?php

namespace FluentDOM\HTML5 {

  if (class_exists('\\FluentDOM')) {
    \FluentDOM::registerLoader(
      new \FluentDOM\Loader\Lazy(
        [
          'text/html5' => function () {
            return new Loader;
          },
          'html5' => function () {
            return new Loader;
          }
        ]
      )
    );
  }
}