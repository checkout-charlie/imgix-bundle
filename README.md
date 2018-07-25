[![Build Status](https://travis-ci.org/sparwelt/imgix-bundle.svg?branch=master)](https://travis-ci.org/sparwelt/imgix-bundle)
[![Coverage Status](https://coveralls.io/repos/github/sparwelt/imgix-bundle/badge.svg?branch=master)](https://coveralls.io/github/sparwelt/imgix-bundle?branch=master)

| php5.6 + sf2      | php7.1 + sf2      | php5.6 + sf3      | php7.1 + sf3      | php7.1 + sf4      |
|-------------------|-------------------|-------------------|-------------------|-------------------|
| [![Build1][1]][6] | [![Build2][2]][6] | [![Build3][3]][6] | [![Build4][4]][6] | [![Build5][5]][6] |

[1]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/1
[2]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/2
[3]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/3
[4]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/4
[5]: https://travis-matrix-badges.herokuapp.com/repos/sparwelt/imgix-bundle/branches/master/5
[6]: https://travis-ci.org/bjfish/grails-ci-build-matrix-example

Imgix Bundle
===================

## Installation
```bash
composer require sparwelt/imgix-bundle
```
## Configuration
### Cdn configuration
#### Basic

```yaml
sparwelt_imgix:
  cdn_configurations:
    my_cdn:
      cdn_domains: ['cdn1.imgix.net', 'cdn1.imgix.net']
    my_other_cdn:
      cdn_domains: ['other1.imgix.net', 'other2.imgix.net']
```




