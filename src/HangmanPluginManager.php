<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 22:38
 */

namespace Drupal\hangman;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Class HangmanPluginManager
 *   A Plugin to manage hangman word lists.
 *
 * @package Drupal\hangman
 */
class HangmanPluginManager extends DefaultPluginManager {

  /**
   * @inheritDoc
   */
  public function __construct(\Traversable $namespaces, ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    // The plugin's subdirectory.
    $subdir = 'Plugin/Hangman';

    // The name of the annotation class that contains the plugin definition.
    $plugin_definition_annotation_name = 'Drupal\hangman\Annotation\Hangman';

    // The interface each hangman plugin should implement.
    $plugin_interface = 'Drupal\hangman\HangmanItemsInterface';

    parent::__construct($subdir, $namespaces, $module_handler, $plugin_interface, $plugin_definition_annotation_name);

    $this->alterInfo('hangman_info');

    $this->setCacheBackend($cache_backend, 'hangman_varieties');
  }

}
