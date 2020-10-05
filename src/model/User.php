<?php 

class User extends Model 
{
    protected static $table = 'users';
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin',
    ];
    protected static $public = [
        'id',
        'name',
    ];

}

