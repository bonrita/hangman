<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 19/03/16
 * Time: 00:07
 */

namespace Drupal\hangman\Plugin\Hangman;


use Drupal\hangman\HangmanItems;

/**
 * The words to guess provided by the Finalist team.
 *
 * @Hangman(
 *   id = "finalist",
 *   group_name = "Finalist",
 *   deriver = "Drupal\hangman\Plugin\Derivative\Finalist"
 * )
 */
class Finalist extends HangmanItems {
  /**
   * @inheritDoc
   */
  public function allowedGuesses($item = '') {
    // TODO: Implement allowedGuesses() method.
  }

}
