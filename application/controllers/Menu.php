<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public $form_validation;
    public $menu;
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        //is_admin(); // hanya admin

        $this->load->model('Menu_model', 'menu');
    }

    /* ======================
       MENU
    ====================== */

    // tampilkan menu
   public function index()
{
    $data['title'] = 'Menu Management';
    // AMBIL DATA USER DARI SESSION
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    
    // Gunakan model yang sudah kamu buat
    $data['menu'] = $this->menu->getMenu();
    
    $this->load->view('layout/navbar', $data);
    $this->load->view('layout/header', $data);
    $this->load->view('layout/sidebar', $data); // Data $user diperlukan di sini
    $this->load->view('menu/index', $data);
    $this->load->view('layout/footer');
}

    // tambah menu
    public function tambah()
    {
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Menu';
            
            $this->load->view('layout/navbar', $data);
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('menu/tambah', $data);
            $this->load->view('layout/footer');
        } else {
            $this->menu->tambahMenu([
                'menu' => $this->input->post('menu', true)
            ]);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Menu berhasil ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>'
            );
            redirect('menu');
        }
    }

    public function edit()
{
    $id   = $this->input->post('id');
    $menu = $this->input->post('menu', true);

    $this->db->update(
        'user_menu',
        ['menu' => $menu],
        ['id' => $id]
    );

    $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success">Menu berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>'
    );
    redirect('menu');
}

    // hapus menu
    public function hapus($id)
    {
        // hapus relasi submenu & akses
        $this->db->delete('user_sub_menu', ['id_menu' => $id]);
        $this->db->delete('user_access_menu', ['id_menu' => $id]);
        $this->db->delete('user_menu', ['id' => $id]);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Menu berhasil dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>'
        );
        redirect('menu');
    }

    /* ======================
       SUBMENU
    ====================== */

    // tampilkan submenu
    public function submenu()
{
    $data['title'] = 'Submenu Management';
    // Ambil data user untuk sidebar
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    // Load data submenu menggunakan JOIN agar muncul nama Menu Parent-nya
    $this->db->select('user_sub_menu.*, user_menu.menu');
    $this->db->from('user_sub_menu');
    $this->db->join('user_menu', 'user_menu.id = user_sub_menu.id_menu');
    $data['submenu'] = $this->db->get()->result_array();

    // Ambil data menu untuk dropdown di Modal Tambah
    $data['menu'] = $this->db->get('user_menu')->result_array();
    
    $this->load->view('layout/navbar', $data);
    $this->load->view('layout/header', $data);
    $this->load->view('layout/sidebar', $data);
    $this->load->view('menu/submenu', $data); // Pastikan nama file ini sesuai
    $this->load->view('layout/footer');
}

    // tambah submenu
    public function tambah_submenu()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('id_menu', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Submenu';
            $data['menu']  = $this->db->get('user_menu')->result_array();

            $this->load->view('layout/navbar', $data);
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('submenu/tambah', $data);
            $this->load->view('layout/footer');
        } else {
            $this->db->insert('user_sub_menu', [
                'title'     => $this->input->post('title', true),
                'id_menu'   => $this->input->post('id_menu'),
                'url'       => $this->input->post('url', true),
                'icon'      => $this->input->post('icon', true),
                'is_active' => 1
            ]);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success">Submenu berhasil ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>'
            );
            redirect('menu/submenu');
        }
    }
    public function edit_submenu()
{
    $id = $this->input->post('id');
    $data = [
        'title'   => $this->input->post('title', true),
        'id_menu' => $this->input->post('id_menu'),
        'url'     => $this->input->post('url', true),
        'icon'    => $this->input->post('icon', true)
    ];

    $this->db->update('user_sub_menu', $data, ['id' => $id]);
    $this->session->set_flashdata('message', '<div class="alert alert-success">Submenu berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>');
    redirect('menu/submenu');
}
    // hapus submenu
    public function hapus_submenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">Submenu berhasil dihapus <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>'
        );
        redirect('menu/submenu');
    }

    // aktif / nonaktif submenu
    public function toggle_submenu($id)
    {
        $submenu = $this->db
            ->get_where('user_sub_menu', ['id' => $id])
            ->row_array();

        $this->db->update(
            'user_sub_menu',
            ['is_active' => $submenu['is_active'] ? 0 : 1],
            ['id' => $id]
        );

        redirect('menu/submenu');
    }
}