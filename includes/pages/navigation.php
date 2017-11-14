<?php
$pageId = basename($_SERVER['PHP_SELF']); //basename($_SERVER['PHP_SELF']);
$sel_subj = array_exists('subject', $_GET);
$sel_page = array_exists('page', $_GET);

$output = '<ul class="subjects">';
$subject_set = get_all_subjects();
while ($subject = mysqli_fetch_array($subject_set)) {

    $sel_subj_menu_name = ($subject["id"] == $sel_subj) ? $subject["menu_name"] : "";

    $selected_subject = ($subject["id"] == $sel_subj) ? "class = \"selected\"" : "";

    $output .= "<li {$selected_subject}><a href=\"" . add_or_update_params($pageId, 'subject', $subject["id"]) . "\">{$subject["menu_name"]}</a></li>";

    $output .= '<ul class="pages">';

    $page_set = get_all_pages_for_subjects($subject["id"]);

    while ($page = mysqli_fetch_array($page_set)) {

        $selected_page = ($page["id"] == $sel_page) ? "class = \"selected\"" : "";

        $output .= "<li {$selected_page}><a href=\"" . add_or_update_params($pageId, 'page', $page["id"]) . "\">{$page["menu_name"]}</a></li>";
    }
    $output .= "</ul>";
}
$selected_subject = (array_key_exists('addSubject', $_GET)) ? "class = \"selected\"" : "";

$selected_page = (array_key_exists('addPage', $_GET)) ? "class = \"selected\"" : "";

$output .= "<br />";

$output .= "<ul class=\"subjects\">";

$output .= "<li {$selected_subject}><a href=\"" .add_or_update_params(basename($_SERVER['PHP_SELF']), 'addSubject', 0) ."\">+ New subject</a></li>";

$output .= "<li {$selected_page}><a {$selected_page} href=\"" .add_or_update_params(basename($_SERVER['PHP_SELF']), 'addPage', 0) ."\">+ New page</a></li>";

$output .= "</ul>";

echo $output;
?>