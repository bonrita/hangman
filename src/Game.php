<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 20/03/16
 * Time: 18:50
 */

namespace Drupal\hangman;

/**
 * Class Game
 *   This class holds a few common methods of the game in question.
 *
 * @package Drupal\hangman
 */
abstract class Game implements GameInterface {

  /**
   * Default looser's message to be displayed to the player.
   */
  const DEFAULT_LOOSER_MESSAGE = 'Sorry you lost.';

  /**
   * Default winner's message to be displayed to the player.
   */
  const DEFAULT_WINNER_MESSAGE = 'Thank you, you won.';

  /**
   * Message displayed to the user when he has lost.
   *
   * @var string
   */
  protected $looserMessage;

  /**
   * Message displayed to the user when he has won.
   *
   * @var string
   */
  protected $winnerMessage;


  /**
   * The number of times a player has failed to guess.
   *
   * @var int
   */
  protected $errorCount;

  /**
   * The message of the current status.
   *
   * @var \Drupal\Core\StringTranslation\TranslatableMarkup
   */
  protected $statusMessage;

  /**
   * A boolean to notify if game is over.
   *
   * @var bool
   */
  protected $gameOver;

  /**
   * Tracks a win of the game.
   *
   * @var bool
   */
  protected $gameWin;

  /**
   * Game constructor.
   */
  public function __construct() {
    $this->looserMessage = self::DEFAULT_LOOSER_MESSAGE;
    $this->winnerMessage = self::DEFAULT_WINNER_MESSAGE;
    $this->statusMessage = '';
    $this->errorCount = 0;
    $this->gameWin = FALSE;
    $this->gameOver = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function SetGameOver() {
    $this->gameOver = TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function isGameOver() {
    if ($this->gameWin || $this->gameOver) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Get the number of failures.
   *
   * @return int
   */
  public function getErrorCount() {
    return $this->errorCount;
  }

  /**
   * Set the number of failures made by the player.
   *
   * @param int $error_count
   */
  public function setErrorCount($error_count) {
    $this->errorCount = $error_count;
    return $this;
  }

  /**
   * Get message displayed to the user when he has lost.
   *
   * @return string
   */
  public function getLooserMessage() {
    return $this->looserMessage;
  }

  /**
   * Set message displayed to the user when he has lost.
   *
   * @param string $looserMessage
   */
  public function setLooserMessage($looser_message) {
    $this->looserMessage = $looser_message;
    return $this;
  }

  /**
   * Get message displayed to the user when he has won.
   * @return string
   */
  public function getWinnerMessage() {
    return $this->winnerMessage;
  }

  /**
   * Set message displayed to the user when he has won.
   *
   * @param string $winner_message
   */
  public function setWinnerMessage($winner_message) {
    $this->winnerMessage = $winner_message;
    return $this;
  }

  /**
   * Get status of the win.
   *
   * @return boolean
   */
  public function getGameWin() {
    return $this->gameWin;
  }

  /**
   * Set status of the win.
   *
   * @param boolean $gameWin
   */
  public function setGameWin($gameWin) {
    $this->gameWin = $gameWin;
    return $this;
  }

  /**
   * Get the message to be displayed to the player.
   *
   * @return string
   */
  public function getStatusMessage() {
    return $this->statusMessage;
  }

  /**
   * The message to be displayed to the player.
   *
   * @param string $status_message
   */
  public function setStatusMessage($status_message) {
    $this->statusMessage = $status_message;
    return $this;
  }

}
