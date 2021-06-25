<?php

namespace RWP\Components;

use RWP\Components\{Html, HtmlList, Pagination, Button};

class Blog extends Html {

  public $post;

  public $order = [
    'header',
    'image',
    'main',
    'footer',
    'nav',
    'comments'
  ];

  public $locations = [
    'header',
    'image',
    'main',
    'footer',
    'nav',
    'comments'
  ];

  public $items = [
    'title',
    'media',
    'body',
    'time',
    'link',
    'terms',
    'author',
    'edit',
  ];

  public $atts = [
    'tag' => 'article',
    'class' => [
      'item-wrapper'
    ]
  ];

  public $header = [
    'atts' => [
      'tag' => 'header',
      'class' => [
        'item-header'
      ]
    ]
  ];

  public $main = [
    'atts' => [
      'tag' => 'div',
      'class' => [
        'item-main'
      ]
    ]
  ];

  public $footer = [
    'atts' => [
      'tag' => 'footer',
      'class' => [
        'item-footer'
      ]
    ]
  ];

  public $title = [
    'location' => 'header',
    'link' => false,
    'atts' => [
      'tag' => 'h1',
      'class' => [
        'item-title'
      ]
    ]
  ];

  public $media = [
    'location' => 'main',
    'size' => 'large',
    'atts' => [
      'class' => [
        'item-media'
      ]
    ]
  ];

  /**
   * Blog Time
   *
   * @var array|Html $time
   */
  public $time = [
    'location' => 'footer',
    'modified' => [
      'format' => null,
      'atts' => [
        'tag' => 'time',
        'class' => [
          'modified'
        ]
      ]
    ],
    'created' => [
      'format' =>  null,
      'atts' => [
        'tag' => 'time',
        'class' => [
          'created'
        ]
      ]
    ],
    'atts' => [
      'tag' => 'div',
      'class' => [
        'item-time'
      ]
    ]
  ];

  public $author = [
    'location' => 'footer',
    'atts' => [
      'class' => [
        'item-author'
      ]
    ],
    'items' => [
      'image',
      'name',
      'job',
      'description',
      'links',
    ],
  ];

  /**
   * Main body of blog
   *
   * @var array|Html $body
   */

  public $body = [
    'location' => 'main',
    'length' => null,
    'atts' => [
      'tag' => 'div',
      'class' => [
        'item-body'
      ]
    ]
  ];

  public $link = [
    'location' => 'main',
    'atts' => [
      'rel' => 'bookmark',
    ]
  ];

  public $share = [
    'location' => null,
    'atts' => [
      'class' => [
        'item-share'
      ]
    ]
  ];

  public $edit = [
    'location' => 'footer',
    'atts' => [
      'class' => [
        'item-edit'
      ]
    ]
  ];

  /**
   * Blog Terms
   *
   * @var array|Html $terms
   */

  public $terms = [
    'location' => null,
    'terms' => [
      'category',
      'post_tag'
    ],
    'atts' => [
      'tag' => 'div',
      'class' => [
        'item-terms'
      ]
    ],
  ];

  public $nav = [
    'count' => 2,
    'atts' => [
      'class' => [
        'item-nav'
      ]
    ]
  ];

  public $comments = [
    'location' => null,
    'atts' => [
      'class' => [
        'item-comments'
      ]
    ]
  ];

