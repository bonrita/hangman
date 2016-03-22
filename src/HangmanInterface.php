<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 21/03/16
 * Time: 19:35
 */

namespace Drupal\hangman;

/**
 * Interface HangmanInterface
 *
 * Functionality that needs to be present for a hangman game.
 *
 * @package Drupal\hangman
 */
interface HangmanInterface {

  /**
   * Validate guesed character.
   *
   * @param string $character
   *   The character that needs to be validated.
   *
   * @return bool
   */
  public function validateGuessedCharacter($character);


  /**
   * Generate a string to be used as a placeholder for a character.
   *
   * @param string $word
   *   The string whose pattern style i am generating.
   *
   * @return string
   *   The generated pattern.
   */
  public function generateItemPlaceholder($word);

}
