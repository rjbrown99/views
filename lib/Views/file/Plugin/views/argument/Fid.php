<?php

/**
 * @file
 * Definition of views_handler_argument_file_fid.
 */

namespace Views\file\Plugin\views\argument;

use Drupal\Core\Annotation\Plugin;
use Drupal\views\Plugin\views\argument\Numeric;

/**
 * Argument handler to accept multiple file ids.
 *
 * @ingroup views_argument_handlers
 */

/**
 * @Plugin(
 *   id = "file_fid"
 * )
 */
class Fid extends Numeric {
  /**
   * Override the behavior of title_query(). Get the filenames.
   */
  function title_query() {
    $titles = db_select('file_managed', 'f')
      ->fields('f', array('filename'))
      ->condition('fid', $this->value)
      ->execute()
      ->fetchCol();
    foreach ($titles as &$title) {
      $title = check_plain($title);
    }
    return $titles;
  }
}
