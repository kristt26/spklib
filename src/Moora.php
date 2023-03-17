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
        $this->preferensi = $this->bobotPreferensi($this->vector);
        $this->ranking = $this->rank($this->preferensi);
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
            foreach ($kriterias as $keyKriteria => $kriteria) {
            }
        }
        return $data;
    }

    private function getSum($kode): int
    {
        $item = 0;
        foreach ($this->alternatif as $key1 => $alternatif) {
            foreach ($alternatif['nilai'] as $key2 => $value) {
                if ($value['kode'] == $kode) $item += $value['bobot'];
            }
        }
        return $item;
    }

    private function normalisasiAlternatif(array $alternatif, array $bobot): array
    {
        foreach ($alternatif as $keyAlternatif => $valueAlternatif) {
            $nilai = 0;
            foreach ($valueAlternatif['nilai'] as $keyNilai => $valueNilai) {
                foreach ($bobot as $keyBobot => $valueBobot) {
                    if ($valueNilai['kode'] == $valueBobot['kode']) {
                        $alternatif[$keyAlternatif]['nilai'][$keyNilai]['bobot'] = pow(floatval($valueNilai['bobot']), ($valueBobot['type'] == 'Benefits' ? floatval($valueBobot['bobot']) : (floatval($valueBobot['bobot']) * -1)));
                        if ($keyNilai == 0) {
                            $nilai = $alternatif[$keyAlternatif]['nilai'][$keyNilai]['bobot'];
                        } else {
                            $nilai *= $alternatif[$keyAlternatif]['nilai'][$keyNilai]['bobot'];
                        }
                    }
                }
            }
            $alternatif[$keyAlternatif]['vector'] = $nilai;
        }
        return $alternatif;
    }

    private function bobotPreferensi(array $vector): array
    {
        $sum = 0;
        foreach ($vector as $key => $value) {
            $sum += $value['vector'];
        }

        foreach ($vector as $key => $value) {
            $vector[$key]['preferensi'] = floatval($value['vector']) / floatval($sum);
        }
        return $vector;
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
