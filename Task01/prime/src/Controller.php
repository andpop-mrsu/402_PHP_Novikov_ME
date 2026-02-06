<?php

namespace Darkflade\Prime\Controller;

use function Darkflade\Prime\View\showMenu;
use function Darkflade\Prime\View\askName;
use function Darkflade\Prime\View\showQuestion;
use function Darkflade\Prime\View\showResult;
use function Darkflade\Prime\View\showHistoryTable;
use function Darkflade\Prime\Model\getGameNumber;
use function Darkflade\Prime\Model\isPrime;
use function Darkflade\Prime\Model\getDivisors;
use function Darkflade\Prime\Model\saveGameResult;
use function Darkflade\Prime\Model\getGameHistory;

function startGame()
{
    $name = askName();

    while (true) {
        $choice = showMenu();

        switch ($choice) {
            case '1':
                playRound($name);
                break;
            case '2':
                $history = getGameHistory();
                showHistoryTable($history);
                break;
            case '3':
                break 2;
            default:
                \cli\line("Invalid option.");
                break;
        };
    }
}

function playRound($name)
{
    $number = getGameNumber();
    $numberIsPrime = isPrime($number);

    $userAnswerRaw = showQuestion($number);
    $userSaysYes = in_array(strtolower($userAnswerRaw), ['yes', 'y', 'da', 'aboba']);

    $isCorrect = ($userSaysYes && $numberIsPrime) || (!$userSaysYes && !$numberIsPrime);

    $divisors = [];
    if (!$isCorrect && !$numberIsPrime) {
        $divisors = getDivisors($number);
    }

    showResult($isCorrect, $divisors);

    saveGameResult($name, $number, $isCorrect);
}
