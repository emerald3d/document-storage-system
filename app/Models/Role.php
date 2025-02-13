<?php

namespace App\Models;

//Такое можно вообще в этой директории хранить?
enum Role: int
{
    case Admin = 1;
    case User = 2;
}
