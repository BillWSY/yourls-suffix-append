<?php
/*
Plugin Name: Suffix Append
Plugin URI: http://shengye.wang
Description: Append short URL suffix to long URL
Version: 1.0
Author: Shengye Wang
Author URI: http://shengye.wang
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter( 'get_request', 'shengye_org_extract_and_save_suffix' );
function shengye_org_extract_and_save_suffix( $request ) {
  $result = $request;
  $to_append = '';

  $pos = strpos($request, '/');

  if ($pos !== false) {
    $result = substr($request, 0, $pos);
    $to_append = substr($request, $pos);
  }

  $GLOBALS['YOURLS_PLUGIN_SUFFIX_APPEND'] = $to_append;
  return $result;
}

yourls_add_filter( 'get_keyword_info', 'shengye_org_append_suffix' );
function shengye_org_append_suffix( $return, $keyword, $field, $notfound ) {
  if ($field != 'url' || $return === $notfound) {
    return $return;
  } else {
    return rtrim($return, '/') . $GLOBALS['YOURLS_PLUGIN_SUFFIX_APPEND'];
  }
}
