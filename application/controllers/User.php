<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public $upload;
    public $form_validation;

    public function __construct() {
        parent::__construct();
        // Pastikan user sudah login sebelum akses profile
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
    }

    public function profile() {
        $data['title'] = 'My Profile';
        // Ambil data user yang sedang login dari database
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // Load tampilan (Header, Sidebar, Konten, Footer)
         $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('layout/footer');
    }
   public function edit_profile() {
    $data['title'] = 'Edit Profile';
    $username = $this->session->userdata('username');
    $data['user'] = $this->db->get_where('user', ['username' => $username])->row_array();

    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');

    if ($this->form_validation->run() == false) {
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/edit_profile', $data);
        $this->load->view('layout/footer');
    } else {
        $nama = $this->input->post('nama');
        $no_wa = $this->input->post('no_wa');

        // Cek jika ada gambar yang diupload
        $upload_image = $_FILES['foto']['name'];

        if ($upload_image) {
            $config['upload_path']   = './assets/adminlte/img/profile/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = '2048';
            $config['file_name']     = 'profile-' . time();

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $old_image = $data['user']['foto'];
                
                // Hapus foto lama selain file bawaan
                if ($old_image != 'avatar4.png' && $old_image != 'default.png' && file_exists(FCPATH . 'assets/adminlte/img/profile/' . $old_image)) {
                    unlink(FCPATH . 'assets/adminlte/img/profile/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('foto', $new_image);
            }
        }

        $this->db->set('nama', $nama);
        $this->db->set('no_wa', $no_wa);
        $this->db->where('username', $username); // Pastikan username ini ada di session
        $this->db->update('user');
        // ... setelah perintah $this->db->update('user'); ...

        // Ambil data user terbaru dari database setelah diupdate
        $user_baru = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // Timpa data session yang lama dengan data yang baru (termasuk foto & nama)
        $this->session->set_userdata('foto', $user_baru['foto']);
        $this->session->set_userdata('nama', $user_baru['nama']);

        $this->session->set_flashdata('message', '<div class="alert alert-success">Profil Berhasil Diperbarui!</div>');
        redirect('user/profile');

        $this->session->set_flashdata('message', '<div class="alert alert-success">Profil Berhasil Diperbarui!</div>');
        redirect('user/profile');
    }
}
}