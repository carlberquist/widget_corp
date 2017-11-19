<?php
//store all basic functions here.
function do_query($query)
{
    global $connection;
    if (stristr($query, 'SELECT')) {
        if ($result = mysqli_query($connection, $query)) {
            return $result;
        } else {
            echo ("Query not complete " . mysqli_error($connection));
            exit;
        }
    } else if (stristr($query, 'UPDATE') || stristr($query, 'INSERT')) {
        if (mysqli_query($connection, $query)) {
            return true;
        } else {
            echo ("Query not complete " . mysqli_error($connection));
            exit;
        }
    }
}
function get_all_subjects()
{
    $result_arr = array();
    $query = "SELECT id, menu_name, position FROM subjects ORDER BY position ASC";
    $result = do_query($query);
    while ($result_set = mysqli_fetch_assoc($result)) {
        $result_arr[] = $result_set;
    }
    return $result_arr;
}
function get_all_pages()
{
    $result_arr = array();
    $query = "SELECT id, subject_id, menu_name, position FROM pages ORDER BY id ASC";
    $result = do_query($query);
    while ($result_set = mysqli_fetch_assoc($result)) {
        $result_arr[] = $result_set;
    }
    return $result_arr;
}
function get_all_pages_for_subjects($subject_id)
{
    if (!empty($subject_id)) {
        $result_array = array();
        $query = "SELECT id, menu_name FROM pages WHERE subject_id = {$subject_id} ORDER BY position ASC";
        $result = do_query($query);
        while ($result_set = mysqli_fetch_array($result)) {
            $result_array[] = $result_set;
        }
        return $result_array;
    }
    return false;
}
function get_subject_by_id()
{
    if (isset($_GET['subject'])) {
        $subject_id = $_GET['subject'];
        $query = "SELECT menu_name, position, visible FROM subjects WHERE id = {$subject_id} LIMIT 1";
        $result_set = do_query($query);
        if ($subject = mysqli_fetch_array($result_set)) {
            return $subject;
        } else {
            echo "No subject found";
            exit;
        }
    }
    return false;
}
function get_page_by_id()
{
    if (isset($_GET['page'])) {
        $page_id = $_GET['page'];
        $subj_array = array();
        $query = "SELECT menu_name, subject_id, content, position, visible FROM pages WHERE id = {$page_id} LIMIT 1";
        $result_set = do_query($query);

        while ($subject = mysqli_fetch_array($result_set)) {
            $subj_array[] = $subject;
        }
        return $subj_array;
    }
    return false;
}
function insert_subject($menu_name, $position, $visible)
{
    update_max_subject_position($menu_name, $position, $page_id, TRUE);
    $query = "INSERT INTO pages(menu_name, position, visible,) VALUES ('{$menu_name}', $position, $visible)";
    if (do_query($query)) {
        return true;
    }
}
function insert_page($menu_name, $subject_id, $content, $position, $visible)
{
    update_max_page_position($subject_id, $position, $page_id, TRUE);
    $query = "INSERT INTO pages (menu_name, subject_id, content, position, visible) VALUES ('{$menu_name}', '{$subject_id}','{$content}', {$position}, {$visible})";
    if (do_query($query)) {
        return true;
    }
}
function update_subject($menu_name, $position, $visible, $page_id)
{
    update_max_subject_position($menu_name, $position, $page_id, FALSE);
    $query = "UPDATE subjects SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} WHERE id = {$page_id}";
    do_query($query);
    return true;
}
function update_page($menu_name, $content, $subject_id, $position, $visible, $page_id)
{
    update_max_page_position($subject_id, $position, $page_id, FALSE);
    $query = "UPDATE pages SET menu_name = '{$menu_name}', content = '{$content}', position = {$position}, visible = {$visible}, subject_id = {$subject_id} WHERE id = {$page_id}";
    if (do_query($query)) {
        return true;
    }

}
function update_max_page_position($subject_id, $position, $page_id, $insert = true)
{
    $max_position = "SELECT MAX(position) AS position FROM pages WHERE subject_id = {$subject_id}";
    $max_position_query = do_query($max_position);
    $max_position_result = mysqli_fetch_assoc($max_position_query);
    $max_position_result = $max_position_result['position'];

    $page = "SELECT position FROM pages WHERE subject_id = {$subject_id} AND position = {$position} AND id != {$page_id}";
    $page_position = do_query($page);

    if (mysqli_num_rows($page_position) > 0) {
        if ($insert === false) {
            $query_update = "UPDATE pages SET position = position +1 WHERE subject_id = {$subject_id} AND position >= {$position} AND id != {$page_id} AND position != {$max_position_result}";
        } else {
            $query_update = "UPDATE pages SET position = position +1 WHERE subject_id = {$subject_id} AND position >= {$position} AND id != {$page_id}";
        }
        do_query($query_update);
        if ($max_position_result == $position) {
            $query_update_max = "UPDATE pages SET position = position -1 WHERE subject_id = {$subject_id} AND id != {$page_id} AND position = {$max_position_result}";
            do_query($query_update_max);
        }
    }
}
function update_max_subject_position($subject_id, $position, $page_id, $insert = true)
{
    $max_position = "SELECT MAX(position) AS position FROM subjects";
    $max_position_query = do_query($max_position);
    $max_position_result = mysqli_fetch_assoc($max_position_query);
    $max_position_result = $max_position_result['position'];

    $page = "SELECT position FROM subjects WHERE position = {$position} AND id != {$page_id}";
    $page_position = do_query($page);

    if (mysqli_num_rows($page_position) > 0) {
        if ($insert === false) {
            $query_update = "UPDATE subjects SET position = position +1 WHERE position >= {$position} AND id != {$page_id} AND position != {$max_position_result}";
        } else {
            $query_update = "UPDATE subjects SET position = position +1 WHERE position >= {$position} AND id != {$page_id}";
        }
        do_query($query_update);
        if ($max_position_result == $position) {
            $query_update_max = "UPDATE subjects SET position = position -1 WHERE subject_id = {$subject_id} AND id != {$page_id} AND position = {$max_position_result}";
            do_query($query_update_max);
        }
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
function add_or_update_params($url, $key, $value = "")
{
    $a = parse_url($url);
    $query = $a['query'] ?? "";
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
        $result .= $a['path'];
    }
    if ($query) {
        $result .= '?' . $query;
    }
    return $result;
}
