<?php
//store all basic functions here.
function do_query($query)
{
    global $connection;
    if ($result = mysqli_query($connection, $query)) {
        return $result;
    } else {
        echo ("Query not complete" . mysqli_error($connection));
        exit;
    }
}
function get_all_subjects()
{
    $query = "SELECT id, menu_name FROM subjects ORDER BY position ASC";
    $result = do_query($query);
    return $result;
}
function get_all_pages_for_subjects($subject_id)
{
    if (!empty($subject_id)){
    $query = "SELECT id, menu_name FROM pages WHERE subject_id = {$subject_id} ORDER BY position ASC";
    $result = do_query($query);
    return($result);
    }
    return false;
}
function get_subject_by_id()
{
    if (array_key_exists('subject', $_GET)) {
        $subject_id = $_GET['subject'];
        $query = "SELECT menu_name, position, visible FROM subjects WHERE id = {$subject_id} LIMIT 1";
        $result_set = do_query($query);
        if ($subject = mysqli_fetch_array($result_set)) {
            return $subject;
        } else {
            return "No subject found";
        }
    }
    return false;
}
function get_page_by_id()
{
    if (array_key_exists('page', $_GET)) {
        $page_id = $_GET['page'];
        $query = "SELECT menu_name, content, position, visible FROM pages WHERE id = {$page_id} LIMIT 1";
        $result_set = do_query($query);
        if ($subject = mysqli_fetch_array($result_set)) {
            return $subject;
        } else {
            return "No page found";
        }
    }
    return false;
}
function array_exists($key, $array = null, $defaultValue = "")
{
    if (is_array($array) && array_key_exists($key, $array)) {
        $value = $array[$key];
        return isset($value) ? $value : $defaultValue;
    }
    return $defaultValue;
}
function redirect_to($location = null)
{
    if ($location !== null) {
        header($location);
        exit;
    }
}
function check_required_fields($required_fields)
{
    $fields = "";
    foreach ($required_fields as $key => $value) {
        if (!array_key_exists($value, $_POST) || empty($_POST[$value])) {
            if (empty($fields)) {
                $fields = $value;
            } else {
                $fields .= ", {$value}";
            }
        }
    }
    if (!empty($fields)) {
        return $fields;
    } else {
        return false;
    }
}
function check_field_length($required_fields, $field_legnth)
{
    if ($fields = check_required_fields($required_fields)) {
        return $fields;
    }
    $fields = "";
    foreach ($required_fields as $key => $value) {
        if (strlen(trim($value)) > $field_legnth) {
            if (empty($fields)) {
                $fields = $value;
            } else {
                $fields .= ", {$value}";
            }
        }
    }
    if (!empty($fields)) {
        return $fields;
    } else {
        return false;
    }
}
function add_or_update_params($url, $key, $value)
{
    $a = parse_url($url);
    $query = array_exists('query', $a);
    parse_str($query, $params);
    $params[$key] = $value;
    $query = http_build_query($params);
    $result = '';
    if (array_key_exists('scheme', $a)) {
        $result .= $a['scheme'] . ':';
    }
    if (array_key_exists('host', $a)) {
        $result .= '//' . $a['host'];
    }
    if (array_key_exists('path', $a)) {
        $result .=  $a['path'];
    }
    if ($query) {
        $result .=  '?' . $query;
    }
    return $result;
}
