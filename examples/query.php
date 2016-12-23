<?php

require '../vendor/autoload.php';

$html = <<< 'HERE'
  <html>
  <head>
    <title>TEST</title>
  </head>
  <body id='foo'>
    <h1>Hello World</h1>
    <p>This is a test of the HTML5 parser.</p>
  </body>
  </html>
HERE;

$fd = FluentDOM::QueryCss($html, 'text/html5');
$fd->find('html|p')->after('<p>test<br>test</p>');
echo $fd;