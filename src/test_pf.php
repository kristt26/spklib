<?php

require "ProfileMatchingNew.php";

use ocs\spklib\ProfileMatchingNew as PM;

$kriteria = [
    [
        'nama' => 'Kriteria 1',
        'code' => 'C1',
        'bobot' => 0.3,
        'sub' => [
            [
                'nama' => 'Sub 11',
                'code' => 'C11',
                'profileKriteria' => 4,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 12',
                'code' => 'C12',
                'profileKriteria' => 2,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 13',
                'code' => 'C13',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 14',
                'code' => 'C14',
                'profileKriteria' => 3,
                'status'=>'CF'
            ]

        ]
    ],
    [
        'nama' => 'Kriteria 2',
        'code' => 'C2',
        'bobot' => 0.25,
        'sub' => [
            [
                'nama' => 'Sub 21',
                'code' => 'C21',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 22',
                'code' => 'C22',
                'profileKriteria' => 2,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 23',
                'code' => 'C23',
                'profileKriteria' => 4,
                'status'=>'CF'
            ],
            [
                'nama' => 'Sub 23',
                'code' => 'C24',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
        ]
    ],
    [
        'nama' => 'Kriteria 3',
        'code' => 'C3',

        'bobot' => 0.2,
        'sub' => [
            [
                'nama' => 'Sub 31',
                'code' => 'C31',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 32',
                'code' => 'C32',
                'profileKriteria' => 3,
                'status'=>'CF'
            ],
            [
                'nama' => 'Sub 33',
                'code' => 'C33',
                'profileKriteria' => 2,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 34',
                'code' => 'C34',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
        ]
    ],
    [
        'nama' => 'Kriteria 4',
        'code' => 'C4',

        'bobot' => 0.15,
        'sub' => [
            [
                'nama' => 'Sub 41',
                'code' => 'C41',
                'profileKriteria' => 2,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 42',
                'code' => 'C42',
                'profileKriteria' => 2,
                'status'=>'CF'
            ],
            [
                'nama' => 'Sub 43',
                'code' => 'C43',
                'profileKriteria' => 4,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 44',
                'code' => 'C44',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
        ]
    ],
    [
        'nama' => 'Kriteria 5',
        'code' => 'C5',
        'bobot' => 0.1,
        'sub' => [
            [
                'nama' => 'Sub 51',
                'code' => 'C51',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 52',
                'code' => 'C52',
                'profileKriteria' => 3,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 53',
                'code' => 'C53',
                'profileKriteria' => 2,
                'status'=>'SF'
            ],
            [
                'nama' => 'Sub 54',
                'code' => 'C54',
                'profileKriteria' => 2,
                'status'=>'CF'
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
                        'code' => 'C11',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C12',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C13',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C14',
                        'nilai' => 4
                    ],
                ]
            ],
            [
                "code" => "C2",
                "sub" => [
                    [
                        'code' => 'C21',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C22',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C23',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C24',
                        'nilai' => 2
                    ],
                ]
            ],
            [
                "code" => "C3",
                "sub" => [
                    [
                        'code' => 'C31',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C32',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C33',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C34',
                        'nilai' => 4
                    ],
                ]
            ],
            [
                "code" => "C4",
                "sub" => [
                    [
                        'code' => 'C41',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C42',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C43',
                        'nilai' => 2
                    ],
                    [
                        'code' => 'C44',
                        'nilai' => 1
                    ],
                ]
            ],
            [
                "code" => "C5",
                "sub" => [
                    [
                        'code' => 'C51',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C52',
                        'nilai' => 2
                    ],
                    [
                        'code' => 'C53',
                        'nilai' => 5
                    ],
                    [
                        'code' => 'C54',
                        'nilai' => 2
                    ],
                ]
            ],
        ]
    ],
    [
        "nama" => "Nama2",
        "nilai" => [
            [
                "code" => "C1",
                "sub" => [
                    [
                        'code' => 'C11',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C12',
                        'nilai' => 2
                    ],
                    [
                        'code' => 'C13',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C14',
                        'nilai' => 5
                    ],
                ]
            ],
            [
                "code" => "C2",
                "sub" => [
                    [
                        'code' => 'C21',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C22',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C23',
                        'nilai' => 1
                    ],
                    [
                        'code' => 'C24',
                        'nilai' => 5
                    ],
                ]
            ],
            [
                "code" => "C3",
                "sub" => [
                    [
                        'code' => 'C31',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C32',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C33',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C34',
                        'nilai' => 4
                    ],
                ]
            ],
            [
                "code" => "C4",
                "sub" => [
                    [
                        'code' => 'C41',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C42',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C43',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C44',
                        'nilai' => 5
                    ],
                ]
            ],
            [
                "code" => "C5",
                "sub" => [
                    [
                        'code' => 'C51',
                        'nilai' => 4
                    ],
                    [
                        'code' => 'C52',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C53',
                        'nilai' => 3
                    ],
                    [
                        'code' => 'C54',
                        'nilai' => 4
                    ],
                ]
            ],
        ]
    ],
];

$a = new PM($kriteria, $alternatif, 0, true, 0);
echo json_encode($a);
