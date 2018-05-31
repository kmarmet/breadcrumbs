<?php
   function breadcrumbs() {
      $home             = "<a href='/index.php'>HOME</a>";
      $separator        = "<span> / </span>";
      $job_story_number = $_GET['show'];
      $isDirectory      = false;

      // Get URL array
      $crumbs = explode('/', $_SERVER['REQUEST_URI']);

      // Get end of crumbs array
      $end = end(array_keys($crumbs));

      // Function to abstract HTML building
      function wrapCrumb($url, $crumb) {
         return "<a href='$url'>" . strtoupper($crumb) . "</a>";
      }

      // Start Breadcrumbs div
      echo "<div class='breadcrumbs hide-on-tablet'>";

      // Start with home directory
      echo $home . $separator;

      // Append additional crumbs
      foreach($crumbs as $index => $crumb) {
         // Check if crumb is actually a directory
         if (strpos($crumb, '.php') === false) {
            $isDirectory = true;
         }

         // Remove/hide anything that shouldn't be public
         $crumb = str_replace(array('.php', '-', '?show=', '/', 'inc', 'contact form'), array('', ' ', '', '', '', ''), $crumb);
         $crumb = preg_replace('/\d/', '', $crumb);

         // Ignore empty crumbs
         if (strlen($crumb) <= 0) {
            continue;
         }

         // Add necessary pieces to form URL string
         // Adjust for directories
         if ($isDirectory === true) {
            // Custom
            if ($crumb === 'job stories') {
               $url = '/job-stories.php';
            }
            else {
               $url = "/" . str_replace(' ', '-', $crumb);
            }
         }
         else {
            $url = str_replace(' ', '-', $crumb) . '.php';
         }

         // CUSTOM -> If page is Job Story single page
         if ($job_story_number) {
            echo wrapCrumb($url, $crumb) . $separator . "<a href='/job-stories.php?show={$job_story_number}'>PROFILE $job_story_number</a>";
         }
         // DEFAULT
         else {
            if ($index === $end) {
               echo wrapCrumb($_SERVER['REQUEST_URI'], $crumb);
            }
            else {
               echo wrapCrumb($url, $crumb) . $separator;
            }
         }
      }

      // End Breadcrumbs div
      echo "</div>";
   }

