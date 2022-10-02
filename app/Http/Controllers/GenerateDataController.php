<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Tagihan;
use App\Model\RekapDptagihan;
use App\Model\RekapTagihan;

class GenerateDataController extends Controller
{
    public function nama_proyek($table) {

        if ($table == "payments") {
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

        } else if ($table == "rekap_dptagihans") {
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

        } else if ($table == "rekap_tagihans") {
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
        }

        return redirect()->back()->with("success", "Berhasil men-generate nama proyek!");
    }
}
