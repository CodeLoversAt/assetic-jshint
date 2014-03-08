assetic-jshint
==============

JSHint filter for Assetic

Most likely you will want to use this filter in a Symonfy 2 app. So we've created a bundle too :)

## [codelovers/assetic-jshint-bundle](https://github.com/CodeLoversAt/assetic-jshint-bundle)


# Standalone usage

This filter will pass given assets through [JsHint](http://www.jshint.com/) and throw an exception if any error has been found. To run it, you will need JsHint installed. Assuming you already have installed [node.js](http://nodejs.org/), you can install JsHint easily:

    npm install -g jshint
    
The filter then only needs the path to the jshint binary as it's only constructor argument. Most likely it will be `/usr/bin/jshint`, which is the default value, or `/usr/local/bin/jshint`

```PHP
<?php
$filter = new JsHintFilter(); // if your jshint binary is in /usr/bin/jshint

$filter = new JsHintFilter("/path/to/jshint");
```