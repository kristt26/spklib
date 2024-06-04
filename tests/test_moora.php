<?php

require "../src/Moora.php";

use ajn\dss_library\Moora as moora;

$kriteria = [
    [
        'nama' => 'Test Tertulis',
        'kode' => 'C1',
        'bobot' => 50,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Test Wawancara',
        'kode' => 'C2',
        'bobot' => 30,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Test Kesehatan',
        'kode' => 'C3',
        'bobot' => 20,
        'type' => 'Benefits'
    ]
];
$alternatif = [
    [
        "nama" => "Alfian N",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 4
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 3
            ]
        ]
    ],
    [
        "nama" => "T. Yuna",
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
                "bobot" => 5
            ]
        ]
    ],
    [
        "nama" => "D. Zaki",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 5
            ]
        ]
    ],
    [
        "nama" => "Pandu A.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 4
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 3
            ]
        ]
    ],
    [
        "nama" => "Vicky T.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 4
            ]
        ]
    ]
];

$a = new moora($kriteria, $alternatif, 0);
$b = $a->ranking;
echo json_encode($a);
