<?php

namespace ajn\dss_library;

class Edas
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

    public $AV;
    public $PDA;
    public $NDA;
    public $SP;
    public $NSP;
    public $SN;
    public $NSN;
    public $AS;

    public function __construct($kriteria, $alternatif, $limit)
    {
        $this->limit = $limit;
        $this->kriteria = $kriteria;
        $this->alternatif = $alternatif;
        $this->matriksKeputusan = $this->setMatriksKeputusan($this->alternatif);
        $this->AV = $this->setAV();
        $this->setPdaNda();
        $this->setSpNs();
        $this->setNormalSpNs();
        $this->setAs();
        $this->ranking = $this->rank($this->AS);
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

    private function setAV() : array {
        $av = [];
        for ($i=0; $i < count($this->kriteria); $i++) { 
            $sum = 0;
            foreach ($this->alternatif as $key1 => $value1) {
                foreach ($value1['nilai'] as $key2 => $value2) {
                    if($this->kriteria[$i]['kode']==$value2['kode']) $sum+=$value2['bobot'];
                }
            }
            $this->kriteria[$i]['av'] = $sum/count($this->alternatif);
            $av[] =  $this->kriteria[$i];
        }
        return $av;
    }

    private function setPdaNda() {
        $this->PDA = [];
        $this->NDA = [];
        foreach ($this->alternatif as $key1 => $value1) {
            $this->alternatif[$key1]['pda'] = [];
            $this->alternatif[$key1]['nda'] = [];
            foreach ($value1['nilai'] as $key2 => $value2) {
                $av = $this->getAV($value2['kode']);
                if($this->cekJenis($value2['kode'])=='Benefits'){
                    $this->alternatif[$key1]['pda'][] = ['kode'=>$value2['kode'], 'bobot'=>max(0,($value2['bobot']-$av)/$av)];
                    $this->alternatif[$key1]['nda'][] = ['kode'=>$value2['kode'], 'bobot'=>max(0,($av-$value2['bobot'])/$av)];
                    $this->PDA[] = max(0,($value2['bobot']-$av)/$av);
                    $this->NDA[] = max(0,($av-$value2['bobot'])/$av);
                }else{
                    $this->alternatif[$key1]['pda'][] = ['kode'=>$value2['kode'], 'bobot'=>max(0,($av-$value2['bobot'])/$av)];
                    $this->alternatif[$key1]['nda'][] = ['kode'=>$value2['kode'], 'bobot'=>max(0,($value2['bobot']-$av)/$av)];
                    $this->PDA[] = max(0,($av-$value2['bobot'])/$av);
                    $this->NDA[] = max(0,($value2['bobot']-$av)/$av);
                }
            }
        }
    }

    private function setSpNs() {
        $this->SP = [];
        $this->SN = [];
        foreach ($this->alternatif as $key1 => $value1) {
            $this->alternatif[$key1]['sp'] = 0;
            $this->alternatif[$key1]['sn'] = 0;
            foreach ($value1['pda'] as $key2 => $value2) {
                $this->alternatif[$key1]['sp'] += ($value2['bobot']*$this->getBobot($value2['kode']));
            }
            foreach ($value1['nda'] as $key2 => $value2) {
                $this->alternatif[$key1]['sn'] += ($value2['bobot']*$this->getBobot($value2['kode']));
            }
            $this->SP[] = $this->alternatif[$key1]['sp'];
            $this->SN[] = $this->alternatif[$key1]['sn'];
        }
    }

    private function setNormalSpNs() {
        $this->NSP = [];
        $this->NSN = [];
        foreach ($this->alternatif as $key1 => $value1) {
            $this->alternatif[$key1]['nsp'] = $this->alternatif[$key1]['sp']/$this->getMax('sp');
            $this->alternatif[$key1]['nsn'] = 1 - ($this->alternatif[$key1]['sn']/$this->getMax('sn'));
            $this->NSP[] = $this->alternatif[$key1]['nsp'];
            $this->NSN[] = $this->alternatif[$key1]['nsn'];
        }
    }
    
    private function setAs() {
        $this->AS = [];
        foreach ($this->alternatif as $key1 => $value1) {
            $this->alternatif[$key1]['as'] = 0.5 * ($value1['nsp']+$value1['nsn']);
            $this->AS[] = $this->alternatif[$key1]['as'];
        }
    }

    private function getMax(string $kode): float
    {
        $currentMax = NULL;
        foreach ($this->alternatif as $arr) {
            if (($arr[$kode] >= $currentMax)) {
                $currentMax = $arr[$kode];
            }
        }
        // if($kode =='sp'){
        // }

        return $currentMax;
    }

    private function getAV(string $kode): float
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if($kriteria['kode']==$kode) return $kriteria['av'];
        }
    }

    
    private function cekJenis(string $kode): string
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if($kriteria['kode']==$kode) return $kriteria['type'];
        }
    }

    private function getBobot(string $kode): float
    {
        foreach ($this->kriteria as $keyKriteria => $kriteria) {
            if($kriteria['kode']==$kode) return $kriteria['bobot'];
        }
    }

    private function rank(array $data): array
    {
        usort($this->AS, function ($a, $b) {
            $retval = $b <=> $a;
            return $retval;
        });
        usort($this->alternatif, function ($a, $b) {
            $retval = $b['as'] <=> $a['as'];
            return $retval;
        });
        $result = array_slice($data, 0, (int)$this->limit);
        foreach ($this->alternatif as $key => $value) {
            $this->alternatif[$key]['as'] = round($value['as'],5);
        }

        return $result;
    }
}
