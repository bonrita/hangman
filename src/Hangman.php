<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 20/03/16
 * Time: 18:54
 */

namespace Drupal\hangman;

/**
 * Class Hangman
 *
 * The hangman game engine.
 *
 * @package Drupal\hangman
 */
class Hangman extends HangmanBase {

  /**
   * The regex to validate if strings are alphanumericals.
   */
  const REGEX_VALIDATOR_PATTERN = "/^[a-zA-Z\d]+$/";

  /**
   * The list of characters to guess.
   *
   * @var array.
   */
  protected $wordToGuessArray;

  /**
   * Set TRUE/FALSE if the right character was guessed.
   *
   * @var bool
   */
  protected $isCharacterGuessed;

  /**
   * The current guessed character.
   *
   * @var string
   */
  protected $currentGuessedXracter;

  /**
   * The character string that is going to be used to generate the placeholder
   * string.
   *
   * @var string
   */
  protected $placeholderString;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    parent::__construct();
    $this->generatedPlaceholder = '';
    $this->wordToGuessArray = [];
    $this->isCharacterGuessed = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function initializeGame() {

    // Randomly pick a word.
    $word_to_guess = $this->randomlyPickItemFromList($this->listOfItems);
    $this->setCurrentItemToGuess($word_to_guess);

    //Convert the word to be guessed to an array.
    $word_array = $this->convertStringToArray($word_to_guess);
    $this->setWordToGuessArray($word_array);

    return $this;
  }

  /**
   * Convert the word to be guessed to an array.
   *
   * @param \Drupal\hangman\string $word_to_guess
   *
   * @return array
   *   A list of characters in the word.
   */
  protected function convertStringToArray(string $word_to_guess) {
    return str_split($word_to_guess, 1);
  }

  /**
   * Get the characters in the word that is being guessed.
   *
   * @return array
   */
  public function getWordToGuessArray() {
    return $this->wordToGuessArray;
  }

  /**
   * Sets the current word array.
   *
   * @param array $word_array
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setWordToGuessArray($word_array) {
    $this->wordToGuessArray = $word_array;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function generateItemPlaceholder($word) {
    $style = $this->getPlaceholderString();
    $word_count = strlen($word);
    $placeholder = str_repeat($style, $word_count);
    return $placeholder;
  }

  /**
   * {@inheritdoc}
   */
  public function validateGuessedCharacter($character) {
    if (preg_match(self::REGEX_VALIDATOR_PATTERN, $character)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function processGameResults() {
    // By default i assume the character is not guessed.
    $this->isCharacterGuessed = FALSE;
    $word_to_guess = $this->getCurrentItemToGuess();
    $word_count = strlen($word_to_guess);
    $placeholder_string = "";

    // Create a list of placeholder charater list.
    $placeholder_string_list = $this->generateCharacterPlaceholderArray();

    // Update the placeholder_string
    for ($r = 0; $r < $word_count; $r++) {
      $placeholder_string = "" . $placeholder_string . "" . $placeholder_string_list[$r] . "";
    }

    // Generate placeholder.
    $this->setGeneratedPlaceholder($placeholder_string);

    // Generate or set a thank you message for the winning player.
    $this->processWinningResults();

    //Notify the player if he lost.
    $this->processTheLossersMessage();
  }

  /**
   * Generate character list array.
   *   - Check wether the character occurs in the word.
   *   - Notifying the application that there is a match.
   *
   * @return array
   *   A list of placeholder characters.
   */
  protected function generateCharacterPlaceholderArray() {
    $placeholder_string_list = [];
    $word_to_guess = $this->getCurrentItemToGuess();
    $placeholder_string = $this->getGeneratedPlaceholder();
    $word_to_guess_list = $this->convertStringToArray($word_to_guess);
    $word_count = count($word_to_guess_list);

    for ($i = 0; $i < $word_count; $i++) {
      $placeholder_string_list[$i] = substr($placeholder_string, $i, 1);
    }

    for ($k = 0; $k < $word_count; $k++) {
      if ($word_to_guess_list[$k] == $this->getCurrentGuessedXracter()) {
        $this->isCharacterGuessed = TRUE;
        $placeholder_string_list[$k] = $word_to_guess_list[$k];
      }
    }

    return $placeholder_string_list;
  }

  /**
   * The current character guessed by the player.
   *
   * @return string
   *   The guessed character.
   */
  public function getCurrentGuessedXracter() {
    return $this->currentGuessedXracter;
  }

  /**
   * Set the current character guessed by the player.
   *
   * @param string $currentGuessedXracter
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  public function setCurrentGuessedXracter($currentGuessedXracter) {
    $this->currentGuessedXracter = $currentGuessedXracter;
    return $this;
  }

  /**
   * Generate or set a thank you message for the winning player.
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  protected function processWinningResults() {
    if ($this->getGeneratedPlaceholder() == $this->getCurrentItemToGuess()) {
      $this->setStatusMessage($this->winnerMessage);

      // Notify the application that this guessing phase has ended.
      $this->setGameWin(TRUE);
      $this->setGeneratedPlaceholder($this->getCurrentItemToGuess());
    }
    return $this;
  }

  /**
   * Incase the player wasn't lucky enough to make any matches.
   * Notify him of the loss.
   *
   * @return \Drupal\hangman\HangmanInterface
   */
  protected function processTheLossersMessage() {
    if ($this->isCharacterGuessed == FALSE) {
      // Increment error count.
      $error_count = $this->getErrorCount() + 1;

      // If the errors are higher than the current word count in question, the player has lost
      if ($error_count == strlen($this->getCurrentItemToGuess())) {
        $this->setStatusMessage($this->getLooserMessage());
        $this->SetGameOver();
      }

      $this->setErrorCount($error_count);
    }
    return $this;
  }

}
