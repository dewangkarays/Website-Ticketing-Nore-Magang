<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Tagihan;
use App\Model\RekapDptagihan;
use App\Model\RekapTagihan;
use App\Model\User;

class GenerateDataController extends Controller
{
    public function nama_proyek() {
        //Payments
        $payments = Payment::whereNull("nama_proyek")->get();
        foreach ($payments as $payment) {
            $namaProyeks = '';

            if ($payment->rekap_dptagihan_id) {
                $tagihans = Tagihan::where("rekap_dptagihan_id", $payment->rekap_dptagihan_id)->get();

                foreach ($tagihans as $tagihan) {
                    $namaProyeks = $namaProyeks.$tagihan->proyek->nama_proyek."<br>";
                }
            } else if ($payment->rekap_tagihan_id) {
                $tagihans = Tagihan::where("rekap_tagihan_id", $payment->rekap_tagihan_id)->get();

                foreach ($tagihans as $tagihan) {
                    $namaProyeks = $namaProyeks.$tagihan->proyek->nama_proyek."<br>";
                }
            }

            $payment->nama_proyek = $namaProyeks;
            $payment->update();
        }

        //Rekap DP
        $rekapdptagihans = RekapDptagihan::whereNull("nama_proyek")->get();
        foreach ($rekapdptagihans as $rekapdptagihan) {
            $namaProyeks = '';

            $tagihans = Tagihan::where("rekap_dptagihan_id", $rekapdptagihan->id)->get();

            foreach ($tagihans as $tagihan) {
                $namaProyeks = $namaProyeks.$tagihan->proyek->nama_proyek."<br>";
            }

            $rekapdptagihan->nama_proyek = $namaProyeks;
            $rekapdptagihan->update();
        }

        //Rekap Tagihan
        $rekaptagihans = RekapTagihan::whereNull("nama_proyek")->get();

        foreach ($rekaptagihans as $rekaptagihan) {
            $namaProyeks = '';

            $tagihans = Tagihan::where("rekap_tagihan_id", $rekaptagihan->id)->get();

            foreach ($tagihans as $tagihan) {
                $namaProyeks = $namaProyeks.$tagihan->proyek->nama_proyek."<br>";
            }

            $rekaptagihan->nama_proyek = $namaProyeks;
            $rekaptagihan->update();
        }

        return redirect()->back();
    }

    public function kuota_cuti() {
        $users = User::whereNull('jatah_cuti')->where('role', '<', '80')->get();

        foreach ($users as $user) {
            $user->jatah_cuti = 12;
            $user->sisa_cuti = 12;

            $user->update();
        }

        return redirect()->back();
    }

    public function lunas_dp_nol() {
        //Tagihans
        $tagihans = Tagihan::where('uang_muka', '0')->where('status_rekapdp', '<', '4')->get();
        foreach ($tagihans as $tagihan) {
            $tagihan->status_rekapdp = 4;
            $tagihan->update();
        }

        //RekapDp
        $rekapDptagihans = RekapDptagihan::where('total', '0')->where('status', '<', '4')->get();
        foreach ($rekapDptagihans as $rekapDptagihan) {
            $rekapDptagihan->status = 4;
            $rekapDptagihan->update();
        }

        return redirect()->back();
    }
}
