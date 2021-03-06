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
            return mysqli_affected_rows($connection); //>0
        } else {
            echo ("Query not complete " . mysqli_error($connection));
            exit;
        }
    }
    return false;
}

/**
 *  Returns selected columns from pages 
 * 
 * @param string $field (optional) Table structure.  id, subject_id, menu_name, position, visible, content
 * @param string $where (optional) "column name = value"
 * @return object mysqli
 */
function get_pages($field = "*", $where = NULL)
{
    if ($where) {
        $query = "SELECT {$field} FROM pages WHERE {$where} ORDER BY subject_id, position ASC";
    } else {
        $query = "SELECT {$field} FROM pages ORDER BY subject_id, position ASC";
    }
    $result = do_query($query);
    return $result;
}
/**
 * @param string $field = id, menu_name, position, visible
 * @return object mysqli
 */
function get_subject($field = '*', $where = NULL)
{
    if ($where) {
        $query = "SELECT {$field} FROM subjects WHERE {$where} ORDER BY position ASC";
    } else {
        $query = "SELECT {$field} FROM subjects ORDER BY position ASC";
    }
    $result = do_query($query);
    return $result;
}
function insert_subject($menu_name, $position, $visible)
{
    update_max_subject_position($menu_name, $position);
    $query = "INSERT INTO pages(menu_name, position, visible,) VALUES ('{$menu_name}', $position, $visible)";
    if (do_query($query)) {
        return true;
    }
}
function insert_page($menu_name, $subject_id, $content, $position, $visible)
{
    update_max_page_position($subject_id, $position);
    $query = "INSERT INTO pages (menu_name, subject_id, content, position, visible) VALUES ('{$menu_name}', '{$subject_id}','{$content}', {$position}, {$visible})";
    if (do_query($query)) {
        return true;
    }
}
function update_subject($menu_name, $position, $visible, $page_id)
{
    update_max_subject_position($menu_name, $position, $page_id);
    $query = "UPDATE subjects SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} WHERE id = {$page_id}";
    do_query($query);
    return true;
}
function update_page($menu_name, $content, $subject_id, $position, $visible, $page_id)
{
    update_max_page_position($subject_id, $position, $page_id);
    $query = "UPDATE pages SET menu_name = '{$menu_name}', content = '{$content}', position = {$position}, visible = {$visible}, subject_id = {$subject_id} WHERE id = {$page_id}";
    if (do_query($query)) {
        return true;
    }

}
function update_max_page_position($subject_id, $position, $page_id = NULL)
{
    $max_position = "SELECT MAX(position) AS position FROM pages WHERE subject_id = {$subject_id}";
    $max_position_query = do_query($max_position);
    $max_position_result = mysqli_fetch_array($max_position_query, MYSQLI_ASSOC);
    $max_position_result = $max_position_result['position'];

    $page = "SELECT position FROM pages WHERE subject_id = {$subject_id} AND position = {$position}";
    $page_position = do_query($page);

    if (mysqli_num_rows($page_position) > 0) {
        if ($page_id) {
            $query_update = "UPDATE pages SET position = position +1 WHERE subject_id = {$subject_id} AND position >= {$position} AND id != {$page_id} AND position != {$max_position_result}";
        } else {
            $query_update = "UPDATE pages SET position = position +1 WHERE subject_id = {$subject_id} AND position >= {$position}";
        }
        do_query($query_update);
        if ($max_position_result == $position && $page_id !== NULL) {
            $query_update_max = "UPDATE pages SET position = position -1 WHERE subject_id = {$subject_id} AND id != {$page_id} AND position = {$max_position_result}";
            do_query($query_update_max);
        }
    }
}
function update_max_subject_position($position, $subject_id = NULL)
{
    $max_position = "SELECT MAX(position) AS position FROM subjects";
    $max_position_query = do_query($max_position);
    $max_position_result = mysqli_fetch_array($max_position_query, MYSQLI_ASSOC);
    $max_position_result = $max_position_result['position'];

    $page = "SELECT position FROM subjects WHERE position = {$position} AND id != {$subject_id}";
    $subject_position = do_query($page);

    if (mysqli_num_rows($subject_position) > 0) {
        if ($subject_id) {
            $query_update = "UPDATE subjects SET position = position +1 WHERE position >= {$position} AND id != {$subject_id} AND position != {$max_position_result}";
        } else {
            $query_update = "UPDATE subjects SET position = position +1 WHERE position >= {$position}";
        }
        do_query($query_update);
        if ($max_position_result == $position && $subject_id !== NULL) {
            $query_update_max = "UPDATE subjects SET position = position -1 WHERE id != {$subject_id} AND position = {$max_position_result}";
            do_query($query_update_max);
        }
    }
}
function check_required_fields($required_fields)
{
    $fields = "";
    if (!is_array($required_fields)) {
        return false;
    }
    foreach ($required_fields as $value) {
        if (!isset($_POST[$value]) || empty($_POST[$value])) {
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
    if (!is_array($required_fields)) {
        return false;
    }
    $fields = "";
    foreach ($required_fields as $value) {
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
    if (isset($a['scheme'])) {
        $result .= $a['scheme'] . ':';
    }
    if (isset($a['host'])) {
        $result .= '//' . $a['host'];
    }
    if (isset($a['path'])) {
        $result .= $a['path'];
    }
    if ($query) {
        $result .= '?' . $query;
    }
    return $result;
}
