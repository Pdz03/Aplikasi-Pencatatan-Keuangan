<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 */
class Rekening extends CI_Controller {
    public $M_keuangan;

    public function __construct() {
        parent::__construct();
        // Proteksi session agar tidak bisa diakses tanpa login
        if (!$this->session->userdata('nama')) {
            redirect('auth');
        }
        $this->load->model('M_keuangan');
    }

    public function detail($id) {
        $data['dompet'] = $this->M_keuangan->getDompetById($id);
        $data['transaksi'] = $this->M_keuangan->getTransaksiByDompet($id);
        $data['saldo'] = $this->M_keuangan->hitungSaldo($id);

        $data['total_masuk'] = $this->M_keuangan->getPemasukanBulanIni($id);
        $data['total_keluar'] = $this->M_keuangan->getPengeluaranBulanIni($id);
        // Load hanya bagian konten
        $this->load->view('rekening/detail_rekening', $data);
    }

    public function simpanSaldo() {
        $id_user = $this->session->userdata('user_id');
        if (!$id_user) {
            die("Error: Session ID User tidak ditemukan. Silakan logout dan login kembali.");
        }

        $id_dompet = $this->input->post('id_dompet');
        $jumlah = $this->input->post('jumlah');

        $data_transaksi = [
            'id_user'     => $id_user,
            'id_dompet'   => $id_dompet,
            'tipe'        => 'pemasukan',
            'jumlah'      => $jumlah,
            'tanggal'     => $this->input->post('tanggal'),
            'keterangan'  => 'Saldo Awal',
            'created_at'  => date('Y-m-d H:i:s')
        ];

        // 1. Insert ke tabel transaksi
        $this->db->insert('transaksi', $data_transaksi);

        // 2. PERBAIKAN: Cek saldo berdasarkan id_dompet DAN id_user
        $cek_saldo = $this->db->get_where('saldo_dompet', [
            'id_dompet' => $id_dompet, 
            'id_user' => $id_user
        ])->row();

        if ($cek_saldo) {
            $saldo_baru = $cek_saldo->saldo_sekarang + $jumlah;
            $this->db->where(['id_dompet' => $id_dompet, 'id_user' => $id_user]);
            $this->db->update('saldo_dompet', [
                'saldo_sekarang' => $saldo_baru,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
        } else {
            // PERBAIKAN: Jika belum ada, buat baris baru KHUSUS user ini
            $this->db->insert('saldo_dompet', [
                'id_user'        => $id_user,
                'id_dompet'      => $id_dompet,
                'saldo_sekarang' => $jumlah,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
        }

       // TAMBAHKAN BARIS INI
        $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Saldo Berhasil di input.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        ');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function prosesTransaksi() {
    // Mencoba mengambil ID dari berbagai kemungkinan kunci session
    $id_user = $this->session->userdata('id_user') ?: $this->session->userdata('id') ?: $this->session->userdata('user_id');

    if (!$id_user) {
        // Jika masih kosong, jangan langsung redirect ke 'auth' yang mungkin salah rutenya
        // Kita tampilkan pesan error yang lebih jelas di halaman yang sama
        $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal: ID User tidak ditemukan dalam sesi. Silakan Login ulang.</div>');
        redirect($_SERVER['HTTP_REFERER']); 
        return;
    }
    
    // ... sisa kode simpan transaksi ...

        $id_dompet = $this->input->post('id_dompet');
        $tipe = $this->input->post('tipe');
        $jumlah = $this->input->post('jumlah');

        $data_transaksi = [
            'id_user'     => $id_user,
            'id_dompet'   => $id_dompet,
            'tipe'        => $tipe,
            'jumlah'      => $jumlah,
            'tanggal'     => $this->input->post('tanggal'),
            'keterangan'  => $this->input->post('keterangan'),
            'created_at'  => date('Y-m-d H:i:s')
        ];
        $this->db->insert('transaksi', $data_transaksi);

        // PERBAIKAN: Update saldo HANYA milik user yang login
        $cek = $this->db->get_where('saldo_dompet', [
            'id_dompet' => $id_dompet, 
            'id_user' => $id_user
        ])->row();

        if ($cek) {
            $saldo_baru = ($tipe == 'pemasukan') ? $cek->saldo_sekarang + $jumlah : $cek->saldo_sekarang - $jumlah;

            $this->db->where(['id_dompet' => $id_dompet, 'id_user' => $id_user]);
            $this->db->update('saldo_dompet', [
                'saldo_sekarang' => $saldo_baru,
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
        }

        $this->session->set_flashdata('message', 'Transaksi berhasil dicatat!');
        redirect($_SERVER['HTTP_REFERER']);
    }
public function prosesTransfer() {
    // Ambil session user
    $id_user = $this->session->userdata('id_user') ?: $this->session->userdata('id') ?: $this->session->userdata('user_id');

    if (!$id_user) {
        die("Sesi berakhir, silakan login kembali.");
    }

    $id_asal   = $this->input->post('id_asal');
    $id_tujuan = $this->input->post('id_tujuan');
    $jumlah    = $this->input->post('jumlah');

    // Validasi saldo cukup (Opsional tapi disarankan)
    $saldo_asal = $this->M_keuangan->hitungSaldo($id_asal);
    if ($saldo_asal < $jumlah) {
        $this->session->set_flashdata('error', 'Saldo tidak mencukupi untuk transfer!');
        redirect($_SERVER['HTTP_REFERER']);
        return;
    }

    // Eksekusi transfer melalui model
    $proses = $this->M_keuangan->transfer_dana($id_asal, $id_tujuan, $jumlah, $id_user);

    if ($proses) {
        $this->session->set_flashdata('message', 'Transfer Dana Berhasil!');
    } else {
        $this->session->set_flashdata('error', 'Gagal memproses transfer.');
    }

    redirect($_SERVER['HTTP_REFERER']);
}

}