<?php

return [
    'rankings' => [
        'home' => [
            "top"     => 1,
            "display" => [
                ['title' => 'R.Diários', 'table' => 'Character', 'column' => 'Resets', 'tag' => 'RR'],
                ['title' => 'R.Semanais', 'table' => 'Character', 'column' => 'ResetsWeek', 'tag' => 'WR'],
                ['title' => 'R.Mensais', 'table' => 'Character', 'column' => 'ResetsMonth', 'tag' => 'MR'],
                ['title' => 'Blood Castle', 'table' => 'RankingBloodCastle', 'column' => 'Score', 'tag' => 'BC'],
                ['title' => 'Guild', 'table' => 'Guild', 'column' => 'G_Score', 'tag' => 'Score'],
            ],
        ],
        'geral' => [
            ['title' => 'R.Diários', 'table' => 'Character', 'column' => 'Resets', 'tag' => 'RR', 'slug' => 'resets-diario'],
            ['title' => 'R.Semanais', 'table' => 'Character', 'column' => 'ResetsWeek', 'tag' => 'WR', 'slug' => 'resets-semanal'],
            ['title' => 'R.Mensais', 'table' => 'Character', 'column' => 'ResetsMonth', 'tag' => 'MR', 'slug' => 'resets-mensal'],
            ['title' => 'Blood Castle', 'table' => 'RankingBloodCastle', 'column' => 'Score', 'tag' => 'BC', 'slug' => 'blood-castle'],
            ['title' => 'Guild', 'table' => 'Guild', 'column' => 'G_Score', 'tag' => 'Score', 'slug' => 'guild'],
        ],
    ],
];
