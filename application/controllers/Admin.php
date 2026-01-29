<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public $User_model;
    public $form_validation;
    public function __construct()
    {
        parent::__construct();
        // Cek login
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
        // Cek admin (Role ID 1)
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/blocked');
        }

        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    // ======================
    // 1. DASHBOARD ADMIN
    // ======================
   public function index()
{
    $data['title'] = 'Dashboard Admin';
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    
    // 1. Statistik Dasar (User & Role)
    $data['total_user'] = $this->db->count_all('user');
    $data['total_role'] = $this->db->count_all('user_role');

    // 2. Total Nominal Transaksi Global (Semua User)
    // Mengambil jumlah total uang yang ada di sistem
    // Ambil Total dari kolom 'jumlah' (Seluruh User)
$this->db->select_sum('jumlah'); // Sesuaikan dari 'nominal' ke 'jumlah'
$query_jumlah = $this->db->get('transaksi')->row();
$data['total_nominal'] = $query_jumlah->jumlah ?? 0;

    // 3. Jumlah Transaksi Hari Ini
    // Menghitung berapa kali user input data hari ini
    $this->db->where('DATE(created_at)', date('Y-m-d')); // Sesuaikan field date_created
    $data['transaksi_hari_ini'] = $this->db->count_all_results('transaksi');

    // 4. List 5 User Terbaru
    $this->db->order_by('id', 'DESC');
    $this->db->limit(5);
    $data['recent_users'] = $this->db->get('user')->result_array();

    // Hitung user yang is_verified-nya = 1 (Aktif)
$this->db->where('is_verified', 1);
$data['user_aktif'] = $this->db->count_all_results('user');

// Total user (Sudah ada di kodinganmu sebelumnya)
$data['total_user'] = $this->db->count_all('user');

// Hitung persentase untuk panjang bar (biar bar-nya gak kepenuhan)
if ($data['total_user'] > 0) {
    $data['persen_aktif'] = ($data['user_aktif'] / $data['total_user']) * 100;
} else {
    $data['persen_aktif'] = 0;
}

    $this->load->view('layout/navbar', $data);
    $this->load->view('layout/header', $data);
    $this->load->view('layout/sidebar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('layout/footer');
}
    // ======================
    // 2. USER MANAGEMENT
    // ======================
    public function users()
    {
        $data['title'] = 'Data User';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['users'] = $this->User_model->getAllUsers();

        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('layout/footer');
    }

    public function addUser()
    {
        $data['title'] = 'Tambah User';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['roles'] = $this->User_model->getRoles();

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('no_wa', 'No WhatsApp', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('id_role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/navbar', $data);
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('admin/add_user', $data);
            $this->load->view('layout/footer');
        } else {
            // Data untuk diinsert
            $insert_data = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'no_wa' => $this->input->post('no_wa'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'id_role' => $this->input->post('id_role'),
                'is_verified' => 1
            ];
            $this->db->insert('user', $insert_data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">User berhasil ditambahkan! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> </div>');
            redirect('admin/users');
        }
    }

    public function editUser($id)
{
    $data['title'] = 'Edit User';
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $data['roles'] = $this->User_model->getRoles();
    
    // Ambil data user lama untuk ditampilkan di form
    $data['user_to_edit'] = $this->User_model->getUserById($id);

    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('no_wa', 'No WhatsApp', 'required');
    $this->form_validation->set_rules('id_role', 'Role', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/edit_user', $data);
        $this->load->view('layout/footer');
    } else {
        // Ambil ID dari input hidden yang ada di view
        $id_user = $this->input->post('id'); 

        $update_data = [
            'nama'    => $this->input->post('nama'),
            'no_wa'   => $this->input->post('no_wa'),
            'id_role' => $this->input->post('id_role')
        ];

        // Jalankan update HANYA untuk ID tersebut
        $this->User_model->updateUser($update_data, $id_user);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">User berhasil diupdate!<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
        redirect('admin/users');
    }
}

    public function deleteUser($id)
    {
        $this->db->delete('user', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">User berhasil dihapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button></div>');
        redirect('admin/users');
    }

    // ======================
    // 3. ROLE MANAGEMENT
    // ======================
    public function role() {
    $data['title'] = 'Role Management';
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $data['role'] = $this->db->get('user_role')->result_array();

    // Tambahkan logika validasi form di sini
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() == false) {
        // Jika tidak ada input atau validasi gagal, tampilkan halaman seperti biasa
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('layout/footer');
    } else {
        // Jika form disubmit, simpan ke database
        $this->db->insert('user_role', ['role' => $this->input->post('role')]);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Role baru berhasil ditambahkan! <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
        redirect('admin/role');
    }
}
public function editRole()
{
    $this->form_validation->set_rules('role', 'Role', 'required');

    if ($this->form_validation->run() != false) {
        $id = $this->input->post('id');
        $data = ['role' => $this->input->post('role')];
        
        $this->db->where('id', $id);
        $this->db->update('user_role', $data);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Role berhasil diubah! <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
    }
    redirect('admin/role');
}
public function deleteRole($id)
{
    // Hapus data berdasarkan ID yang dikirim
    $this->db->delete('user_role', ['id' => $id]);
    
    $this->session->set_flashdata('message', '<div class="alert alert-success">Role berhasil dihapus! <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
    redirect('admin/role');
}

    public function roleAccess($id_role) {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $id_role])->row_array();
        $data['all_menu'] = $this->db->get('user_menu')->result_array();
        
        $this->load->view('layout/navbar', $data);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('layout/footer');
    }

    public function changeAccess() {
        $menu_id = $this->input->post('menuId');
        $id_role = $this->input->post('roleId');

        $data = [
            'id_role' => $id_role,
            'id_menu' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success">Akses berhasil diubah! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button></div>');
    }
    
}