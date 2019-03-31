<?php

class Game
{
    private $playerScore;
    private $opponentScore;
    private $playerChoice;
    private $opponentChoice;
    private $message;

    public function __construct()
    {
        $this->setPlayerScore();
        $this->setOpponentScore();
    }

    public function getPlayerScore()
    {
        return $this->playerScore;
    }

    public function setPlayerScore()
    {
        $_SESSION['win'] = (isset($_SESSION['win'])) ? $_SESSION['win'] : 0;
        $this->playerScore = $_SESSION['win'];
    }

    public function getOpponentScore()
    {
        return $this->opponentScore;
    }

    public function setOpponentScore()
    {
        $_SESSION['lose'] = (isset($_SESSION['lose'])) ? $_SESSION['lose'] : 0;        
        $this->opponentScore = $_SESSION['lose'];
    }

    public function getPlayerChoice()
    {
        return $this->playerChoice;
    }
    
    public function setPlayerChoice($value)
    {
        $this->playerChoice = $value;
    }

    public function getOpponentChoice()
    {
        return $this->opponentChoice;
    }
    
    public function setOpponentChoice()
    {
        $choices = ['r', 'p', 's'];
        $random = mt_rand(0, 2);

        $this->opponentChoice = $choices[$random];
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function convert($letter)
    {
        if ($letter === "r") return "Rock";
        if ($letter === "p") return "Paper";
        
        return "Scissors";
    }

    public function win()
    {
        $this->setMessage("
            {$this->convert($this->getPlayerChoice())} (you) beats 
            {$this->convert($this->getOpponentChoice())} (opponent).
            You win!
        ");
        
        $_SESSION['win']++;
        $this->playerScore++;
    }
    
    public function lose()
    {
        $this->setMessage("
            {$this->convert($this->getPlayerChoice())} (you) loses to 
            {$this->convert($this->getOpponentChoice())} (opponent).
            You lost...
        ");
        
        $_SESSION['lose']++;
        $this->opponentScore++;
    }

    public function draw() 
    {
        $this->setMessage("
            {$this->convert($this->getPlayerChoice())} (you) equals 
            {$this->convert($this->getOpponentChoice())} (opponent).
            It's a draw.
        ");
    }

    public function fight()
    {
        $this->setOpponentChoice();

        switch($this->getPlayerChoice() . '' . $this->getOpponentChoice()) {
            case 'rs':
            case 'pr':
            case 'sp':
                $this->win();
                break;
            case 'rp':
            case 'ps':
            case 'sr':
                $this->lose();
                break;
            case 'rr':
            case 'pp':
            case 'ss':
                $this->draw();
                break;
        }
    }

    public function isDone()
    {
        return !empty($_POST['choice']);
    }

}