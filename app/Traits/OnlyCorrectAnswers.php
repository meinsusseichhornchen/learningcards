<?php


namespace App\Traits;


trait OnlyCorrectAnswers
{
    public static function parseToCorrectAnswers(array $answers = []) {
        $records = [];

        foreach ($answers as $answer) {
            $records[] = [
                'content' => $answer,
                'correct' => true,
            ];
        }

        return $records;
    }
}