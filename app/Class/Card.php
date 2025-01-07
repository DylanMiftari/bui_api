<?php

namespace App\Class;

use JsonSerializable;
class Card implements JsonSerializable {

    private int $color;
    private int $value;

    public function __construct(int $color, int $value) {
        $this->color = $color;
        $this->value = $value;
    }

    public function getColor() {
        return $this->color;
    }
    public function getValue() {
        return $this->value;
    }

    public function jsonSerialize(): array {
        return [
            "color" => $this->getColor(),
            "value" => $this->getValue(),
        ];
    }
}