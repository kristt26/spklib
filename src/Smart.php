<?php

namespace ocs\spklib;

class Smart
{
    protected $limit;
    public $kriteria;
    public $alternatif;
    public $matriksKeputusan;
    public $nilaiUtility;
    public $nilaiAkhir;
    public $ranking;
    public $preferensi;


    public $normalisasibobot;

    public function __construct($kriteria, $alternatif, $limit, bool $normalisasi = false)
    {
        $this->limit = $limit;
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;
        $this->matriksKeputusan = $this->setMatriksKeputusan($this->alternatif);
        $this->nilaiUtility = $this->setNilaiUtility();
        $this->nilaiAkhir = $this->setNilaiAkhir();
        $this->ranking = $this->rank($this->nilaiAkhir);
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

    private function setNilaiUtility(): array
    {
        $data = [];
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $nilaiAlter = [];
            foreach ($alternatif['nilai'] as $keyNilai => $nilai) {
                $item = $this->getType($nilai['kode']) == "Benefits" ? (($nilai['bobot']-$this->getMin($nilai['kode'])) / ($this->getMax($nilai['kode'])-$this->getMin($nilai['kode']))) : (($this->getMin($nilai['kode'])-$nilai['bobot']) / ($this->getMax($nilai['kode'])-$this->getMin($nilai['kode'])));
                $this->alternatif[$keyAlternatif]['nilai'][$keyNilai]['normalUtility'] = $item;
                array_push($nilaiAlter, $item);
            }
            array_push($data, $nilaiAlter);
        }
        return $data;
    }

    private function setNilaiAkhir(): array
    {
        $data = [];
        foreach ($this->alternatif as $keyAlternatif => $alternatif) {
            $item = 0;
            foreach ($alternatif['nilai'] as $key => $nilai) {
                $item += ($nilai['normalUtility'] * $this->cekJenis($nilai['kode']));
            }
            array_push($data, $item);
            $this->alternatif[$keyAlternatif]['nilaiAkhir'] = $item;
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
                if ($value['kode'] == $kode && ($value['bobot'] <= $currentMin || $currentMin == NULL)) {
                    $currentMin = $value['bobot'];
                }
            }
        }
        return $currentMin;
    }

    private function getType(string $kode): string
    {
        foreach ($this->kriteria as $arr) {
            if ($arr['kode'] == $kode) return $arr['type'];
        }
    }

    private function cekJenis(string $kode): float
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if($kriteria['kode']==$kode) return (float) $kriteria['bobot'];
        }
    }

    private function rank(array $data): array
    {
        usort($data, function ($a, $b) {
            $retval = $b <=> $a;
            return $retval;
        });
        usort($this->alternatif, function ($a, $b) {
            $retval = $b['nilaiAkhir'] <=> $a['nilaiAkhir'];
            return $retval;
        });
        $result = array_slice($data, 0, (int)$this->limit);
        foreach ($this->alternatif as $key => $value) {
            $this->alternatif[$key]['nilaiAkhir'] = round($value['nilaiAkhir'],5);
        }
        return $result;
    }
}
