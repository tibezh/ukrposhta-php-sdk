<?php

$config = new PhpCsFixer\Config();
$config
  ->setRules([
    '@PSR2' => true,
    'concat_space' => ['spacing' => 'one'],
    'no_unused_imports' => true,
    'whitespace_after_comma_in_array' => true,
    'method_argument_space' => [
      'keep_multiple_spaces_after_comma' => true,
      'on_multiline' => 'ignore'
    ],
    'return_type_declaration' => [
      'space_before' => 'none'
    ],
    'single_quote' => true,
    'cast_spaces' => ['space' => 'single'],
    'no_trailing_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'binary_operator_spaces' => ['default' => 'single_space'],
    'no_extra_blank_lines' => ['tokens' => ['extra']],
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'comment_to_phpdoc' => true,
    'no_empty_comment' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_line_comment_spacing' => true,
    'single_line_comment_style' => true,
  ])
  ->setFinder(
    PhpCsFixer\Finder::create()
      ->in(__DIR__)
  );

return $config;
