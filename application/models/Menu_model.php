<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    /* ======================
       MENU
    ====================== */

    // ambil semua menu
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    // tambah menu
    public function tambahMenu($data)
    {
        $this->db->insert('user_menu', $data);
    }

    // hapus menu
    public function hapusMenu($id)
    {
        // hapus submenu terkait
        $this->db->delete('user_sub_menu', ['id_menu' => $id]);

        // hapus akses menu
        $this->db->delete('user_access_menu', ['id_menu' => $id]);

        // hapus menu
        $this->db->delete('user_menu', ['id' => $id]);
    }

    /* ======================
       SUBMENU
    ====================== */

    // ambil semua submenu + nama menu
    public function getSubMenu()
    {
        $this->db->select('user_sub_menu.*, user_menu.menu');
        $this->db->from('user_sub_menu');
        $this->db->join('user_menu', 'user_menu.id = user_sub_menu.id_menu');
        return $this->db->get()->result_array();
    }

    // tambah submenu
    public function tambahSubMenu($data)
    {
        $this->db->insert('user_sub_menu', $data);
    }

    // hapus submenu
    public function hapusSubMenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
    }

    // toggle aktif / nonaktif submenu
    public function toggleSubMenu($id)
    {
        $submenu = $this->db
            ->get_where('user_sub_menu', ['id' => $id])
            ->row_array();

        $this->db->update(
            'user_sub_menu',
            ['is_active' => $submenu['is_active'] ? 0 : 1],
            ['id' => $id]
        );
    }
}