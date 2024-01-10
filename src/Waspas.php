<?php

namespace ocs\spklib;

class Waspas
{
    protected $limit;
    public $kriteria;
    public $alternatif;
    public $matriksKeputusan;
    public $matriksNormalisasi;
    public $nilaiOptimasi;
    public $ranking;
    public $vector;
    public $preferensi;


    public $normalisasibobot;

    public function __construct($kriteria, $alternatif, $limit)
    {
        $this->limit = $limit;
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;
        $this->matriksKeputusan = $this->setMatriksKeputusan($this->alternatif);
        $this->matriksNormalisasi = $this->setMatriksNormalisasi();
        $this->setPreferensi();
        $this->rank();
    }

    private function setMatriksKeputusan(array $alternatifs): array
    {
        $data = [];
        foreach ($alternatifs as $key => $alternatif) {
            $item = [];
            foreach ($alternatif['nilai'] as $key1 => $value) {
                array_push($item, $value['bobot']);
            }
            array_push($data, $item);
        }
        return $data;
    }

    private function setMatriksNormalisasi(): array
    {
        $data = [];
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $nilaiAlter = [];
            foreach ($alternatif['nilai'] as $keyNilai => $nilai) {
                $item = $this->getType($nilai['kode']) == "Benefits" ? ($nilai['bobot'] / $this->getMax($nilai['kode'])) : ($this->getMin($nilai['kode'])/$nilai['bobot']);
                $this->alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalMatriks'] = $item;
                array_push($nilaiAlter, $item);
            }
            array_push($data, $nilaiAlter);
        }
        return $data;
    }

    private function getMax(string $kode): float
    {
        $currentMax = NULL;
        foreach ($this->alternatif as $arr) {
            foreach ($arr['nilai'] as $key => $value) {
                if ($value['kode'] == $kode && ($value['bobot'] >= $currentMax)) {
                    $currentMax = $value['bobot'];
                }
            }
        }

        return $currentMax;
    }

    private function getMin(string $kode): int
    {
        $currentMin = NULL;
        foreach ($this->alternatif as $arr) {
            foreach ($arr['nilai'] as $key => $value) {
                if ($value['kode'] == $kode && ($value['bobot'] <= $currentMin || $currentMin==NULL)) {
                    $currentMin = $value['bobot'];
                }
            }
        }
        return $currentMin;
    }

    private function getType(string $kode): string
    {
        foreach ($this->kriteria as $arr) {
            if($arr['kode']==$kode) return $arr['type'];
        }
    }

    private function setPreferensi()
    {
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $SW = 0;
            $WP = 0;
            foreach ($alternatif['nilai'] as $key => $value) {
                $bobot = $this->getBobot($value['kode']);
                $SW += ($value['normalMatriks'] * $bobot);
                if($key==0)$WP = pow($value['normalMatriks'], $bobot);
                else $WP *= pow($value['normalMatriks'], $bobot);
            }
            $this->alternatif[$keyAlternatif]['preferensi'] = (0.5 * $SW)+(0.5*$WP);
        }
    }

    private function getBobot(string $kode = null) : float {
        foreach ($this->kriteria as $key => $value) {
            if($value['kode'] == $kode) return floatval($value['bobot']);
        }
    }

    

    private function setNilaiOptimasi(): array
    {
        $data = [];
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $item = 0;
            foreach ($alternatif['nilai'] as $key => $nilai) {
                $item += ($nilai['normalMatriks'] * $this->cekJenis($nilai['kode']));
            }
            array_push($data, $item);
            $this->alternatif[$keyAlternatif]['preferensi'] = $item;
        }
        return $data;
    }

    private function cekJenis(string $kode): int
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if ($kriteria['kode'] == $kode) return $kriteria['type'] == 'Benefits' ? $kriteria['bobot'] : -$kriteria['bobot'];
        }
    }

    private function rank()
    {
        usort($this->alternatif, function ($a, $b) {
            $retval = $b['preferensi'] <=> $a['preferensi'];
            return $retval;
        });
        foreach ($this->alternatif as $key => $value) {
            $this->alternatif[$key]['preferensi'] = round($value['preferensi'], 5);
        }
    }
}
