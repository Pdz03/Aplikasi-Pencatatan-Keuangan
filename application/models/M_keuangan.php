<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keuangan extends CI_Model {
    private function _getUserId() {
    return $this->session->userdata('user_id');
}
    public function getDompetById($id) {
        // Mengambil data nama bank/dompet dari tabel sub menu
        return $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();
    }

   public function getTransaksiByDompet($id_dompet) {
    $this->db->select('transaksi.*, user_sub_menu.title as nama_dompet');
    $this->db->from('transaksi');
    $this->db->join('user_sub_menu', 'transaksi.id_dompet = user_sub_menu.id');
    $this->db->where('transaksi.id_dompet', $id_dompet);
    
    // TAMBAHKAN INI: Agar user lain tidak bisa melihat transaksi dompet ini
    $this->db->where('transaksi.id_user', $this->_getUserId()); 
    
    $this->db->order_by('transaksi.tanggal', 'DESC');
    return $this->db->get()->result_array();
}

public function hitungSaldo($id_dompet) {
    // TAMBAHKAN WHERE: Agar saldo yang diambil adalah milik user yang login
    $this->db->where('id_user', $this->_getUserId());
    $query = $this->db->get_where('saldo_dompet', ['id_dompet' => $id_dompet])->row();
    return ($query) ? $query->saldo_sekarang : 0;
}
public function transfer_dana($id_asal, $id_tujuan, $jumlah, $id_user) {
        $this->db->trans_start();
        $tgl = date('Y-m-d H:i:s');

        // 1. SISI PENGIRIM: Catat pengeluaran & potong saldo
        $this->db->insert('transaksi', [
            'id_user'    => $id_user,
            'id_dompet'  => $id_asal,
            'tipe'       => 'pengeluaran',
            'jumlah'     => $jumlah,
            'keterangan' => 'Transfer ke rekening lain',
            'tanggal'    => date('Y-m-d'),
            'created_at' => $tgl
        ]);
        $this->db->where('id_dompet', $id_asal);
        $this->db->where('id_user', $id_user); // TAMBAHKAN INI
        $this->db->set('saldo_sekarang', 'saldo_sekarang - ' . (int)$jumlah, FALSE);
        $this->db->update('saldo_dompet');

        // 2. SISI PENERIMA: Catat pemasukan & tambah saldo
        $this->db->insert('transaksi', [
            'id_user'    => $id_user,
            'id_dompet'  => $id_tujuan,
            'tipe'       => 'pemasukan',
            'jumlah'     => $jumlah,
            'keterangan' => 'Terima transfer',
            'tanggal'    => date('Y-m-d'),
            'created_at' => $tgl
        ]);
        $this->db->where('id_dompet', $id_tujuan);
        $this->db->set('saldo_sekarang', 'saldo_sekarang + ' . (int)$jumlah, FALSE);
        $this->db->update('saldo_dompet');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
        public function getPemasukanBulanIni($id_dompet = null) {
    $this->db->select_sum('jumlah');
    $this->db->where('id_user', $this->_getUserId());
    $this->db->where('tipe', 'pemasukan');
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));

    // Jika id_dompet dikirim, filter berdasarkan dompet tersebut
    if ($id_dompet !== null) {
        $this->db->where('id_dompet', $id_dompet);
    }

    $query = $this->db->get('transaksi')->row();
    return $query->jumlah ?? 0;
}

public function getPengeluaranBulanIni($id_dompet = null) {
    $this->db->select_sum('jumlah');
    $this->db->where('id_user', $this->_getUserId());
    $this->db->where('tipe', 'pengeluaran');
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));

    // Jika id_dompet dikirim, filter berdasarkan dompet tersebut
    if ($id_dompet !== null) {
        $this->db->where('id_dompet', $id_dompet);
    }

    $query = $this->db->get('transaksi')->row();
    return $query->jumlah ?? 0;
}
    public function getTotalSaldoSeluruhnya() {
    $this->db->select_sum('saldo_sekarang');
    $this->db->where('id_user', $this->_getUserId());
    $query = $this->db->get('saldo_dompet')->row();
    return $query->saldo_sekarang ?? 0;
}

public function getSummaryPerDompet() {
    $id_user = $this->_getUserId(); // Gunakan fungsi private yang sudah diperbaiki

    // Jika user tidak ditemukan, return array kosong agar tidak error
    if (!$id_user) {
        return [];
    }

    $this->db->select('usm.id, usm.title as nama_dompet, sd.saldo_sekarang as saldo');
    $this->db->from('user_sub_menu usm');
    
    // JOIN harus mengunci id_user agar saldo milik id_user 1 tidak ikut tampil di id_user 20
    $this->db->join('saldo_dompet sd', 'usm.id = sd.id_dompet AND sd.id_user = ' . (int)$id_user, 'left');
    
    $this->db->where('usm.is_active', 1);
    
    // Opsional: Jika ingin tetap menampilkan nama dompet walau saldo 0, hapus baris di bawah ini
    $this->db->where('sd.saldo_sekarang >', 0);
    
    return $this->db->get()->result_array();
}
public function getDataGrafik($id_user) {
    // Mengambil total pemasukan dan pengeluaran per tipe untuk grafik
    $this->db->select('tipe, SUM(jumlah) as total');
    $this->db->where('id_user', $id_user);
    $this->db->where('MONTH(tanggal)', date('m'));
    $this->db->where('YEAR(tanggal)', date('Y'));
    $this->db->group_by('tipe');
    return $this->db->get('transaksi')->result_array();
}

}