<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public $M_keuangan;

    public function __construct()
    {
        parent::__construct();

        // 🔐 PROTEKSI LOGIN
        // Pastikan session yang dicek konsisten dengan Auth.php
        if (!$this->session->userdata('username')) { 
            redirect('auth');
        }
        $this->load->model('M_keuangan');
    }

   public function index()
{
    // 1. Sesuaikan dengan Auth.php (user_id)
    $id_user = $this->session->userdata('user_id');

    // 2. Ambil data Ringkasan dari Model
    $data['total_saldo'] = $this->M_keuangan->getTotalSaldoSeluruhnya();
    
    // Gunakan fungsi model (kita akan buat di bawah) agar lebih rapi
    $data['total_pemasukan'] = $this->M_keuangan->getPemasukanBulanIni();
    $data['total_pengeluaran'] = $this->M_keuangan->getPengeluaranBulanIni();

    $data['list_dompet'] = $this->M_keuangan->getSummaryPerDompet();
    $data['title'] = 'Dashboard';

    // 3. Data untuk Statistik (Grafik)
    // Kita ambil data transaksi 7 hari terakhir atau per bulan
    $data['grafik'] = $this->M_keuangan->getDataGrafik($id_user);
    $this->load->view('layout/header', $data);
    $this->load->view('layout/sidebar', $data);
    $this->load->view('dashboard', $data); 
}
}