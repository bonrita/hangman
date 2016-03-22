<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 22:06
 */

namespace Drupal\hangman;

use Drupal\Component\Plugin\PluginBase;

/**
 * Class HangmanItems
 *
 * @package Drupal\hangman
 */
abstract class HangmanItems extends PluginBase implements HangmanItemsInterface {

  /**
   * @inheritDoc
   */
  public function getName() {
    return $this->pluginDefinition['label'];
  }

  /**
   * @inheritDoc
   */
  public function getImage() {
    return $this->pluginDefinition['image']?:'';
  }

  /**
   * @inheritDoc
   */
  public function getGroupName() {

    if (empty($this->pluginDefinition['group_name'])) {
      $group = $this->pluginDefinition['label'];
    }
    else {
      $group = $this->pluginDefinition['group_name'];
    }

    return $group;
  }

  /**
   * @inheritDoc
   */
  public function getListOfItems() {
    return $this->getPluginDefinition()['words'];
  }
}