  public function __construct($args = []) {

    parent::__construct($args);

    if (!($this->post instanceof \WP_Post)) {
      $this->post = get_post($this->post);
    }
    $post = $this->post;
    $post_id = $post->ID;

    $this->setAttr('id', "$post->post_type-$post->post_name-$post_id");
    $this->addClasses(get_post_class(null, $post_id));

    $this->link['atts']['href'] = get_permalink($this->post->ID);

    $this->header = new Html($this->header);
    $this->main   = new Html($this->main);
    $this->footer = new Html($this->footer);

    $items = $this->items;

    if (in_array('media', $items) && has_post_thumbnail($post)) {
      $thumbnail_id = get_post_thumbnail_id($post_id);
      if (!empty(get_post($thumbnail_id))) {
        $this->media['src'] = $thumbnail_id;

        $this->media    = new Media($this->media);
      } else {
        $this->media = false;
      }
    }

    if (in_array('title', $items)) {
      $this->title['content'] = $post->post_title;


      if ($this->title['link']) {
        $title_args = [
          'content' => $this->title['content'],
          'atts' => $this->link['atts']
        ];
        $title_args['atts']['class'][] = 'stretched-link';
        $this->title['content'] = Html::link($title_args)->__toString();
      }

      $this->title    = Html::text($this->title);
    }

    if (in_array('time', $items)) {
      $this->time    = Html::text($this->time);
      $this->setupTime();
    }

    if (in_array('terms', $items)) {
      $this->terms   = new Html($this->terms);
      $this->setupTaxonomies();
    }

    if (in_array('author', $items)) {
      $this->author['id'] = $this->post->ID;
      $this->setupAuthor();
    }


    if (in_array('share', $items)) {
      $this->share    = new Html($this->share);
    }

    if (in_array('link', $items)) {

      $this->link = new Button($this->link);
    }

    if (in_array('nav', $items)) {
      $this->nav      = new Pagination($this->nav);
    }


    if (in_array('comments', $items)) {
      $this->comments = new Html($this->comments);
      $this->setupComments();
    }

    if (get_edit_post_link($this->post->ID)) {
      $this->edit     = Html::link($this->edit);
      $this->edit->setAttr('href', get_edit_post_link($this->post->ID));
      $this->edit->addContent(sprintf(__('Edit <span class="sr-only">%s</span>', 'sage'), wp_kses_post(get_the_title($this->post->ID))));
    }

    if (in_array('body', $items)) {
      $this->body     = new Html($this->body);
      if (!empty($this->body->length) && $this->body->length !== 0) {
        if (!empty($this->body->length)) {
          $content = self::excerpt($post, $this->body->length);
        } else {
          $content = $post->post_content;
          $content = rwp_filtered_content($content);
        }



        $content = '<div class="item-content">' . $content . '</div>';

        $this->body->addContent($content, 'content');
      }
    }
  }

  public function preBuild() {

    foreach ($this->items as $item) {
      if (is_object($this->$item) && property_exists($this->$item, 'location')) {
        $location = $this->$item->location;
        if (!empty($location)) {
          $this->$location->addContent($this->$item, $item);
        }
      } else {
        $this->addContent($this->$item, $item);
      }
    }

    foreach ($this->locations as $location) {
      if ($this->$location instanceof Html) {
        if ($this->$location->hasContent()) {
          $this->addContent($this->$location, $location);
        }
      }
    }
  }

  /**
   * Function for ouputing the post date schema (published time and modified time)
   *
   * @param string|int $post_id  // The post ID
   * @param string $before       // Content to display before the list
   * @param string $after        // Content to display after the list
   * @param bool $relative       // Whether to use relative dates
   *
   * @return string|null // An HTML list of time or nothing if it fails
   */
  public function setupTime() {

    $created = Html::text($this->time->created);
    $modified = Html::text($this->time->modified);

    if (!$created->hasArg('format') || empty($created->format)) {
      $created->format = get_option('date_format');
    }
    if (!$modified->hasArg('format') || empty($modified->format)) {
      $modified->format = get_option('date_format');
    }
    if (!$created->hasAttr('datetime') || empty($created->getAttr('datetime'))) {
      $created->setAttr('datetime', get_the_date('c', $this->post->ID));
    }
    if (!$modified->hasAttr('datetime') || empty($modified->getAttr('datetime'))) {
      $modified->setAttr('datetime', get_the_modified_date('c', $this->post->ID));
    }

    $label = Html::text([
      'content' => __('Posted On: ', 'sage'),
      'atts' => [
        'tag' => 'span',
      ],
      'screen_reader' => true
    ]);
    $created->addContent($label, 'before');

    $label = Html::text([
      'content' => __('Modified On: ', 'sage'),
      'atts' => [
        'tag' => 'span',
      ],
      'screen_reader' => true
    ]);
    $modified->addContent($label, 'before');


    if ($created->format === 'relative') {
      $created->addContent(human_time_diff(get_the_date('U', $this->post->ID), current_time('U')));
    } else {
      $created->addContent(get_the_date($created->format, $this->post->ID));
    }

    $this->time->addContent($created);

    if ($modified->format === 'relative') {
      $modified->addContent(human_time_diff(get_the_modified_date('U', $this->post), current_time('U')));
    } else {
      $modified->addContent(get_the_modified_date($modified->format, $this->post));
    }

    $this->time->addContent($modified);
  }

