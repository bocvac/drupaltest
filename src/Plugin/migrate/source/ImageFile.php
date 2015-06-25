<?php

/**
 * @file
 * Contains \Drupal\import\Plugin\migrate\source\ImageFile.
 */

namespace Drupal\import\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_plus\Plugin\migrate\source\CSV;

/**
 * Source for Image csv.
 *
 * @MigrateSource(
 *   id = "image_file"
 * )
 */
class ImageFile extends CSV {

  public function prepareRow(Row $row) {
    if ($image = $row->getSourceProperty('File')) {
      $base_path = dirname($this->configuration['path']) . '/images/';

      // Setup our source/destination paths.
      $path = $base_path . $image;
      $destination_path = 'public://' . $image;

      // Normally we would map CSV columns to these values, but to reduce
      // complexity we assume paths and status.
      $row->setSourceProperty('filepath', $path);
      $row->setDestinationProperty('uri', $destination_path);
      $row->setDestinationProperty('status', 1);
    }
  }
}
