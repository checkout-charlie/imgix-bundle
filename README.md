[![Build Status](https://travis-ci.org/sparwelt/imgix-bundle.svg?branch=master)](https://travis-ci.org/sparwelt/imgix-bundle)
[![Coverage Status](https://coveralls.io/repos/github/sparwelt/imgix-bundle/badge.svg?branch=master)](https://coveralls.io/github/sparwelt/imgix-bundle?branch=master)

| php5.6 + sf2      | php7.1 + sf2      | php5.6 + sf3      | php7.1 + sf3      | php7.1 + sf4      |
|-------------------|-------------------|-------------------|-------------------|-------------------|
| [![Status][1]][6] | [![Status][2]][6] | [![Status][3]][6] | [![Status][4]][6] | [![Status][5]][6] |

[1]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/1
[2]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/2
[3]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/3
[4]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/4
[5]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/5
[6]: https://travis-ci.org/sparwelt/imgix-bundle

Imgix Bundle
===================

## Installation
```bash
composer require sparwelt/imgix-bundle
```
## Basic configuration
```yaml
sparwelt_imgix:
  cdn_configurations:
    my_cdn:
        cdn_domains: ['my.imgix.net']
        sign_key: '12345'

  image_filters:
    my_basic_filter:
        src: {w: 30, h: 60}
```
## Basic usage
```twig
{# url generation #}
{{ imgix_url('/dir/test.png', {w: 100, h: 200}) }}
{# "https://my.imgix.net/dir/test.png?w=100&h=200" #}

{# image generation #}
{{ imgix_image('/dir/test.png', {src: {w: 100, h: 200}}) }};
{# <img src="https://my.imgix.net/dir/test.png?w=100&h=200"> #}

{# html conversion #}
{{ imgix_html('<li><img src="/test.png"><\li><li><img src="/test2.png">', {src: {w: 100, h:  200}}) }}
{# <li><img src="https://my.imgix.net/test.png"><\li><li><img src="https://my.imgix.net/test2.png"> #}
```

### Responsive usage
```twig
{# image generation #}
{{ imgix_image('/dir/test.png', {
            src: {h: 150, w: 300},
            srcset: {
                100w: {h: 300, w: 600},
                500w: {h: 600, w: 900},
            },
            sizes: '(min-width: 900px) 1000px, (max-width: 900px)'
}) }}
{# <img src="https://test.imgix.net/dir/test.png?h=150&w=300"
        srcset="https://test.imgix.net/dir/test.png?h=300&w=600 100w, https://test.imgix.net/dir/test.png?h=600&w=900 500w"
        sizes="(min-width: 900px) 1000px, (max-width: 900px)"> #}

{# image generation #}
  <img srcset="{{imgix_attr('test.png', {
    '2x': {w: 400, h: 200}
    '3x': {w: 600, h: 300}
  }) }}">

{# <img srcset="https://test.imgix.net/test.png?h=200&w=400 2x, https://test.imgix.net/test.png?h=300&w=600 3x"> #}
```

### Lazyloading
```twig
{{ imgix_image('/dir/test.png', {
    'src': {h: 30, w: 60},
    'srcset': 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
    'data-srcset': {
        '100w': {'h': 60, 'w': 120}
        '500w': {'h': 90, 'w': 180},
    },
    'data-sizes': 'auto',
    'class': 'lazyload',
}) }}
{# <img src="https://test.imgix.net/dir/test.png?h=30&w=60" 
       srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
       data-srcset="https://test.imgix.net/dir/test.png?h=60&w=120 100w, https://test.imgix.net/dir/test.png?h=90&w=180 500w"
       data-sizes="auto" 
       class="lazyload">
```

### Named filters
Instead of repeating filters at every usage, named filters can be configured once and called by name: 
```yaml
sparwelt_imgix:
  image_filters:
    my_basic_filter:
        src: {w: 30, h: 60}
    my_blur_lazyload_filter:
        src: {w: 30, h: 60}
        data-src: {h: 30, w: 60, blur: 1000}
        data-srcset:
            100w: {h: 60, w: 120}
            500w: {h: 90, w: 180}
        data-sizes: 'auto'
        class: 'lazyload'
```
```twig
{{ imgix_image('dir/test.png', 'my_basic_filter') }}
{# <img src="https://test.imgix.net/dir/test.png?h=30&w=60"> #}

{{ imgix_image('dir/test.png', 'my_blur_lazyload_filter') }}
{# <img src="https://test.imgix.net/dir/test.png?h=30&w=60" 
       data-src="https://test.imgix.net/dir/test.png?blur=1000h=30&w=60"
       data-srcset="https://test.imgix.net/dir/test.png?h=60&w=120 100w, https://test.imgix.net/dir/test.png?h=90&w=180 500w"
       data-sizes="auto" 
       class="lazyload">
#}

{{ imgix_url('dir/test.png', 'my_basic_filter.src') }}
{# https://test.imgix.net/test.png?h=30&w=60 #}

{{ imgix_url('dir/test.png', 'my_basic_filter.src', {q: 75}) }}
{# https://test.imgix.net/test.png?h=30&w=60&q=75 #}

{{ imgix_attr('dir/test.png', 'my_blur_lazyload_filter.data-srcset') }}
{# https://test.imgix.net/dir/test.png?h=60&w=120 100w, https://test.imgix.net/dir/test.png?h=90&w=180 500w #}

{{ imgix_html($html, 'my_blur_lazyload_filter') }}
{# ... replaces all images with responsive ones #}
```

### Multiple cdn domains
Different cdn domains and configurations can be specified.
The resolver will start evaluating the first configuration and will pass to the next until a suitable match is found.
If multiple domains are specified for the same configuration entry, they will be rotated (this is known as 'domain sharding', the default strategy is 'crc')
```yaml
sparwelt_imgix:
  cdn_configurations:
        # mathches images whose source domain is 'mysite.com' (including subdomains)
        # AND path begins with 'uploads/' OR 'media/'
        # Relative urls won't match
        source_domains_and_pattern:
            cdn_domains: ['source-domain-and-pattern.imgix.net']
            source_domains: ['mysite.com']
            path_patterns: ['^[/]uploads/', '^[/]media/']

        # matches images whose source domain is exactly 'www3.mysite.com' OR 'www4.mysite.com'
        # Relative urls won't match
        source_sub_domain:
            cdn_domains: ['source-sub-domain.imgix.net']
            source_domains: ['www3.mysite.com', 'www4.mysite.com']

        # matches images whose source domain is 'mysite.com', including subdomains
        # Relative urls won't match
        source_domains:
            cdn_domains: ['source-domain.imgix.net']
            source_domains: ['mysite.com']

        # matches images whose source domain is 'mysite.com', including subdomains
        # AND relative urls (because of the 'null')
        source_domains_and_null:
            cdn_domains: ['source-domain.imgix.net']
            source_domains: ['mysite.com', null]

        # Matches relative urls only, whose path begins with 'uploads/'.
        # Absolute urls won't match.
        pattern:
            cdn_domains: ['pattern.imgix.net']
            path_patterns: ['^[/]pattern/']

        # matches relative urls only, whose path begins with 'sign-key/'.
        # Appends sign-key to the generated url (recommended)
        sign_key:
            cdn_domains: ['sign-key.imgix.net']
            path_patterns: ['[^]/sign-key/']
            sign_key: '12345'

        # Matches relative urls only, whose path begins with 'shard-crc/'.
        # Will choose the cdn domains by the hash of the path (recommended)
        shard_crc:
            cdn_domains: ['shard-crc1.imgix.net', 'shard-crc2.imgix.net']
            path_patterns: ['^[/]shard-crc/']
            shard_strategy: 'crc' #default

        # Matches relative urls only, whose path begins with 'shard-cycle/'.
        # Will rotate between the 2 cdn domains (increase costs)
        shard_cycle:
            cdn_domains: ['shard-cycle1.imgix.net', 'shard-cycle2.imgix.net']
            path_patterns: ['^[/]shard-cycle/']
            shard_strategy: 'cycle'
        ],

        # Matches all relative urls.
        my_default:
            cdn_domains: ['default.imgix.net']

```
