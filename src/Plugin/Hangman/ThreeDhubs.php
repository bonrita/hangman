<?php
/**
 * Created by PhpStorm.
 * User: bona
 * Date: 18/03/16
 * Time: 23:41
 */

namespace Drupal\hangman\Plugin\Hangman;


use Drupal\hangman\Annotation\Hangman;
use Drupal\hangman\HangmanItems;

/**
 * The words to guess provided by the 3D hubs team.
 *
 * @Hangman(
 *   id = "3d_hubs",
 *   label = @Translation("3D hubs"),
 *   image = "https://upload.wikimedia.org/wikipedia/en/d/df/3D-Hubs-logo-vertical.png",
 *   words = {
 *     "3dhubs",
 *     "marvin",
 *     "print",
 *     "filament",
 *     "order",
 *     "layer"
 *   }
 * )
 */
class ThreeDhubs extends HangmanItems {

  /**
   * @inheritDoc
   */
  public function allowedGuesses($item = '') {
    return strlen($item);
  }

}
