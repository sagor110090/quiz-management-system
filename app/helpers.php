<?php

use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\SiteSetting;

function websiteName()
{
    return SiteSetting::first()->website_name;
}
function websiteLog()
{
    return SiteSetting::first()->website_logo;
}
function websiteFavicon()
{
    return SiteSetting::first()->website_favicon;
}
function random_code()
{
    return rand(1111, 9999);
}

function allUpper($str)
{
    return strtoupper($str);
}
function checkOwnStudent($student_id){
    if (auth()->user()->hasRole('admin')) {
        return true;
    }
    $check =  Classroom::where('teacher_id',auth()->user()->id)->whereHas('students', function ($query) use ($student_id) {
        $query->where('user_id', $student_id);
    })->first();
    if($check){
        return true;
    }else{
        return false;
    }


}
