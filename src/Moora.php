<?php

namespace ajn\dss_library;

class Moora
{
    protected $limit;
    public $kriteria;
    public $alternatif;
    public $matriksKeputusan;
    public $matriksNormalisasi;
    public $nilaiOptimasi;
    public $perkalianBobot;
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
        $this->nilaiOptimasi = $this->setNilaiOptimasi();
        $this->ranking = $this->rank($this->nilaiOptimasi);
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
                $item = $nilai['bobot']/sqrt($this->getSum($nilai['kode']));
                $this->alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalMatriks']= $item;
                array_push($nilaiAlter, $item);
            }
            array_push($data, $nilaiAlter);
        }
        return $data;
    }

    private function getSum(string $kode): int
    {
        $item = 0;
        foreach ($this->alternatif as $key1 => $alternatif) {
            foreach ($alternatif['nilai'] as $key2 => $value) {
                if ($value['kode'] == $kode) $item += pow($value['bobot'],2);
            }
        }
        return $item;
    }

    private function setNilaiOptimasi(): array
    {
        $data = [];
        $this->perkalianBobot=[];
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $item = 0;
            $set = [];
            foreach ($alternatif['nilai'] as $key => $nilai) {
                $setNilai = ($nilai['normalMatriks'] * ($this->cekJenis($nilai['kode'])/100));
                $item += $setNilai;
                $set[] = $setNilai<0 ? $setNilai*(-1): $setNilai;
            }
            $this->perkalianBobot[] = $set;
            array_push($data, $item);
            $this->alternatif[$keyAlternatif]['preferensi'] = $item;
        }
        return $data;
    }

    private function cekJenis(string $kode): int
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if($kriteria['kode']==$kode) return $kriteria['type']=='Benefits' ? $kriteria['bobot'] : -$kriteria['bobot'];
        }
    }

    private function rank(array $data): array
    {
        usort($data, function ($a, $b) {
            $retval = $b <=> $a;
            return $retval;
        });
        usort($this->alternatif, function ($a, $b) {
            $retval = $b['preferensi'] <=> $a['preferensi'];
            return $retval;
        });
        $result = array_slice($data, 0, (int)$this->limit);
        foreach ($this->alternatif as $key => $value) {
            $this->alternatif[$key]['preferensi'] = round($value['preferensi'],5);
        }

        return $result;
    }
}