  public function setupTaxonomies() {

    $taxonomies = $this->terms->terms;
    if (!empty($taxonomies)) {
      foreach ($taxonomies as $i => $taxonomy) {

        $terms = get_the_terms($this->post, $taxonomy);
        $tax_list = null;
        if (is_array($terms)) {
          $tax_list = new HtmlList(['inline' => true]);
          $tax_list->addClass("$taxonomy-list");

          foreach ($terms as $term) {
            $term_item = Html::text();
            $term_item->addClasses([
              "$taxonomy-item",
              $term->taxonomy,
              $term->taxonomy . '-' . $term->term_id,
              $term->taxonomy . '-' . $term->slug
            ]);
            $link = Html::link([
              'content' => $term->name,
              'atts' => [
                'href' => get_term_link($term->term_id),
                'title' => __('View ' . $term->name . ' Archive', 'sage'),
                'class' => [
                  "$taxonomy-link",
                ]
              ]
            ]);
            $term_item->addContent($link);
            $tax_list->addContent($term_item);
          }
        }
        if (!empty($tax_list)) {
          $this->terms->addContent($tax_list);
        }
      }
    }
  }


  public function setupEditLink() {
    if (get_edit_post_link($this->post->ID)) {
      $args = $this->edit;
      $args['content'] = sprintf(
        __('Edit <span class="sr-only">%s</span>', 'sage'),
        wp_kses_post(get_the_title($this->post->ID))
      );
      $args['atts']['href'] = get_edit_post_link($this->post->ID);
      $link = Html::link($args);

      $this->edit = $link;
    }
  }

  public function setupComments() {
    if (!comments_open($this->post->ID)) return;

    if (is_singular() && !post_password_required()) {
      ob_start();
      comments_template();
      $comments = ob_get_clean();
      $this->comments->addContent($comments);
    } else {
      $this->comments->addContent(comments_popup_link(
        sprintf(
          wp_kses(
            /* translators: %s: post title */
            __('Leave a Comment<span class="sr-only"> on %s</span>', 'sage'),
            array(
              'span' => array(
                'class' => array(),
              ),
            )
          ),
          wp_kses_post($this->post->post_title)
        )
      ));
    }
  }

  public function setupAuthor() {

    //$this->author = App::userBlock($this->author);
  }

  public static function excerpt($post = null, $length = null, $finish_sentence = true, $excerpt_end = '[&hellip;]') {
    $post = get_post($post);

    $text = rwp_get_content($post);

    $excerpt = self::variableLengthExcerpt($text, $length, $finish_sentence, $excerpt_end);

    if (has_excerpt($post->ID)) {
      $excerpt = get_the_excerpt($post->ID);
      if ($length) {
        $excerpt = wp_trim_words($excerpt, $length, $excerpt_end);
      }
    }


    return $excerpt;
  }

