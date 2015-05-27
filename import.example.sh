#!/usr/bin/env bash

# ---------------------------------------------------------
# Runs the Import example migrations in correct order.
# ---------------------------------------------------------

# Usage: sh import.example.sh
echo "Running migration imports..."
drush mi import_node_page
drush mi import_term_tags
drush mi import_node_article
echo "Import migrations were attempted."
echo "If there are no errors, you may proceed."
