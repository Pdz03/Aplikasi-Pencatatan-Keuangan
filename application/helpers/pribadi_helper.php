<?php

function check_access($role_id, $menu_id)
{
    // Mengambil instance CodeIgniter agar bisa akses database di dalam fungsi biasa
    $ci = get_instance();

    $ci->db->where('id_role', $role_id);
    $ci->db->where('id_menu', $menu_id);
    $result = $ci->db->get('user_access_menu');

    // Jika data ditemukan di tabel user_access_menu, berikan atribut checked
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}