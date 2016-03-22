<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 21:44
 */

namespace Drupal\hangman\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hangman\Hangman;
use Drupal\hangman\HangmanPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Playground
 *   The form where the visitor to the application gets to try out the
 *   hangman words from the different teams.
 *
 * @package Drupal\hangman\Form
 */
class Playground extends FormBase {

  /**
   * @var \Drupal\hangman\HangmanPluginManager
   */
  protected $hangmanManager;

  /**
   * The hangman game instance.
   *
   * @var \Drupal\hangman\Hangman
   */
  protected $gameInstance;

  /**
   * @param \Drupal\hangman\HangmanPluginManager $hangman_plugin_manager
   */
  public function __construct(HangmanPluginManager $hangman_plugin_manager) {
    $this->hangmanManager = $hangman_plugin_manager;
    $this->getGameInstance();
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    return new static ($container->get('plugin.manager.hangman'));
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'hangman_playground';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->initiliazeSessionParamenters();

    $form['player_msg'] = array(
      '#markup' => $this->t('Guess the word i am thinking'),
      '#suffix' => "<br/>"
    );

    $form['guessed_xracter'] = array(
      '#title'         => $this->t('Type your gesture.'),
      '#type'          => 'textfield',
      '#size'          => 1,
      '#default_value' => '',
      '#maxlength'     => 1,
    );

    $form['placeholder_string'] = array(
      '#prefix' => $this->t('Progress of your gesture') . " <br/>",
      '#markup' => $this->gameInstance->getGeneratedPlaceholder(),
      '#suffix' => "<br/>"
    );

    $form['error_count'] = array(
      '#prefix' => $this->t('Error count') . " <br/>",
      '#markup' => $this->gameInstance->getErrorCount(),
      '#suffix' => "<br/>"
    );

    $form['message'] = array(
      '#prefix' => $this->t('message') . "<br/>",
      '#markup' => $this->gameInstance->getStatusMessage(),
      '#suffix' => "<br/>"
    );


    $this->getFormActionButtons($form, $form_state);

    return $form;
  }

  /**
   * Generate a string to be used as a placeholder for a character.
   *
   * @param string $word
   *   The string whose pattern style i am generating.
   *
   * @param string $style
   *   A character to act as a placholder.
   *
   * @return string
   *   The generated pattern.
   */
  protected function generatePlaceholderString($word, $style = '_') {
    $wordlength = strlen($word);
    $placeholder = "";

    for ($i = 0; $i < $wordlength; $i++) {
      $placeholder = "" . $placeholder . $style;
    }

    return $placeholder;
  }

  /**
   * @inheritDoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    $msg = '';
    $element = 'guessed_xracter';
    $letter = $form_state->getValue($element);
    $tringering_element = (string) $form_state->getTriggeringElement()['#value'];
    $formstate_values = $form_state->getValues();

    // Notify the user that field is empty.
    if ($form_state->isValueEmpty($element) && array_key_exists($element, $formstate_values) && $tringering_element <> 'Reset') {
      $form_state->setErrorByName($element, $this->t("You haven't provided any character."));
    }

    // Make sure only alpha numericals are provided.
    if (!$form_state->isValueEmpty($element)) {
      $letter = $form_state->getValue($element);

      if (!$this->gameInstance->validateGuessedCharacter($letter)) {
        $msg = "Only alphanumeric symbols are allowed!";
        $form_state->setErrorByName($element, $msg);
      }
    }

  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Check if the game has ended and terminate the process if true.
    if ($this->gameInstance->isGameOver() == TRUE) {
      return;
    }

    $this->processGameResults($form_state);
  }

  /**
   * Refreshes the form.
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function resetForm(array &$form, FormStateInterface $form_state) {
    unset($_SESSION['hangman']);
  }

  /**
   * Group form elements.
   *   They habour hangman group providers.
   *
   * @param array $form
   *   The structure of the form.
   *
   * @param array $group_options
   *   A list of groups that provide hangman words.
   */
  protected function getGroupsFormElements(array &$form, $group_options) {
    $form['group'] = array(
      '#type'          => 'select',
      '#title'         => $this->t('Select group'),
      '#options'       => ['' => $this->t('Select')] + $group_options,
      '#default_value' => '',
      '#description'   => $this->t('Groups that provide the hangman words.'),
    );
  }

  /**
   * Get form buttons.
   *
   * @param array $form
   *   The structure of the form.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  protected function getFormActionButtons(array &$form, FormStateInterface $form_state) {
    $error_count = FALSE;

    if (!empty($this->gameInstance->getErrorCount()) && $this->gameInstance->getErrorCount() == strlen($this->gameInstance->getCurrentItemToGuess())) {
      $error_count = TRUE;
    }

    if ($error_count || $this->gameInstance->isGameOver()) {
      $form_state->clearErrors();
      $form['actions']['reset'] = array(
        '#type'   => 'submit',
        '#value'  => $this->t('Reset'),
        '#submit' => array('::resetForm'),
      );
    }
    else {
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = array(
        '#type'        => 'submit',
        '#value'       => $this->t('Play'),
        '#button_type' => 'primary',
      );
    }

    // Render the form using the theme_system_config_form().
    $form['#theme'] = 'system_config_form';
  }

  /**
   * Initiliaze session paramenters.
   *
   * @return string
   *  The word that is currently being guessed.
   */
  protected function initiliazeSessionParamenters() {
    $word_to_guess = $this->gameInstance->getCurrentItemToGuess();

    if (empty($this->gameInstance->getGeneratedPlaceholder())) {
      $placeholder_string = $this->gameInstance->generateItemPlaceholder($word_to_guess);
      $this->gameInstance->setGeneratedPlaceholder($placeholder_string);
    }

    $placeholder_string = $this->gameInstance->generateItemPlaceholder($word_to_guess);
  }

  /**
   * Process the player's results.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function processGameResults(FormStateInterface $form_state) {
    // Get character the player just guessed.
    $guessed_xracter = $form_state->getValue('guessed_xracter');
    $this->gameInstance->setCurrentGuessedXracter($guessed_xracter);
    $this->gameInstance->processGameResults();
  }

  /**
   * Create or retrieve game instance.
   */
  protected function getGameInstance() {
    if (empty($_SESSION['hangman']['instance'])) {
      // Get the words to be guessed.
      $words_list = $this->hangmanManager->createInstance('3d_hubs')->getListOfItems();

      // Demostration of other providers of words
      //$words_list = $this->hangmanManager->createInstance('finalist:robin_words')->getListOfItems();

      $game_instance = (new Hangman())->setListOfItems($words_list);

      $_SESSION['hangman']['instance'] = $game_instance->initializeGame();
      $this->gameInstance = $_SESSION['hangman']['instance'];
    }
    else {
      $this->gameInstance = $_SESSION['hangman']['instance'];
    }
  }


}
