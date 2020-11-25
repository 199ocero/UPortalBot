<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;

class StudentInformation extends Model{

    public $timestamps = false;
    protected $table = 'student_information';
    protected $fillable = [
        'facebookID',
        'studentID',
        'firstName',
        'lastName',
        'middleName',
        'dateofBirth',
        'placeofBirth',
        'civilStatus',
        'gender',
        'age',
        'nationality',
        'religion',
        'email',
        'contactNumber',
        'address'
    ];
    protected $primaryKey = 'facebookID';
}