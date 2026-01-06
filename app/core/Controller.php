<?php
class Controller {

    protected function view($view, $data = []) {
        extract($data);

        // load header + CSS
        require "../app/views/layout/header.php";

        // load navbar
        require "../app/views/layout/navbar.php";

        // main content wrapper
        echo '<div class="container">';
        if (!empty($view) && file_exists("../app/views/$view.php")) {
            require "../app/views/$view.php";
        } else {
            echo "<h2>View not found: $view</h2>";
        }
        echo '</div>';

        // footer
        require "../app/views/layout/footer.php";
    }
}
