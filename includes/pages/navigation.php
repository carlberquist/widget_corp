<?php
$self = basename($_SERVER['PHP_SELF']); //basename($_SERVER['PHP_SELF']);
$sel_subj = $_GET['subject'] ?? "";
$sel_page = $_GET['page'] ?? "";
$output = '<ul class="subjects">';
$subject_set = get_all_subjects();
foreach ($subject_set as $subject) {
    $sel_subj_menu_name = ($subject["id"] == $sel_subj) ? $subject["menu_name"] : "";
    $selected_subject = ($subject["id"] == $sel_subj) ? "class = \"selected\"" : "";
    $output .= "<li {$selected_subject}><a href=\"" . add_or_update_params($self, 'subject', $subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
    $output .= '<ul class="pages">';
    $page_set = get_all_pages_for_subjects($subject["id"]);
    foreach ($page_set as $page) {
        $selected_page = ($page["id"] == $sel_page) ? "class = \"selected\"" : "";
        $output .= "<li {$selected_page}><a href=\"" . add_or_update_params($self, 'page', $page["id"]) . "\">{$page["menu_name"]}</a></li>";
    }
    $output .= "</ul>";
}
$selected_subject = (array_key_exists('addSubject', $_GET)) ? "class = \"selected\"" : "";
$selected_page = (array_key_exists('addPage', $_GET)) ? "class = \"selected\"" : "";
$output .= "<br />";
$output .= "<ul class=\"subjects\">";
$output .= "<li {$selected_subject}><a href=\"" . add_or_update_params($self, 'addSubject', 0) . "\">+ New subject</a></li>";
$output .= "<li {$selected_page}><a {$selected_page} href=\"" . add_or_update_params($self, 'addPage', 0) . "\">+ New page</a></li>";
$output .= "</ul>";
echo $output;
?>