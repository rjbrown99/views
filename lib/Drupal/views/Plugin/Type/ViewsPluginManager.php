<?php

/**
 * @file
 * Definition of Drupal\views\Plugin\Type\ViewsPluginManager.
 */

namespace Drupal\views\Plugin\Type;

use Drupal\Component\Plugin\PluginManagerBase;
use Drupal\Component\Plugin\Factory\DefaultFactory;
use Drupal\Core\Plugin\Discovery\AnnotatedClassDiscovery;
use Drupal\Core\Plugin\Discovery\CacheDecorator;

class ViewsPluginManager extends PluginManagerBase {

  /**
   * A list of Drupal core modules.
   *
   * @var array
   */
  protected $coreModules = array();

  public function __construct($type) {
    // @todo Remove this hack in http://drupal.org/node/1708404.
    views_init();

    $this->discovery = new CacheDecorator(new AnnotatedClassDiscovery('views', $type), 'views:' . $type, 'views');
    $this->factory = new DefaultFactory($this);
    $this->coreModules = views_core_modules();
    $this->defaults += array(
      'parent' => 'parent',
      'plugin_type' => $type,
    );
  }

  /**
   * Overrides Drupal\Component\Plugin\PluginManagerBase::processDefinition().
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);

    $module = isset($definition['module']) ? $definition['module'] : 'views';
    // If this module is a core module, use views as the module directory.
    $module_dir = in_array($module, $this->coreModules) ? 'views' : $module;
    $theme_path = drupal_get_path('module', $module_dir);

    // Setup automatic path/file finding for theme registration.
    if ($module_dir == 'views') {
      $theme_path .= '/theme';
      $theme_file = 'theme.inc';
    }
    else {
      $theme_file = "$module.views.inc";
    }

    $definition += array(
      'module' => $module_dir,
      'theme path' => $theme_path,
      'theme file' => $theme_file,
    );
  }

}
