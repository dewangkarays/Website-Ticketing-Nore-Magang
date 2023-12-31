<?php

return [

    'bulan' => [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ],

	'role' => [
       	'1' => 'Super Admin',
        // '10' => 'Karyawan',
        '20' => 'Keuangan',
        '30' => 'Frontend',
        '35' => 'QA',
        '40' => 'Backend',
        '50' => 'Marketing',
        '60' => 'HRD',
        '95' => 'Klien',
    ],

    'jenis_proyek' => [
        '1' => 'Website',
        '2' => 'Iklan/Ads',
        '3' => 'Sistem Informasi',
        '4' => 'Mobile App',
        '6' => 'ULo',
        '7' => 'Hotely',
        '5' => 'Custom/Lainnya',
    ],

    'jenis_layanan' => [
        '1' => 'Nore',
        '2' => 'Mini',
        '3' => 'Berlangganan',
        '4' => 'Beli/Lepas',
    ],

    'kelas_layanan' => [
        '99' => 'Simple',
        '90' => 'Prioritas',
        '80' => 'Premium',
        '70' => 'Free',
        '74' => 'Pro',
        '78' => 'Custom',
    ],

    'status' => [
        '1' => 'Baru',
        '2' => 'Sedang Dikerjakan',
        '3' => 'Selesai',
    ],

    'payment' => [
        '0' => 'Belum Dikonfirmasi',
        '1' => 'Sudah Dikonfirmasi',
        '2' => 'Ditolak',
    ],

    'tagihan_status' => [
        '0' => 'Belum Terbayar',
        '1' => 'Terbayar Sebagian',
        '2' => 'Lunas',
    ],

    'rekap_status' => [
        '1' => 'Baru',
        '2' => 'Sudah Ditagih',
        '3' => 'Terbayar Sebagian',
        '4' => 'Lunas',
        '5' => 'Invalid',
    ],

    'pengeluaran' => [
        '1' => 'Aset',
        '2' => 'Non-Aset',
        // '3' => 'Tunjangan',
        '3' => 'Konsumsi',
        '4' => 'Bonus',
        '5' => 'Lain-lain',
        '6' => 'Modal',
        '7' => 'Gaji',
    ],

    'severity' => [
        '1' => 'Low',
        '2' => 'Normal',
        '3' => 'High',
    ],

    'kat_pengeluaran' => [
        '0' => 'Biaya Jasa',
        '1' => 'Perlengkapan',
        '2' => 'Biaya Admin dan Umum',
        '3' => 'Biaya Asuransi',
        '4' => 'Biaya Bunga',
        '5' => 'Biaya Gaji',
        '6' => 'Biaya Iklan',
        '7' => 'Biaya Komunikasi',
        '8' => 'Biaya Lain-lain',
        '9' => 'Biaya Listrik dan Air',
        '10' => 'Biaya Penyusutan',
        '11' => 'Biaya Pajak',
        '12' => 'Biaya Sewa',
        '13' => 'Biaya Transportasi',
        '14' => 'Aset',
    ],

    'j_pemasukan' => [
        '1' => 'Pemasukan Pembayaran Klien',
        '2' => 'Pemasukan Lain-lain'
    ],

    'jenis_lampiran' => [
        '1' => 'Lain-lain',
        '2' => 'Bukti Bayar Pajak',
        '3' => 'Kode Billing Pajak',
        '4' => 'Tampilan'
    ],

    'status_cuti' => [
        '1' => 'Diajukan',
        '2' => 'Diterima',
        '3' => 'Ditolak',
        '4' => 'Invalid',
    ],

    'divisi' => [
        '1' => 'BackEnd',
        '2' => 'FrontEnd',
        '3' => 'Marketing',
        '4' => 'Finance',
    ],

    'verifikasi_cuti' => [
        '1' => 'Belum diverifikasi',
        '2' => 'Terima',
        '3' => 'Tolak',
    ],

    'status_presensi' => [
        '1' => 'Hadir',
        '2' => 'Izin',
        '3' => 'Sakit',
        '4' => 'WFH',
    ],

    'status_user' => [
        '0'=>'Nonaktif',
        '1'=> 'Aktif',
        
    ],

    'status_klien' => [
        '1' => 'Visit',
        '2' => 'Kenal',
        '3' => 'Negosiasi',
        '4' => 'Deal',
        '5' => 'Pending',
        '6' => 'Bayar',
        '7' => 'Ended',
        '8' => 'Live',
    ],

    'source' => [
        '1' => 'Social Media',
        '2' => 'Google',
        '3' => 'Iklan',
        '4' => 'Walkin',
        '5' => 'Repeat/Teman Klien',
        '6' => 'Relasi',
        '7' => 'Referral',
        '8' => 'Visit',
    ],

    'prioritas' => [
        '-2'=> '-2',
        '-1'=> '-1',
        '0'=> '0',
        '1'=> '1',
        '2'=> '2',
        '3'=> '3',
    ],

    'status' => [
        '0' => 'Hold',
        '1' => 'Queue',
        '2' => 'In Progress',
        '3' => 'Done Test Server',
        '4' => 'Production',
    ],

    'kesulitan' => [
        '0' => 'Sangat Tinggi',
        '1' => 'Tinggi',
        '2' => 'Sedang',
        '3' => 'Rendah',
    ],

];
