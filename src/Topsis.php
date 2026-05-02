<?php

namespace ajn\dss_library;

class Topsis
{
    protected $limit;
    protected $kriteria;
    protected $alternatif;

    public $bobot;
    public $normalisasibobot;
    public $normalisasimatriks;
    public $normalisasiterbobot;
    public $solusiidealpositif;
    public $solusiidealnegatif;
    public $jarak;
    public $preferensi;
    public $ranking;

    public function __construct($kriteria, $alternatif, $limit = 0)
    {
        $this->limit = $limit;
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;

        $this->bobot = $this->bobot($this->kriteria);
        $this->normalisasibobot = $this->normalisasiBobot($this->bobot);
        $this->normalisasimatriks = $this->normalisasiMatriks($this->alternatif);
        $this->normalisasiterbobot = $this->normalisasiTerbobot($this->normalisasimatriks, $this->normalisasibobot);
        $this->solusiidealpositif = $this->solusiIdealPositif($this->normalisasiterbobot, $this->normalisasibobot);
        $this->solusiidealnegatif = $this->solusiIdealNegatif($this->normalisasiterbobot, $this->normalisasibobot);
        $this->jarak = $this->hitungJarak(
            $this->normalisasiterbobot,
            $this->solusiidealpositif,
            $this->solusiidealnegatif
        );
        $this->preferensi = $this->hitungPreferensi($this->jarak);
        $this->ranking = $this->rank($this->preferensi);
    }

    private function bobot(array $kriteria): array
    {
        $dataBobot = [];

        foreach ($kriteria as $value) {
            $item = [
                'kode' => $value['kode'],
                'bobot' => floatval($value['bobot']),
                'type' => $value['type'],
            ];

            array_push($dataBobot, $item);
        }

        return $dataBobot;
    }

    private function normalisasiBobot(array $bobot): array
    {
        $sum = 0;

        foreach ($bobot as $value) {
            $sum += floatval($value['bobot']);
        }

        if ($sum == 0) {
            return $bobot;
        }

        foreach ($bobot as $key => $value) {
            $bobot[$key]['bobot'] = floatval($value['bobot']) / $sum;
        }

        return $bobot;
    }

    private function normalisasiMatriks(array $alternatif): array
    {
        $pembagi = [];

        foreach ($this->kriteria as $kriteria) {
            $kode = $kriteria['kode'];
            $totalKuadrat = 0;

            foreach ($alternatif as $valueAlternatif) {
                foreach ($valueAlternatif['nilai'] as $valueNilai) {
                    if ($valueNilai['kode'] == $kode) {
                        $nilai = floatval($valueNilai['bobot']);
                        $totalKuadrat += pow($nilai, 2);
                    }
                }
            }

            $pembagi[$kode] = sqrt($totalKuadrat);
        }

        foreach ($alternatif as $keyAlternatif => $valueAlternatif) {
            foreach ($valueAlternatif['nilai'] as $keyNilai => $valueNilai) {
                $kode = $valueNilai['kode'];
                $nilai = floatval($valueNilai['bobot']);

                if (isset($pembagi[$kode]) && $pembagi[$kode] != 0) {
                    $alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalisasi'] = $nilai / $pembagi[$kode];
                } else {
                    $alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalisasi'] = 0;
                }
            }
        }

        return $alternatif;
    }

    private function normalisasiTerbobot(array $normalisasi, array $bobot): array
    {
        foreach ($normalisasi as $keyAlternatif => $valueAlternatif) {
            foreach ($valueAlternatif['nilai'] as $keyNilai => $valueNilai) {
                foreach ($bobot as $valueBobot) {
                    if ($valueNilai['kode'] == $valueBobot['kode']) {
                        $normalisasi[$keyAlternatif]['nilai'][$keyNilai]['terbobot'] =
                            floatval($valueNilai['normalisasi']) * floatval($valueBobot['bobot']);
                    }
                }
            }
        }

        return $normalisasi;
    }

