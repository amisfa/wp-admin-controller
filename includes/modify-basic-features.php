<?php

function remove_unnecessary_menu_items() {
    remove_menu_page('edit-comments.php'); // Comments
    remove_menu_page('tools.php'); // Tools
}
add_action('admin_menu', 'remove_unnecessary_menu_items');
