<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        $books = [
            [
                'title' => 'Преступление и наказание',
                'author' => 'Федор Достоевский',
                'year' => 1866,
                'genre' => 'Роман',
                'rating' => 4.8
            ],
            [
                'title' => 'Мастер и Маргарита',
                'author' => 'Михаил Булгаков',
                'year' => 1967,
                'genre' => 'Роман',
                'rating' => 4.9
            ],
            [
                'title' => '1984',
                'author' => 'Джордж Оруэлл',
                'year' => 1949,
                'genre' => 'Антиутопия',
                'rating' => 4.7
            ]

        ];
        $newBook = [
            'title' => 'Гарри Поттер и философский камень',
            'author' => 'Джоан Роулинг',
            'year' => 1997,
            'genre' => 'Фэнтези',
            'rating' => 4.6
        ];
        $books[] = $newBook;
        $dostoevskyBooks = $this->findBooksByAuthor($books, 'Федор Достоевский');
        $genreStats = $this->getGenreStatistics($books);
        $sortedBooksAsc = $this->sortBooksByRating($books, 'asc');
        $sortedBooksDesc =$this->sortBooksByRating($books, 'desc');


        return view('test', [
            'books'=>$books,
            'dostoevskyBooks'=>$dostoevskyBooks,
            'genreStats'=>$genreStats,
            'sortedBooksAsc'=>$sortedBooksAsc,
            'sortedBooksDesc'=>$sortedBooksDesc
    ]);
    }

    private function findBooksByAuthor(array $books, string $authorName): array
    {
        return array_values(array_filter($books, fn($book) => ($book['author'] ?? '') === $authorName));
    }

    private function getGenreStatistics(array $books): array
    { $genreStats = [];
        foreach ($books as $book) {
            $genre=$book['genre'] ?? 'Unknown';
            $rating=$book['rating'] ?? 0;
            if (!isset($genreStats[$genre])) {
                $genreStats[$genre] = [
                    'sum' => 0,
                    'count' => 0
                ];
            }
                $genreStats[$genre]['sum']+=$rating;
                $genreStats[$genre]['count']+= 1;
            }

        return array_map(fn($data) => round($data['sum'] / $data['count'], 2), $genreStats);
    }

    private function sortBooksByRating(array $books, string $direction='asc'): array
    {
        $sorted=$books;
        usort($sorted, fn ($a,$b)=> $direction === 'asc'
        ? ($a['rating'] <=> $b['rating'])
            : ($b['rating'] <=> $a['rating'])
        );
            return $sorted;
    }

}
