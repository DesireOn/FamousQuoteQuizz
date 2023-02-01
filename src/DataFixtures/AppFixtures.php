<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\QuestionSuggestion;
use App\Entity\Visitor;
use App\Entity\VisitorHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private array $quizData = [
        'I have a dream' => [
            [
                'answer' => 'Martin Luther King Jr.',
                'isCorrect' => true
            ],
            [
                'answer' => 'Rosa Parks',
                'isCorrect' => false
            ],
            [
                'answer' => 'Nelson Mandela',
                'isCorrect' => false
            ],
        ],
        'Be the change you wish to see in the world' => [
            [
                'answer' => 'Mahatma Gandhi',
                'isCorrect' => true
            ],
            [
                'answer' => 'Jawaharlal Nehru',
                'isCorrect' => false
            ],
            [
                'answer' => 'Sardar Vallabhbhai Patel',
                'isCorrect' => false
            ],
        ],
        'Imagine' => [
            [
                'answer' => 'John Lennon',
                'isCorrect' => true
            ],
            [
                'answer' => 'Bob Dylan',
                'isCorrect' => false
            ],
            [
                'answer' => 'Freddie Mercury',
                'isCorrect' => false
            ],
        ],
        'The best and most beautiful things in the world cannot be seen or even touched - they must be felt with the heart' => [
            [
                'answer' => 'Helen Keller',
                'isCorrect' => true
            ],
            [
                'answer' => 'Stephen Hawking',
                'isCorrect' => false
            ],
            [
                'answer' => 'Marlee Matlin',
                'isCorrect' => false
            ],
        ],
        'The only limit to our realization of tomorrow will be our doubts of today.' => [
            [
                'answer' => 'Franklin D. Roosevelt',
                'isCorrect' => true
            ],
            [
                'answer' => 'Abraham Lincoln',
                'isCorrect' => false
            ],
            [
                'answer' => 'George Washington',
                'isCorrect' => false
            ],
        ],
        'Success is not final, failure is not fatal: it is the courage to continue that counts.' => [
            [
                'answer' => 'Winston Churchill',
                'isCorrect' => true
            ],
            [
                'answer' => 'Margaret Thatcher',
                'isCorrect' => false
            ],
            [
                'answer' => 'Tony Blair',
                'isCorrect' => false
            ],
        ],
        'Art is not what you see, but what you make others see.' => [
            [
                'answer' => 'Edgar Degas',
                'isCorrect' => true
            ],
            [
                'answer' => 'Vincent van Gogh',
                'isCorrect' => false
            ],
            [
                'answer' => 'Pablo Picasso',
                'isCorrect' => false
            ],
        ],
        "Don't watch the clock; do what it does. Keep going." => [
            [
                'answer' => 'Sam Levenson',
                'isCorrect' => true
            ],
            [
                'answer' => 'Mark Twain',
                'isCorrect' => false
            ],
            [
                'answer' => 'George Carlin',
                'isCorrect' => false
            ],
        ],
        'A hero is someone who understands the responsibility that comes with his freedom.' => [
            [
                'answer' => 'Bob Dylan',
                'isCorrect' => true
            ],
            [
                'answer' => 'Joni Mitchell',
                'isCorrect' => false
            ],
            [
                'answer' => 'Bob Marley',
                'isCorrect' => false
            ],
        ],
        "In three words I can sum up everything I've learned about life: it goes on." => [
            [
                'answer' => 'Robert Frost',
                'isCorrect' => true
            ],
            [
                'answer' => 'Maya Angelou',
                'isCorrect' => false
            ],
            [
                'answer' => 'Langston Hughes',
                'isCorrect' => false
            ],
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->quizData as $questionName => $options) {
            $question = new Question();
            $question->setName($questionName);
            $manager->persist($question);

            foreach ($options as $option) {
                $answer = new Answer();
                $answer->setName($option['answer']);
                $manager->persist($answer);

                $questionSuggestion = new QuestionSuggestion();
                $questionSuggestion->setQuestion($question);
                $questionSuggestion->setAnswer($answer);
                $questionSuggestion->setIsCorrect($option['isCorrect']);

                $question->addQuestionSuggestion($questionSuggestion);
                $manager->persist($questionSuggestion);
            }

            $visitor = new Visitor();
            $manager->persist($visitor);

            $questionSuggestions = $question->getQuestionSuggestions();
            foreach ($questionSuggestions as $questionSuggestion) {
                $answer = $questionSuggestion->getAnswer();

                $visitorHistory = new VisitorHistory();
                $visitorHistory->setVisitor($visitor);
                $visitorHistory->setQuestion($question);
                $visitorHistory->setAnswer($answer);
                $manager->persist($visitorHistory);
            }
        }

        $manager->flush();
    }
}
