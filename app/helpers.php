<?php

function currency($expression) {
    return number_format($expression,0,',','.');
}