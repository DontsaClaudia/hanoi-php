<?php
require_once './class/disc.php';
require_once './class/tower.php';
require_once './class/game_exception.php';


class Game {
    protected $stacks;
    protected $turn;
    protected $isOver;

    public function init() {
        $this->stacks = array(
            new Tower(true),
            new Tower(),
            new Tower()
        );

        $this->turn = 0;
        $this->isOver = false;
    }

    public function move($from,$to) {
        if($from < 1 || $from > 3) throw new Exception('Invalid "from" number');
        if($this->stacks[$from-1]->isEmpty()) throw new GameException('Source tower is empty');
        if($to < 1 || $to > 3) throw new Exception('Invalid "to" number');
        
        $discFrom = $this->stacks[$from-1]->peek();
        if(!$this->stacks[$to-1]->isEmpty()) {
            $diskTo = $this->stacks[$to-1]->peek();
            if(!$diskTo->isGreaterThan($discFrom)) throw new GameException('Movement not allowed');
        } 
        
        $this->turn++;
        $disc = $this->stacks[$from-1]->pop();
        $this->stacks[$to-1]->push($disc);
        if($to-1 != 0 && $this->stacks[$to-1]->isFull()) {
            $this->isOver = true;
        }
    }

    public function isOver() {
        return $this->isOver;
    }

    public function getTurn() {
        return $this->turn;
    }

    public function getTower($i) {
        if($i<0 || $i>2) throw new Exception("Tower index error");
        return $this->stacks[$i];
    }
} 