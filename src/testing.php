<?php

require "Waspas.php";

use ocs\spklib\Waspas as wp;

$kriteria = [
    [
        'nama' => 'Penguasaan Aspek Teknis',
        'kode' => 'C1',
        'bobot' => 0.3,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Pengalaman Kerja',
        'kode' => 'C2',
        'bobot' => 0.1,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Interpersonal Skill',
        'kode' => 'C3',
        'bobot' => 0.2,
        'type' => 'Benefits'
    ],
    [
        'nama' => 'Usia',
        'kode' => 'C4',
        'bobot' => 0.25,
        'type' => 'Cost'
    ],
    [
        'nama' => 'Status Perkawinan',
        'kode' => 'C5',
        'bobot' => 0.15,
        'type' => 'Cost'
    ]
];
$alternatif = [
    [
        "nama" => "Alfian N",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 9
            ],
            [
                "kode" => "C2",
                "bobot" => 4
            ],
            [
                "kode" => "C3",
                "bobot" => 7
            ],
            [
                "kode" => "C4",
                "bobot" => 36
            ],
            [
                "kode" => "C5",
                "bobot" => 10
            ]
        ]
    ],
    [
        "nama" => "T. Yuna",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 6
            ],
            [
                "kode" => "C2",
                "bobot" => 4.5
            ],
            [
                "kode" => "C3",
                "bobot" => 9
            ],
            [
                "kode" => "C4",
                "bobot" => 39
            ],
            [
                "kode" => "C5",
                "bobot" => 5
            ]
        ]
    ],
    [
        "nama" => "D. Zaki",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 6.5
            ],
            [
                "kode" => "C2",
                "bobot" => 2
            ],
            [
                "kode" => "C3",
                "bobot" => 6
            ],
            [
                "kode" => "C4",
                "bobot" => 22
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
    [
        "nama" => "Pandu A.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 8
            ],
            [
                "kode" => "C2",
                "bobot" => 6.5
            ],
            [
                "kode" => "C3",
                "bobot" => 7
            ],
            [
                "kode" => "C4",
                "bobot" => 30
            ],
            [
                "kode" => "C5",
                "bobot" => 10
            ]
        ]
    ],
    [
        "nama" => "Vicky T.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 9
            ],
            [
                "kode" => "C2",
                "bobot" => 3
            ],
            [
                "kode" => "C3",
                "bobot" => 6.5
            ],
            [
                "kode" => "C4",
                "bobot" => 29
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
    [
        "nama" => "Dewi L.",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 8.5
            ],
            [
                "kode" => "C2",
                "bobot" => 5
            ],
            [
                "kode" => "C3",
                "bobot" => 8.5
            ],
            [
                "kode" => "C4",
                "bobot" => 34
            ],
            [
                "kode" => "C5",
                "bobot" => 10
            ]
        ]
    ],
    [
        "nama" => "Gatot",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 6.5
            ],
            [
                "kode" => "C2",
                "bobot" => 7.5
            ],
            [
                "kode" => "C3",
                "bobot" => 7
            ],
            [
                "kode" => "C4",
                "bobot" => 28
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
    [
        "nama" => "D. Lina",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 8
            ],
            [
                "kode" => "C2",
                "bobot" => 7.5
            ],
            [
                "kode" => "C3",
                "bobot" => 9
            ],
            [
                "kode" => "C4",
                "bobot" => 30
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
    [
        "nama" => "Firza",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 8.5
            ],
            [
                "kode" => "C2",
                "bobot" => 8
            ],
            [
                "kode" => "C3",
                "bobot" => 7.5
            ],
            [
                "kode" => "C4",
                "bobot" => 23
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
    [
        "nama" => "K.Carlie",
        "nilai" => [
            [
                "kode" => "C1",
                "bobot" => 7.5
            ],
            [
                "kode" => "C2",
                "bobot" => 10
            ],
            [
                "kode" => "C3",
                "bobot" => 9
            ],
            [
                "kode" => "C4",
                "bobot" => 37
            ],
            [
                "kode" => "C5",
                "bobot" => 8
            ]
        ]
    ],
];

$a = new wp($kriteria, $alternatif, 0);
$b = $a->ranking;
echo json_encode($a);
