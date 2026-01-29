<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function insert_user($data)
    {
        return $this->db->insert('user', $data);
    }

    public function get_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->get('user')
            ->row();
    }

    public function save_otp($username, $otp)
    {
        return $this->db
            ->where('username', $username)
            ->update('user', ['otp' => $otp]);
    }

    public function verify_otp($username, $otp)
    {
        return $this->db
            ->where('username', $username)
            ->where('otp', $otp)
            ->get('user')
            ->row();
    }

    public function activate_user($username)
    {
        return $this->db
            ->where('username', $username)
            ->update('user', [
                'is_verified' => 1,
                'otp' => null
            ]);
    }
    public function getUserByEmail($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function getAllUsers()
    {
        $this->db->select('user.*, user_role.role');
        $this->db->from('user');
        $this->db->join('user_role', 'user_role.id = user.id_role');
        return $this->db->get()->result_array();
    }
    // Mengambil semua daftar role untuk dropdown di form
    public function getRoles()
    {
        return $this->db->get('user_role')->result_array();
    }

    // Fungsi Tambah User dari Admin
    public function insertUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function getUserById($id)
{
    // Ini buat ngambil 1 data user biar muncul di form edit
    return $this->db->get_where('user', ['id' => $id])->row_array();
}

    // Fungsi Update User
   public function updateUser($data, $id)
{
    // Cek dulu ID-nya ada isinya gak?
    if ($id) {
        $this->db->where('id', $id); // Ini "Kunci" biar nggak bambing semua!
        return $this->db->update('user', $data);
    }
    return false;
}
}
