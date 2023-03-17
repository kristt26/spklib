<?php

namespace ocs\spklibs;

class Moora
{
    protected $limit;
    protected $kriteria;
    protected $alternatif;
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
        $this->matriksNormalisasi = $this->setMatriksNormalisasi($this->alternatif, $this->kriteria);
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

    private function setMatriksNormalisasi(array $alternatifs, array $kriterias): array
    {
        $data = [];
        foreach ($alternatifs as $keyAlternatif => $alternatif) {
            $nilaiAlter = [];
            foreach ($alternatif['nilai'] as $keyNilai => $nilai) {
                $item = $nilai['bobot']/sqrt($this->getSum($nilai['kode']));
                $alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalMatriks']= $item;
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
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $item = 0;
            foreach ($alternatif['nilai'] as $key => $nilai) {
                $item += ($nilai['bobot'] * $this->cekJenis($nilai['kode']));
            }
            array_push($data, $item);
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
            $retval = $b['preferensi'] <=> $a['preferensi'];
            return $retval;
        });

        return $this->limit > 0 ? array_slice($data, 0, $this->limit) : $data;
    }
}