    private function solusiIdealPositif(array $normalisasiTerbobot, array $bobot): array
    {
        $solusi = [];

        foreach ($bobot as $valueBobot) {
            $kode = $valueBobot['kode'];
            $type = $valueBobot['type'];
            $dataNilai = [];

            foreach ($normalisasiTerbobot as $valueAlternatif) {
                foreach ($valueAlternatif['nilai'] as $valueNilai) {
                    if ($valueNilai['kode'] == $kode) {
                        $dataNilai[] = floatval($valueNilai['terbobot']);
                    }
                }
            }

            if ($type == 'Benefits') {
                $nilaiIdeal = max($dataNilai);
            } else {
                $nilaiIdeal = min($dataNilai);
            }

            $solusi[] = [
                'kode' => $kode,
                'nilai' => $nilaiIdeal,
                'type' => $type,
            ];
        }

        return $solusi;
    }

    private function solusiIdealNegatif(array $normalisasiTerbobot, array $bobot): array
    {
        $solusi = [];

        foreach ($bobot as $valueBobot) {
            $kode = $valueBobot['kode'];
            $type = $valueBobot['type'];
            $dataNilai = [];

            foreach ($normalisasiTerbobot as $valueAlternatif) {
                foreach ($valueAlternatif['nilai'] as $valueNilai) {
                    if ($valueNilai['kode'] == $kode) {
                        $dataNilai[] = floatval($valueNilai['terbobot']);
                    }
                }
            }

            if ($type == 'Benefits') {
                $nilaiIdeal = min($dataNilai);
            } else {
                $nilaiIdeal = max($dataNilai);
            }

            $solusi[] = [
                'kode' => $kode,
                'nilai' => $nilaiIdeal,
                'type' => $type,
            ];
        }

        return $solusi;
    }

    private function hitungJarak(array $normalisasiTerbobot, array $idealPositif, array $idealNegatif): array
    {
        foreach ($normalisasiTerbobot as $keyAlternatif => $valueAlternatif) {
            $totalPositif = 0;
            $totalNegatif = 0;

            foreach ($valueAlternatif['nilai'] as $valueNilai) {
                $kode = $valueNilai['kode'];
                $nilaiTerbobot = floatval($valueNilai['terbobot']);

                foreach ($idealPositif as $valueIdealPositif) {
                    if ($kode == $valueIdealPositif['kode']) {
                        $totalPositif += pow($nilaiTerbobot - floatval($valueIdealPositif['nilai']), 2);
                    }
                }

                foreach ($idealNegatif as $valueIdealNegatif) {
                    if ($kode == $valueIdealNegatif['kode']) {
                        $totalNegatif += pow($nilaiTerbobot - floatval($valueIdealNegatif['nilai']), 2);
                    }
                }
            }

            $normalisasiTerbobot[$keyAlternatif]['d_plus'] = sqrt($totalPositif);
            $normalisasiTerbobot[$keyAlternatif]['d_min'] = sqrt($totalNegatif);
        }

        return $normalisasiTerbobot;
    }

    private function hitungPreferensi(array $jarak): array
    {
        foreach ($jarak as $key => $value) {
            $dPlus = floatval($value['d_plus']);
            $dMin = floatval($value['d_min']);
            $pembagi = $dPlus + $dMin;

            if ($pembagi == 0) {
                $jarak[$key]['preferensi'] = 0;
            } else {
                $jarak[$key]['preferensi'] = $dMin / $pembagi;
            }
        }

        return $jarak;
    }

    private function rank(array $data): array
    {
        usort($data, function ($a, $b) {
            return $b['preferensi'] <=> $a['preferensi'];
        });

        foreach ($data as $key => $value) {
            $data[$key]['ranking'] = $key + 1;
        }

        return $this->limit > 0 ? array_slice($data, 0, $this->limit) : $data;
    }
}