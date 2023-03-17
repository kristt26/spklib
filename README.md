# wplib

## Installation

Anda dapat melakukan instalasi melalui Composer di https://packagist.org/packages/ocs/wplib

## Requirements

1. PHP 5.4 or greater
2. CodeIgniter 3.0+

## Documentation

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
