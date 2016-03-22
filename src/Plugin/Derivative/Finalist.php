<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 19/03/16
 * Time: 00:23
 */

namespace Drupal\hangman\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Symfony\Component\Yaml\Yaml;

/**
 * Finalist hangman words are provided by more than one member
 * of the Finalist team.
 */
class Finalist extends DeriverBase {

  /**
   * @inheritDoc
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $hangman_file = drupal_get_path('module', 'hangman') . '/finalist_team.yml';

    // If a file is empty or its contents are commented out, return an empty
    // array instead of NULL for type consistency.
    $words = Yaml::parse(file_get_contents($hangman_file))?: [];

    foreach ($words as $key => $definition) {
      $this->derivatives[$key] = $base_plugin_definition;
      $this->derivatives[$key] += array(
        'label'       => $definition['label'],
        'image'       => $definition['image'],
        'words' => $definition['words'],
      );
    }

    return $this->derivatives;
  }

}
