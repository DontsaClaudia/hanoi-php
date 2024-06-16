<?php

class Disc  {
    protected $size;

    public function __construct($size) {
        if($size<1 || $size>7) throw new Exception("Invalid disc size");
        $this->size = $size;
    }

    public function size() {
        return $this->size;
    }

    public function isGreaterThan(Disc $disc) {
        return $this->size > $disc->size();
    }

    public function draw() {
        ?>
        <div class="disc">
            <div class="disc-<?php echo $this->size;?>"></div>
        </div>
        <?php
    }
}