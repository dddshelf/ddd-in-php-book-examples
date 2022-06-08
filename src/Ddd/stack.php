<?php

class Stack
{
    private $head;
    private $size = 0;

    public function push($value)
    {
        $this->head = $this->head ?
            new Node($value, $this->head) :
            new Node($value);
        $this->size++;
    }

    public function pop()
    {
        $value = $this->head->value;
        $this->head = $this->head->next;
        $this->size--;

        return $value;
    }

    public function top()
    {
        return $this->head->value;
    }

    public function size()
    {
        return $this->size;
    }
}

class Node
{
    public $next;
    public $value;

    public function __construct($value, $next = null)
    {
        $this->value = $value;
        $this->next = $next;
    }
}

$s = new Stack();
$s->push(1);
$s->push(2);
$s->push(3);
assert($s->size() === 3);
assert($s->top() === 3);
assert($s->pop() === 3);
assert($s->pop() === 2);
assert($s->pop() === 1);


$s2 = new Stack();
assert($s2->size() === 0);
