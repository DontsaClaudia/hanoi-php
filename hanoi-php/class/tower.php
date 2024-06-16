<?php

require_once './class/disc.php';

class Tower {
    protected $stack = [];

    public function __construct($full = false) {
        if(!$full) return;
        for($i=7;$i>0;$i--) {
            $this->push(new Disc($i));
        }
    }

    public function push($disc) {
        if($this->isFull()) throw new Exception("Stack is full, can't push");
        $this->stack[] = $disc;
    }

    public function pop() {
        if($this->isEmpty()) throw new Exception("Stack is empty, can't pop");
        $last = array_pop($this->stack);
        return $last;
    }

    public function isEmpty() {
        return count($this->stack) == 0;
    }

    public function isFull() {
        return count($this->stack) == 7;
    }

    public function peek() {
        if($this->isEmpty()) throw new Exception("Can't peek in empty stack");
        return $this->stack[count($this->stack)-1];
    }

    public function size() {
        return count($this->stack);
    }

    public function draw() {
        ?>
        <div class="tower">
        <?php
        foreach($this->stack as $disc) {
            $disc->draw();
        }
        ?>
        </div>
        <?php
    }
}