  /**
   * Creating a variable length excerpt
   *
   * @param string $text
   * @param int $length
   * @param int $finish_sentence
   * @param string $excerpt_end
   *
   * @return string
   */
  private static function createVariableLengthExcerpt($text, $length, $finish_sentence = 1, $excerpt_end = '[&hellip;]') {

    $tokens = array();
    $out    = '';
    $word   = 0;

    if (!empty($length)) {
      //Divide the string into tokens; HTML tags, or words, followed by any whitespace.
      $regex = '/(<[^>]+>|[^<>\s]+)\s*/u';
      preg_match_all($regex, $text, $tokens);
      foreach ($tokens[0] as $t) {
        //Parse each token
        if ($word >= $length && !$finish_sentence) {
          //Limit reached
          break;
        }
        if ($t[0] != '<') {
          //Token is not a tag.
          //Regular expression that checks for the end of the sentence: '.', '?' or '!'
          $regex1 = '/[\?\.\!]\s*$/uS';
          if ($word >= $length && $finish_sentence && preg_match($regex1, $t) == 1) {
            //Limit reached, continue until ? . or ! occur to reach the end of the sentence.
            $out .= trim($t);
            break;
          }
          $word++;
        }
        $out .= $t;
      }
    } else {
      $out = $text;
    }

    $out .= $excerpt_end;

    return trim(force_balance_tags($out));
  }

  /**
   * Outputing the variable length excerpt
   *
   * @param string $text | The original text
   * @param int $length | The length of the excerpt
   * @uses createVariableLengthExcerpt
   *
   * @return string
   */
  public static function variableLengthExcerpt($text, $length = 30, $finish_sentence = true, $excerpt_end = '[&hellip;]', $allowed_tags = ['em', 'i', 'b', 'strong']) {
    if (empty($text)) return;

    $text = strip_tags($text, $allowed_tags);


    $text = self::createVariableLengthExcerpt($text, $length, $finish_sentence, $excerpt_end);
    return $text;
  }

  public static function publisherSchema($post) {
    // $post = get_post($post);
    // $author = App::userInfo($post);

    // $schema = [];

    // $schema['author'] = [
    //   '@type' => 'Person',
    //   'name' => $author['name']['display'],
    // ];
    // if (!empty($author['description'])) {
    //   $schema['author']['description'] = $author['description'];
    // }
    // if (!empty($author['team'])) {
    //   $schema['author']['@id'] = get_permalink($author['team']);
    // } else {
    //   $schema['author']['@id'] = $author['url'];
    // }
    // if (wp_get_attachment_image_url($author['image'])) {
    //   $schema['author']['image']['@id'] = wp_get_attachment_image_url($author['image']);
    // }
    // if (!empty($author['links'])) {
    //   foreach ($author['links'] as $key => $link) {
    //     $schema['author']['sameAs'][] = $link;
    //   }
    // }
    // $company_info = get_option('sage' . '_company_info');

    // $schema['publisher'] =  [
    //   'name' => company_name(),
    // ];

    // if (!empty($company_info['schema_type'])) {
    //   $schema['publisher']['@type'] = $company_info['schema_type'];
    // }

    // if (site_logo_id('meta')) {
    //   $logo = wp_get_attachment_metadata(site_logo_id('meta'));
    //   $schema['publisher']['logo'] = [
    //     '@type' => 'ImageObject',
    //     'url' => wp_get_attachment_image_url(site_logo_id('meta')),
    //     'width' => $logo['width'],
    //     'height' => $logo['height'],
    //   ];
    // }
    // return $schema;
  }

  public static function postSchema($post, &$schema = []) {
    $post = get_post($post);
    if (get_field('is_press_release', $post)) {
      $schema['@type'] = 'NewsArticle';
    } else {
      $schema['@type'] = 'BlogPosting';
    }
    $schema['headline'] = $post->post_title;
    $schema['datePublished'] = $post->post_date;
    if (!empty(get_post_meta($post->ID, '_yoast_wpseo_metadesc', true))) {
      $schema['description'] = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
    } else if (self::excerpt($post)) {
      $schema['description'] = self::excerpt($post);
    }

    if (has_post_thumbnail($post)) {
      $schema['image'] = get_the_post_thumbnail_url($post);
    }

    return $schema;
  }
}
