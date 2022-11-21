<?php

function sendWebhookAbsensi($content) {
    $url = env('WEBHOOK_URL','https://discord.com/api/webhooks/1044070660382662716/D_Z2HtRpeLsNyJVWuo7jtHizPEAutTQTkhuc9y4WAwDa-ZNJIgmo3z474TjK3LNwCLnH');

    $color = 'FFFFFF';
    $user = $content['user'];
    $status_presensi = config('custom.status_presensi.'.$content['status']);
    $keterangan = $content['keterangan'];

    /**
     * 'status_presensi' => [
            '1' => 'Hadir',
            '2' => 'Izin',
            '3' => 'Sakit',
            '4' => 'WFH',
        ],
     */
    
    switch ($content['status']) {
        case '2':
            $color = '610C63';
            break;

        case '3':
            $color = 'FF1E1E';
            break;

        case '4':
            $color = '4284f5';
            break;
        
        default:
            break;
    }

    $hookObject = json_encode([
        "embeds" => [
            [
                "title" => 'Absensi '.$status_presensi,
                "timestamp" => date('c'),
                "color" => hexdec( $color ),
                "footer" => [
                    "text" => "@".date('Y').". OP Ticketing Nore",
                ],
                "thumbnail" => [
                    "url" => 'https://op.nore.web.id/global_assets/images/nore_w_1000px.png'
                ],
                "fields" => [
                    [
                        "name" => "Nama",
                        "value" => $user->nama,
                        "inline" => true
                    ],
                    [
                        "name" => "Divisi",
                        "value" => config('custom.role.'.$user->role),
                        "inline" => true
                    ],
                    [
                        "name" => "Keterangan",
                        "value" => strip_tags($keterangan),
                        "inline" => false
                    ],
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

    $ch = curl_init();

    curl_setopt_array( $ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $hookObject,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec( $ch );
    curl_close( $ch );

}