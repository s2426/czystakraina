<?php

// for an unobtrusive cross-server script transfer

define('LOCALHOST', false);
define('HOST', LOCALHOST ? 'http://localhost/' : 'http://localhost/');

define('DEF_ACTION', 'content');
define('DEF_LANGUAGE', 'pl');

define('DIR_ACTIONS', 'actions/');
define('DIR_CLASSES', 'classes/');
define('DIR_DICTIONARIES', 'dictionaries/');

define('DIR_IMAGES', 'images/items/');
define('DIR_IMAGES_NEWS', 'images/news/');
define('DIR_TEMPLATES', 'templates/');

define('FILE_COUNTER_HITS', 'counter_hits.txt');
define('FILE_COUNTER_VISITS', 'counter_visits.txt');

define('REG_ADDRESS', '/^\d+[a-zA-Z]?$/');
define('REG_EMAIL', '/^([-_0-9a-z]|\.)+@([-0-9a-z]+\.)+[a-z]$/i');
define('REG_INTEGER', '/^\d+$/');
define('REG_PRICE', '/^([1-9]([0-9]*)([,.][1-9]([0-9]?))?)?$/'); // ...
define('REG_POSTCODE', '/^\d{2}-\d{3}$/');
define('REG_STRING_EN', '/^[0-9a-zA-Z]{3,}$/');
define('REG_STRING_PL', '/^[ \-\.a-zA-Z¹æê³ñóœŸ¿¥ÆÊ£ÑÓŒ¯]{2,}$/');
define('REG_TELEPHONE', '/^[0-9 ]+$/');

define('VAR_APOS', '\'');
define('VAR_DATE', date('Y-m-d'));
define('VAR_EMPTY', '');
define('VAR_KEY', 'id');
define('VAR_MAIL', 'example@example.com');
define('VAR_MAIL_NAME', 'Barter-Poland');
define('VAR_NL', "\n");
define('VAR_PLUR', 's');
define('VAR_SEPARATOR', '|');
define('VAR_SLASH', '/');
define('VAR_SPACES', '&nbsp;&nbsp;&nbsp;');
define('VAR_TEMP_CATEGORY', 2);
define('VAR_LINKS_CATEGORY', 244);
define('VAR_TOP_CATEGORY', 1);
define('VAR_UPLOAD_MAX', 524288);

?>