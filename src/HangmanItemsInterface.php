<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 22:08
 */

namespace Drupal\hangman;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Interface HangmanItemsInterface
 *   An interface for all Hangman type of plugins
 *
 * @package Drupal\hangman
 */
interface HangmanItemsInterface extends PluginInspectionInterface{

  /**
   * Return the name of the company or user that provided the hangman words.
   *
   * @return string
   */
  public function getName();

  /**
   * Shows a photo (or logo) of the user (or company) who provided the words.
   *
   * @return string
   */
  public function getImage();

  /**
   * The maximum number of times a player is allowed to fail guessing the correct
   * letter before it is considered game over.
   *
   * @param string $item
   *   The word to guess.
   *
   * @return integer
   *   The number of items a word could be guessed.
   */
  public function allowedGuesses($item = '');

  /**
   * The group name that provided the hangman words.
   *
   * @return string
   */
  public function getGroupName();

  /**
   * Get a list of items that will need to be guessed.
   *
   * @return array()
   */
  public function getListOfItems();

}
