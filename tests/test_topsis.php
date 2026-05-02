<?php

require "../src/Topsis.php";

use ajn\dss_library\Topsis as topsis;

$kriteria = [
    [
        'nama' => 'Pendidikan',
        'kode' => 'C1',
        'bobot' => 10,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Usia',
        'kode' => 'C2',
        'bobot' => 10,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Pengalaman Kerja',
        'kode' => 'C3',
        'bobot' => 15,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Kemampuan Komunikasi',
        'kode' => 'C4',
        'bobot' => 25,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Kemampuan Berhitung',
        'kode' => 'C5',
        'bobot' => 25,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Ketelitian Transaksi',
        'kode' => 'C6',
        'bobot' => 15,
        'type' => 'Benefits'
    ]
];

$alternatif = [
    [
        "nama" => "Andi Saputra",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 4
            ],
            [
                "kode" => "C5",
                "bobot" => 85
            ],
            [
                "kode" => "C6",
                "bobot" => 4
            ]
        ]
    ],
    [
        "nama" => "Budi Santoso",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 5
            ],
            [
                "kode" => "C5",
                "bobot" => 90
            ],
            [
                "kode" => "C6",
                "bobot" => 3
            ]
        ]
    ],
    [
        "nama" => "Deni Pratama",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 3
            ],
            [
                "kode" => "C4",
                "bobot" => 4
            ],
            [
                "kode" => "C5",
                "bobot" => 88
            ],
            [
                "kode" => "C6",
                "bobot" => 5
            ]
        ]
    ],
    [
        "nama" => "Putra Wijaya",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 3
            ],
            [
                "kode" => "C5",
                "bobot" => 78
            ],
            [
                "kode" => "C6",
                "bobot" => 4
            ]
        ]
    ],
    [
        "nama" => "Graen Kurniawan",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 4
            ],
            [
                "kode" => "C5",
                "bobot" => 82
            ],
            [
                "kode" => "C6",
                "bobot" => 3
            ]
        ]
    ],
    [
        "nama" => "Anissa Putri",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 3
            ],
            [
                "kode" => "C5",
                "bobot" => 75
            ],
            [
                "kode" => "C6",
                "bobot" => 5
            ]
        ]
    ],
    [
        "nama" => "Akmal Hidayat",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 5
            ],
            [
                "kode" => "C5",
                "bobot" => 92
            ],
            [
                "kode" => "C6",
                "bobot" => 3
            ]
        ]
    ],
    [
        "nama" => "Roji Firmansyah",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 4
            ],
            [
                "kode" => "C5",
                "bobot" => 80
            ],
            [
                "kode" => "C6",
                "bobot" => 4
            ]
        ]
    ],
    [
        "nama" => "Leo Oktaviani",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 3
            ],
            [
                "kode" => "C5",
                "bobot" => 70
            ],
            [
                "kode" => "C6",
                "bobot" => 4
            ]
        ]
    ],
    [
        "nama" => "Persi Natalia",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 1
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2
            ],
            [
                "kode" => "C4",
                "bobot" => 4
            ],
            [
                "kode" => "C5",
                "bobot" => 86
            ],
            [
                "kode" => "C6",
                "bobot" => 4
            ]
        ]
    ]
];

$a = new topsis($kriteria, $alternatif, 0);
$b = $a->ranking;

echo json_encode($a, JSON_PRETTY_PRINT);