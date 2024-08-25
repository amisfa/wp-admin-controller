<?php

function remove_unnecessary_menu_items() {
    remove_submenu_page('themes.php', 'themes.php');
}
add_action('admin_menu', 'remove_unnecessary_menu_items', 999);
