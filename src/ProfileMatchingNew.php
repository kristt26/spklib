<?php

namespace ocs\spklib;

// use stdClass;

class ProfileMatchingNew
{
    protected $limit;
    protected $rounding;
    protected $sf;
    protected $kriteria;
    public $alternatif;
    public $nilaiAkhir;
    public $rank;

    public function __construct($kriteria, $alternatif, $limit, $sf, $rounding)
    {
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;
        $this->limit = $limit;
        $this->rounding = $rounding;
        $this->sf = $sf;
        $this->setMapGap();
        $this->nilaiAkhir = [];
        $this->nilaiAkhir = $this->alternatif;
        $this->rank = $this->setRank($this->nilaiAkhir);
    }

    private function getBobotGap(float $nilai): float
    {

        $data = [
            [
                'gap' => 0,
                'nilai' => 5
            ],
            [
                'gap' => 1,
                'nilai' => 4.5
            ],
            [
                'gap' => -1,
                'nilai' => 4
            ],
            [
                'gap' => 2,
                'nilai' => 3.5
            ],
            [
                'gap' => -2,
                'nilai' => 3
            ],
            [
                'gap' => 3,
                'nilai' => 2.5
            ],
            [
                'gap' => -3,
                'nilai' => 2
            ],
            [
                'gap' => 4,
                'nilai' => 1.5
            ],
            [
                'gap' => -4,
                'nilai' => 1
            ]
        ];
        $item = 0;
        foreach ($data as $key => $value) {
            if ($value['gap'] == $nilai) {
                $item = $value['nilai'];
            }
        }
        return $item;
    }

    private function setMapGap()
    {
        if ($this->sf) {
            foreach ($this->alternatif as $keyAlt => $alternatif) {
                $nilaiAkhir = 0;
                foreach ($alternatif['nilai'] as $keyNil => $nilai) {
                    foreach ($this->kriteria as $key => $kriteria) {

                        if ($nilai['code'] == $kriteria['code']) {
                            $nilaiSf = 0;
                            $countSf = 0;
                            $nilaiCf = 0;
                            $countCf = 0;
                            foreach ($nilai['sub'] as $keySub => $sub) {
                                foreach ($kriteria['sub'] as $keySubKriteria => $subKriteria) {
                                    if ($sub['code'] == $subKriteria['code']) {
                                        $this->alternatif[$keyAlt]['nilai'][$keyNil]['sub'][$keySub]['gap'] = $sub['nilai'] - $subKriteria['profileKriteria'];
                                        $mapGap = $this->getBobotGap($sub['nilai'] - $subKriteria['profileKriteria']);
                                        $this->alternatif[$keyAlt]['nilai'][$keyNil]['sub'][$keySub]['mapGap'] = $mapGap;
                                        $nilaiSf += $this->getBobotGap($sub['nilai'] - $kriteria['profileKriteria']) * $subKriteria['bobot'];
                                        if ($subKriteria['status'] == 'CF') {
                                            $countCf += 1;
                                            $nilaiCf += $mapGap;
                                        }else{
                                            $countSf += 1;
                                            $nilaiSf += $mapGap;
                                        }
                                    }
                                }
                            }
                            $nak = ($nilaiCf/$countCf*0.6)+($nilaiSf/$countSf*0.4);
                            $this->alternatif[$keyAlt]['nilai'][$keyNil]['nak'] = $nak;
                            $nilaiAkhir += ($nak*$kriteria['bobot']);
                        }
                        $this->alternatif[$keyAlt]['nilai'][$keyNil]['nak'] = $nak;
                    }
                }
                $this->alternatif[$keyAlt]['nilaiAkhir'] = $nilaiAkhir;
            }
        } else {
            foreach ($this->alternatif as $keyAlt => $alternatif) {
                foreach ($alternatif['nilai'] as $keyNil => $nilai) {
                    foreach ($this->kriteria as $key => $kriteria) {
                        if ($nilai['code'] == $kriteria['code']) {
                            $this->alternatif[$keyAlt]['nilai'][$keyNil]['gap'] = $nilai['nilai'] - $kriteria['profileKriteria'];
                            $this->alternatif[$keyAlt]['nilai'][$keyNil]['mapGap'] = $this->getBobotGap($nilai['nilai'] - $kriteria['profileKriteria']);
                        }
                    }
                }
            }
        }
    }

    // private function setNilaiAkhir(): array
    // {
    //     $data = [];
    //     if ($this->sf) {
    //         foreach ($this->alternatif as $keyAlt => $alternatif) {
    //             $nilai1 = 0;
    //             foreach ($alternatif['nilai'] as $keyNil => $nilai) {
    //                 foreach ($this->kriteria as $key => $kriteria) {
    //                     array_push($data, ['nama' => $this->alternatif[$keyAlt]['nama'], 'nilaiAkhir' => $nilai1 / count($this->kriteria)]);
    //                     if ($nilai['code'] == $kriteria['code']) {
    //                         $hitung = ($nilai['sf'] * $kriteria['bobot']);
    //                         $nilai1 += $hitung;
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         foreach ($this->alternatif as $keyAlt => $alternatif) {
    //             $nilai = 0;
    //             foreach ($alternatif['nilai'] as $keyNil => $nilai) {
    //                 foreach ($this->kriteria as $key => $kriteria) {
    //                     if ($nilai['code'] == $kriteria['code']) {
    //                         $nilai += ($nilai['mapGap'] * $kriteria['bobot']);
    //                     }
    //                 }
    //             }
    //             $item = ['nama' => $alternatif['nama'], 'nilaiAkhir' => $nilai];
    //             array_push($data, $item);
    //         }
    //     }
    //     return $data;
    // }

    private function setRank(array $data): array
    {
        usort($data, function ($a, $b) {
            $retval = $b['nilaiAkhir'] <=> $a['nilaiAkhir'];
            return $retval;
        });

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['nilaiAkhir'] = round($data[$i]['nilaiAkhir'], $this->rounding);
        }

        return $this->limit > 0 ? array_slice($data, 0, $this->limit) : $data;
    }
}
