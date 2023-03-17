<?php
namespace ocs\wplib;

class Wplib
{
    protected $limit;
    protected $kriteria;
    protected $alternatif;
    public $bobot;
    public $normalisasibobot;
    public $vector;
    public $preferensi;
    public $ranking;

    public function __construct($kriteria, $alternatif, $limit)
    {
        $this->limit = $limit;
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;
        $this->bobot = $this->bobot($this->kriteria);
        $this->normalisasibobot = $this->normalisasi($this->bobot);
        $this->vector = $this->normalisasiAlternatif($this->alternatif, $this->normalisasibobot);
        $this->preferensi = $this->bobotPreferensi($this->vector);
        $this->ranking = $this->rank($this->preferensi);
    }

    private function bobot(array $kriteria): array
    {
        $dataBobot = [];
        foreach ($kriteria as $key => $value) {
            $item = [
                'kode' => $value['kode'],
                'bobot' => $value['bobot'],
                'type' => $value['type'],
            ];
            array_push($dataBobot, $item);
        }
        return $dataBobot;
    }

    private function normalisasi(array $bobot): array
    {
        $sum = 0;
        foreach ($bobot as $key => $value) {
            $sum += floatval($value['bobot']);
        }

        foreach ($bobot as $key => $value) {
            $bobot[$key]['bobot'] = floatval($value['bobot']) / $sum;
        }

        return $bobot;
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
