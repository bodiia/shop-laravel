<?php

$book_list = [
    [
        'name' => 'Vadim',
        'surname' => 'Bodianskii',
        'book_id' => 1,
        'title' => 'Кладбище',
        'text' => 'Some test test test test',
        'rating' => 4,
        'release_year' => 2019
    ],
    [
        'name' => 'Sergei',
        'surname' => 'Kuklin',
        'book_id' => 1,
        'title' => 'Кладбище',
        'text' => 'Some test test test test',
        'rating' => 4,
        'release_year' => 2019
    ],
    [
        'name' => 'Stiven',
        'surname' => 'Hoking',
        'book_id' => 2,
        'title' => 'Под куполом',
        'text' => 'Под куполомПод куполомПод куполомПод куполом',
        'rating' => 6,
        'release_year' => 2016
    ]
];

function groupByAuthor(array $book_list)
{
    // $groupped = [];
    // foreach ($book_list as $book) {
    //     if (! isset($groupped[$book['book_id']])) {
    //         $groupped[$book['book_id']]['authors'][] = [
    //             'name' => $book['name'],
    //             'surname' => $book['surname']
    //         ];

    //         $groupped[$book['book_id']] = array_merge($groupped[$book['book_id']], [
    //             'book_id' => $book['book_id'],
    //             'title' => $book['title'],
    //             'text' => $book['text'],
    //             'rating' => $book['rating'],
    //             'release_year' => $book['release_year']
    //         ]);

    //     } else {
    //         $groupped[$book['book_id']]['authors'][] = [
    //             'name' => $book['name'],
    //             'surname' => $book['surname']
    //         ];
    //     }

    // }

    // return array_values($groupped);
}

header('Content-Type: application/json');
print_r(json_encode(groupByAuthor($book_list)));
