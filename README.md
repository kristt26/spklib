# wplib

## Installation

Anda dapat melakukan instalasi melalui Composer di https://packagist.org/packages/ocs/wplib

## Requirements

1. PHP 5.4 or greater
2. CodeIgniter 3.0+

## Documentation
1. WP Method

```php
require "vendor/autoload.php";

use ocs\wplib\Wplibs as wp;
$kriteria = [
    [
        'nama' => 'Kecepatan',
        'kode' => 'C1',
        'bobot' => 4,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Tahun Aktif',
        'kode' => 'C2',
        'bobot' => 3,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Tanggal Bayar',
        'kode' => 'C3',
        'bobot' => 2,
        'type' => 'Benefits'
    ]
];
$alternatif = [
    [
        "nama" => "Nama1",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 5
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 1
            ]
        ]
    ],
    [
        "nama" => "Nama2",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 4
            ],
            [
                "kode" => "C2",
                "bobot" => 2
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ]
        ]
    ],
    [
        "nama" => "Nama3",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 4
            ]
        ]
    ]
];

$a = new wp($kriteria, $alternatif, 0);
echo json_encode($a->ranking);
```
---

1. Profile Matching Method

```php
require "vendor/autoload.php";

use ocs\spklib\ProfileMatching as PM;

$kriteria = [
    [
        'nama' => 'Kriteria 1',
        'code' => 'C1',
        'profileKriteria' => 5,
        'bobot' => 0.4,
        'sub' => [
            [
                'nama' => 'Sub 11',
                'code' => 'C11',
                'bobot' => 0.7
            ],
            [
                'nama' => 'Sub 12',
                'code' => 'C12',
                'bobot' => 0.3
            ]
        ]
    ],
    [
        'nama' => 'Kriteria 2',
        'code' => 'C2',
        'profileKriteria' => 4,
        'bobot' => 0.3,
        'sub' => [
            [
                'nama' => 'Sub 21',
                'code' => 'C21',
                'bobot' => 0.5
            ],
            [
                'nama' => 'Sub 22',
                'code' => 'C22',
                'bobot' => 0.4
            ],
            [
                'nama' => 'Sub 23',
                'code' => 'C23',
                'bobot' => 0.1
            ],
        ]
    ],
    [
        'nama' => 'Kriteria 3',
        'code' => 'C3',
        'profileKriteria' => 4,
        'bobot' => 0.3,
        'sub' => [
            [
                'nama' => 'Sub 31',
                'code' => 'C31',
                'bobot' => 0.25
            ],
            [
                'nama' => 'Sub 32',
                'code' => 'C32',
                'bobot' => 0.25
            ],
            [
                'nama' => 'Sub 33',
                'code' => 'C33',
                'bobot' => 0.25
            ],
            [
                'nama' => 'Sub 34',
                'code' => 'C34',
                'bobot' => 0.25
            ],
        ]
    ],
];
$alternatif = [
    [
        "nama" => "Nama1",
        "nilai" => [
            [
                "code" => "C1",
                "sub" => [
                    [
                        'code'=>'C11',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C12',
                        'nilai'=> 4
                    ],
                ]
            ],
            [
                "code" => "C2",
                "sub" => [
                    [
                        'code'=>'C21',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C22',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C23',
                        'nilai'=> 4
                    ],
                ]
            ],
            [
                "code" => "C3",
                "sub" => [
                    [
                        'code'=>'C31',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C32',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C33',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C34',
                        'nilai'=> 4
                    ],
                ]
            ]
        ]
    ],
    [
        "nama" => "Nama2",
        "nilai" => [
            [
                "code" => "C1",
                "sub" => [
                    [
                        'code'=>'C11',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C12',
                        'nilai'=> 4
                    ],
                ]
            ],
            [
                "code" => "C2",
                "sub" => [
                    [
                        'code'=>'C21',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C22',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C23',
                        'nilai'=> 4
                    ],
                ]
            ],
            [
                "code" => "C3",
                "sub" => [
                    [
                        'code'=>'C31',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C32',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C33',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C34',
                        'nilai'=> 4
                    ],
                ]
            ]
        ]
    ],
    [
        "nama" => "Nama3",
        "nilai" => [
            [
                "code" => "C1",
                "sub" => [
                    [
                        'code'=>'C11',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C12',
                        'nilai'=> 4
                    ],
                ]
            ],
            [
                "code" => "C2",
                "sub" => [
                    [
                        'code'=>'C21',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C22',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C23',
                        'nilai'=> 5
                    ],
                ]
            ],
            [
                "code" => "C3",
                "sub" => [
                    [
                        'code'=>'C31',
                        'nilai'=> 4
                    ],
                    [
                        'code'=>'C32',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C33',
                        'nilai'=> 5
                    ],
                    [
                        'code'=>'C34',
                        'nilai'=> 4
                    ],
                ]
            ]
        ]
    ]
];

$a = new PM($kriteria, $alternatif, 0, true);
echo json_encode($a->rank);
```
---
