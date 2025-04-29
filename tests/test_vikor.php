<?php

require "../src/Vikor.php";

use ajn\dss_library\Vikor as vk;

$kriteria = [
    [
        'nama' => 'Indeks Prestasi',
        'kode' => 'C1',
        'bobot' => 0.45,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Semester',
        'kode' => 'C2',
        'bobot' => 0.20,
        'type' => 'Cost'
    ],
    [
        'nama' => 'Daya Listrik',
        'kode' => 'C3',
        'bobot' => 0.05,
        'type' => 'Cost'
    ],
    [
        'nama' => 'Tagihan Listrik',
        'kode' => 'C4',
        'bobot' => 0.30,
        'type' => 'Cost'
    ]
];
$alternatif = [
    [
        "nama" => "Usman P.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.36
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 450
            ],
            [
                "kode" => "C4",
                "bobot" => 136601
            ]
        ]
    ],
    [
        "nama" => "T. Nina",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.79
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 2200
            ],
            [
                "kode" => "C4",
                "bobot" => 212180
            ]
        ]
    ],
    [
        "nama" => "Lina",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.06
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 900
            ],
            [
                "kode" => "C4",
                "bobot" => 619285
            ]
        ]
    ],
    [
        "nama" => "Wawan",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.46
            ],
            [
                "kode" => "C2",
                "bobot" => 2
            ],
            [
                "kode" => "C3",
                "bobot" => 900
            ],
            [
                "kode" => "C4",
                "bobot" => 582738
            ]
        ]
    ],
    [
        "nama" => "S. Vicky",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.15
            ],
            [
                "kode" => "C2",
                "bobot" => 6
            ],
            [
                "kode" => "C3",
                "bobot" => 2200
            ],
            [
                "kode" => "C4",
                "bobot" => 231740
            ]
        ]
    ],
    [
        "nama" => "A. Hilmi",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.44
            ],
            [
                "kode" => "C2",
                "bobot" => 6
            ],
            [
                "kode" => "C3",
                "bobot" => 900
            ],
            [
                "kode" => "C4",
                "bobot" => 643125
            ]
        ]
    ],
    [
        "nama" => "Intan M.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.97
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 1300
            ],
            [
                "kode" => "C4",
                "bobot" => 460979
            ]
        ]
    ],
    [
        "nama" => "R. Gatot",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.81
            ],
            [
                "kode" => "C2",
                "bobot" => 7
            ],
            [
                "kode" => "C3",
                "bobot" => 1300
            ],
            [
                "kode" => "C4",
                "bobot" => 244249
            ]
        ]
    ],
    [
        "nama" => "Bella",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.15
            ],
            [
                "kode" => "C2",
                "bobot" => 6
            ],
            [
                "kode" => "C3",
                "bobot" => 2200
            ],
            [
                "kode" => "C4",
                "bobot" => 430521
            ]
        ]
    ],
    [
        "nama" => "Pandu M.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2.60
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 1300
            ],
            [
                "kode" => "C4",
                "bobot" => 548112
            ]
        ]
    ],
    [
        "nama" => "Alfian K.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 3.49
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 2200
            ],
            [
                "kode" => "C4",
                "bobot" => 931985
            ]
        ]
    ],
    [
        "nama" => "Reza",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 2.60
            ],
            [
                "kode" => "C2",
                "bobot" => 7
            ],
            [
                "kode" => "C3",
                "bobot" => 450
            ],
            [
                "kode" => "C4",
                "bobot" => 437045
            ]
        ]
    ]
];

$a = new vk($kriteria, $alternatif, 0);
echo json_encode($a);
