<?php

namespace App\Exhibition\CreateOrUpdate;


class Request
{
    public $id; // null if create, else if edit 
    public $name;
    public $description;
}