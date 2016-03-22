<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 21/03/16
 * Time: 19:30
 */

namespace Drupal\hangman;

/**
 * Interface GameInterface
 *
 * Must have functionality for the games.
 *
 * @package Drupal\hangman
 */
interface GameInterface {

  /**
   * Initialize the game to play.
   */
  public function initializeGame();

  /**
   * Process the player's results.
   */
  public function processGameResults();

  /**
   * Verify the the game has ended.
   */
  public function SetGameOver();

  /**
   * Indiciate whether the game is over or not.
   *
   * @return bool
   */
  public function isGameOver();

}
