<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public $User_model;
    
    public function __construct()
{
    parent::__construct();
    $this->load->model('User_model');
}


    public function login()
    {
        $this->load->view('auth/login');
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth/login');
        }

        // cek password
        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('auth/login');
        }

        // cek verifikasi OTP
        if ($user->is_verified != 1) {
            $this->session->set_flashdata('error', 'Akun belum diverifikasi OTP');
            redirect('auth/login');
        }

        // set session login
        $this->session->set_userdata([
            'login'    => true,
            'user_id'  => $user->id,
            'username' => $user->username,
            'nama'     => $user->nama,
            'foto'     => $user->foto,
            'id_role'     => $user->id_role
        ]);

        // ... kode set session kamu sebelumnya ...

        // 🔥 LOGIKA PENGALIHAN BERDASARKAN ROLE
        if ($user->id_role == 1) {
            // Jika Admin, arahkan ke dashboard khusus admin
            redirect('admin/index'); 
        } else {
            // Jika User biasa, tetap ke dashboard user
            redirect('dashboard');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function proses_register()
{
    $otp = rand(100000, 999999);
    $no_wa  = $this->input->post('no_wa');
    //$this->session->set_userdata('otp', $otp);
    $data = [
        'nama'       => $this->input->post('nama'),
        'username'   => $this->input->post('username'),
        'no_wa'         => $this->input->post('no_wa'),
        'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'otp'        => $otp,
        'id_role'     => '2',
        'is_verified'=> 0
    ];

    $this->User_model->insert_user($data);

     // 🔥 KIRIM KE NODE JS
    $payload = json_encode([
        'number'  => $no_wa,
        'message' => "Kode OTP kamu: $otp"
    ]);

    $ch = curl_init('http://localhost:3000/send');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_exec($ch);
    curl_close($ch);

    redirect('auth/otp/'.$data['username']);
    
}


   public function otp($username)
{
    $data['username'] = $username;
    $this->load->view('auth/otp', $data);
}

public function verifikasi_otp()
{
    $username = $this->input->post('username');
    $otp      = $this->input->post('otp');

    $user = $this->User_model->verify_otp($username, $otp);

    if ($user) {
        $this->User_model->activate_user($username);
        $this->session->set_flashdata('success', 'Akun berhasil diverifikasi, silakan login');
        redirect('auth/login');
    } else {
        $this->session->set_flashdata('error', 'OTP salah atau kadaluarsa');
        redirect('auth/otp/'.$username);
    }
}


}
