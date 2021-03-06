<?php

  function __autoload($class) {
    include_once 'classes/'.$class.'.php';
  }

  include 'local.php';

  if (!isset($_GET['view'])) {
    $view = '';

  } else {
    $view = trim($_GET['view']);
  }

  switch ($view) {
    case 'history'  : $view = new HistoryView();  break;
    case 'settings' : $view = new SettingsView(); break;
    case 'summary'  : $view = new SummaryView();  break;
    default:          $view = new HistoryView();  break;
  }

  $lang = Settings::get('language');
  $lang = $lang === null ? 'en' : $lang;

  $locales = new Locale($lang);
?>

<!DOCTYPE html>
<html dir="ltr" lang="de-DE">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Income and Expense App</title>
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
  <body>
    <header>
      <div class="wrapper">
        <h1>Simple Income and Expense App</h1>
        <nav>
          <menu>
            <li>
              <a href="/history"><?php I18n::e('history.label'); ?></a>
            </li>
            <li>
              <a href="/summary"><?php I18n::e('summary.label'); ?></a>
            </li>
            <li>
              <a href="/settings"><?php I18n::e('settings.label'); ?></a>
            </li>
          </menu>
        </nav>
      </div>
    </header>
    <div class="wrapper">
      <h2><?php echo $view->getTitle(); ?></h2>
      <?php $view->show(); ?>
    </div>
    <div class="overlay">
      <div id="dialog" class="dialog">
        <div class="title">Dialog title</div>
        <div class="message">Dialog text message</div>
        <div class="controls">
          <span class="confirm">Confirm</span>
          <span class="cancel">Cancel</span>
        </div>
      </div>
    </div>
  </body>
  <script src="https://d3js.org/d3.v3.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="assets/js/lib/_utils.js"></script>
  <script src="assets/js/dialog.js"></script>
  <script src="assets/js/combo.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      app.combo.init();
    });
  </script>
  <?php echo $view->getScripts(); ?>
</html>