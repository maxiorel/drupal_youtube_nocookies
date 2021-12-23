<?php

namespace Drupal\youtube_nocookies\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;

/**
 * Provides a filter to change youtube iframe to youtube-nocookies.com domain
 *
 * @Filter(
 *   id = "youtube_nocookies_filter",
 *   title = @Translation("Youtube iframe to youtube-nocookies.com domain"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE,
 *   weight = 100
 * )
 */
class YoutubeNocookies extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode): FilterProcessResult {
    $result = new FilterProcessResult($text);
    $html_dom = Html::load($text);

    $matches = $html_dom->getElementsByTagName('iframe');
    foreach ($matches as $element) {
      if (strstr($element->getAttribute('src'),'youtube')){
        $element->setAttribute('src',str_replace('www.youtube.com', 'www.youtube-nocookie.com', $element->getAttribute('src')));
      }
    }

    $result->setProcessedText(Html::serialize($html_dom));

    return $result;
  }



}
