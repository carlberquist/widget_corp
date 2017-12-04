<?php
$self = basename($_SERVER['PHP_SELF']);
$sel_subj = $_GET['subject'] ?? "";
$sel_page = $_GET['page'] ?? "";
$output = '<ul class="subjects">';
$subject_set = get_subject('id , menu_name');
while ($subject = mysqli_fetch_array($subject_set, MYSQLI_ASSOC)) {
    $subject_id = $subject["id"];
    $sel_subj_menu_name = ($subject_id == $sel_subj) ? $subject["menu_name"] : "";
    $selected_subject = ($subject_id == $sel_subj) ? "class = \"selected\"" : "";
    $output .= "<li {$selected_subject}><a href=\"" . add_or_update_params($self, 'subject', $subject_id) . "\">{$subject["menu_name"]}</a></li>";
    $output .= '<ul class="pages">';
    $page_set = get_pages('id, menu_name', "subject_id = " . $subject_id);
    while ($page = mysqli_fetch_array($page_set, MYSQLI_ASSOC)) {
        $selected_page = ($page["id"] == $sel_page) ? "class = \"selected\"" : "";
        $output .= "<li {$selected_page}><a href=\"" . add_or_update_params($self, 'page', $page["id"]) . "\">{$page["menu_name"]}</a></li>";
    }
    $output .= "</ul>";
}
if ($self == 'content.php'){
$selected_subject = (isset($_GET['addSubject'])) ? "class = \"selected\"" : "";
$selected_page = (isset($_GET['addPage'])) ? "class = \"selected\"" : "";
$output .= "<br />";
$output .= "<ul class=\"subjects\">";
$output .= "<li {$selected_subject}><a href=\"" . add_or_update_params($self, 'addSubject', 0) . "\">+ New subject</a></li>";
$output .= "<li {$selected_page}><a {$selected_page} href=\"" . add_or_update_params($self, 'addPage', 0) . "\">+ New page</a></li>";
$output .= "</ul>";
}
echo $output;
?>