<?php

/**
 * @file
 * Contains \Drupal\import\Plugin\migrate\source\ArticleNode.
 */

namespace Drupal\import\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_plus\Plugin\migrate\source\CSV;
/**
 * Source for Article node CSV.
 *
 * @MigrateSource(
 *   id = "article_node"
 * )
 */
class ArticleNode extends CSV {
  public function prepareRow(Row $row) {
    if ($value = $row->getSourceProperty('Tags')) {
      $row->setSourceProperty('Tags', explode(',', $value));
    }
  }
}
