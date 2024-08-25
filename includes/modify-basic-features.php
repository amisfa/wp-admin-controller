<?php

function remove_unnecessary_menu_items() {
    remove_menu_page('themes.php');
}
add_action('admin_menu', 'remove_unnecessary_menu_items', 999);
