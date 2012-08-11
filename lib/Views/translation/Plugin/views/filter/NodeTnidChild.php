<?php

/**
 * @file
 * Definition of views_handler_filter_node_tnid_child.
 */

namespace Views\translation\Plugin\views\filter;

use Drupal\views\Plugin\views\filter\FilterPluginBase;
use Drupal\Core\Annotation\Plugin;

/**
 * Filter by whether the node is not the original translation.
 *
 * @ingroup views_filter_handlers
 */

/**
 * @Plugin(
 *   id = "node_tnid_child"
 * )
 */
class NodeTnidChild extends FilterPluginBase {
  function admin_summary() { }
  function operator_form(&$form, &$form_state) { }
  function can_expose() { return FALSE; }

  function query() {
    $table = $this->ensure_my_table();
    $this->query->add_where_expression($this->options['group'], "$table.tnid <> $table.nid AND $table.tnid > 0");
  }
}
