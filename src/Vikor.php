<?php

namespace ajn\dss_library;

class Vikor
{
    protected $limit;
    public $kriteria;
    public $alternatif;
    public $matriksKeputusan;
    public $matriksNormalisasi;



    public $normalisasibobot;

    public function __construct($kriteria, $alternatif, $limit)
    {
        $minMax = [];
        foreach ($kriteria as $k) {
            $kode = $k['kode'];
            $type = $k['type'];

            $values = [];
            foreach ($alternatif as $alt) {
                foreach ($alt['nilai'] as $n) {
                    if ($n['kode'] == $kode) {
                        $values[] = $n['bobot'];
                        break;
                    }
                }
            }

            $minMax[$kode] = [
                'min' => min($values),
                'max' => max($values),
                'type' => $type
            ];
        }

        // Normalisasi
        $normalisasi = [];
        foreach ($alternatif as $alt) {
            $nama = $alt['nama'];
            $normalisasi[$nama] = [];

            foreach ($alt['nilai'] as $n) {
                $kode = $n['kode'];
                $nilai = $n['bobot'];
                $type = $minMax[$kode]['type'];
                $min = $minMax[$kode]['min'];
                $max = $minMax[$kode]['max'];

                if ($max - $min == 0) {
                    $normal = 0; // Hindari pembagian nol
                } else {
                    if ($type == 'Benefits') {
                        $normal = ($max - $nilai) / ($max - $min);
                    } else { // Cost
                        $normal = ($nilai - $min) / ($max - $min);
                    }
                }

                $normalisasi[$nama][$kode] = $normal;
            }
        }

        // Hitung S dan R
        $S = [];
        $R = [];

        foreach ($normalisasi as $nama => $nilaiKriteria) {
            $sum = 0;
            $max = 0;

            foreach ($kriteria as $k) {
                $kode = $k['kode'];
                $bobot = $k['bobot'];

                $val = $nilaiKriteria[$kode] * $bobot;
                $sum += $val;
                if ($val > $max) {
                    $max = $val;
                }
            }

            $S[$nama] = $sum;
            $R[$nama] = $max;
        }

        // Cari S*, S-, R*, R-
        $Sstar = min($S);
        $Sminus = max($S);
        $Rstar = min($R);
        $Rminus = max($R);

        // Hitung Q
        $v = 0.5; // biasa digunakan 0.5
        $Q = [];

        foreach ($S as $nama => $Si) {
            $Ri = $R[$nama];

            $Q[$nama] = $v * (($Si - $Sstar) / ($Sminus - $Sstar)) + (1 - $v) * (($Ri - $Rstar) / ($Rminus - $Rstar));
        }

        // Urutkan berdasarkan Q terkecil
        asort($Q);

        // Tampilkan hasil
        echo "<h3>Ranking VIKOR:</h3>";
        $rank = 1;
        foreach ($Q as $nama => $qi) {
            echo "Rank {$rank}: {$nama} (Q = " . round($qi, 4) . ")<br>";
            $rank++;
        }
    }
}
