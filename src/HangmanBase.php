<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 21/03/16
 * Time: 18:06
 */

namespace Drupal\hangman;

/**
 * Class HangmanBase
 *   Holds basic functionality.
 *
 * @package Drupal\hangman
 */
abstract class HangmanBase extends Game implements HangmanInterface {

  /**
   * The character string that is going to be used to generate the placeholder
   * string.
   */
  const PLACEHOLDER_STRING = '_';

  /**
   * The current item that the player has to guess.
   *
   * @var string
   */
  protected $currentItemToGuess;

  /**
   * The list of items the player will have to guess from.
   *
   * @var array
   */
  protected $listOfItems;

  /**
   * The generated placeholder that will be displayed on screen
   * for guessed items.
   *
   * @var string
   */
  protected $generatedPlaceholder;

  /**
   * The hangman constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->currentItemToGuess = '';
    $this->listOfItems = [];
    $this->placeholderString = self::PLACEHOLDER_STRING;
  }

  /**
   * Randomly pick an item from the list of items.
   *
   * @param array $items
   *   A list of items.
   *
   * @return string
   *   A randomly choosen item.
   */
  protected function randomlyPickItemFromList(array $items) {
    $random_item = '';

    $count = 0;
    foreach ($items as $item) {
      $count++;
      if (rand() % $count == 0) {
        $random_item = $item;
      }
    }

    return $random_item;
  }

  /**
   * Get the character placeholder string.
   *
   * @return string
   */
  public function getPlaceholderString() {
    return $this->placeholderString;
  }

  /**
   * Set the character placeholder string.
   *
   * @param string $placeholderString
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setPlaceholderString($placeholderString) {
    $this->placeholderString = $placeholderString;
    return $this;
  }

  /**
   * The generated placeholder that will be displayed on screen
   * for guessed characters.
   *
   * @return string
   */
  public function getGeneratedPlaceholder() {
    return $this->generatedPlaceholder;
  }

  /**
   * Set generated placeholder that will be displayed on screen.
   *
   * @param string $generatedPlaceholder
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setGeneratedPlaceholder($generatedPlaceholder) {
    $this->generatedPlaceholder = $generatedPlaceholder;
    return $this;
  }

  /**
   * Get the current word to be guessed by the player.
   *
   * @return string
   */
  public function getCurrentItemToGuess() {
    return $this->currentItemToGuess;
  }

  /**
   * Set the current word to guess.
   *
   * @param string $current_word_to_guess
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setCurrentItemToGuess($current_word_to_guess) {
    $this->currentItemToGuess = $current_word_to_guess;
    return $this;
  }

  /**
   * Get a list of words to be guessed.
   *
   * @return array
   *   A list of words to be guessed.
   */
  public function getListOfItems() {
    return $this->listOfItems;
  }

  /**
   * Set the list of words to be guessed.
   *
   * @param array $Items_list
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setListOfItems($Items_list) {
    $this->listOfItems = $Items_list;
    return $this;
  }

}
