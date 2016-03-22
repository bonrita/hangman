<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 21:55
 */

namespace Drupal\hangman\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a custom "hangman" annotation object.
 *
 * @Annotation
 */
class Hangman extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the hangman provider or source.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * A glimspe or image of who provided the words.
   *
   * This is not provided manually, it will be added by the discovery mechanism.
   *
   * @var string
   */
  public $image;

  /**
   * An array of words  in which to randomly pick a word to guess.
   *
   * @var array
   */
  public $words;

  /**
   * The description or tip from the team that provided the hangman words.
   *
   * @var string
   */
  public $description = '';

  /**
   * The group name that is providing the words.
   *
   * @var string
   */
  public $group_name = '';

}
