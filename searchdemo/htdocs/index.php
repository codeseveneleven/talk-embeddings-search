<?php
require_once '../vendor/autoload.php';
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
    <link rel="stylesheet" href="css/pico.min.css">  <meta name="description" content="">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" href="/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="icon.png">

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">
</head>

<body>

  <!-- Add your site or application content here -->

  <main class="container">
      <p>
          Indexed sites:

      </p>

      <form method="get" action="/">
          <fieldset role="group">
          <input type="search" name="search" placeholder="Search with a naturally phrased question"/>
          <button type="submit">Search</button>
          </fieldset>
      </form>

      <div id="searchresult">

      </div>

  </main>

  <template id="template">
      <article>
          <header></header>
          <div>

          </div>
          <footer>
              <a href="#" target="_blank">read more..</a>
          </footer>
      </article>
  </template>

  <script src="js/app.js"></script>

</body>

</html>
