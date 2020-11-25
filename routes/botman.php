<?php
use App\Http\Controllers\BotManController;
use Symfony\Component\Console\Question\Question;
use BotMan\Drivers\Facebook\Extensions\Element as Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton as ElementButton;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate as ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate as GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate as ListTemplate;

$botman = resolve('botman');




/*
|--------------------------------------------------------------------------
| Facebook Get Started
|--------------------------------------------------------------------------
|
*/

$botman->hears('get_started|Get Started', function ($bot) {
    $bot->typesAndWaits(1);
    $firstName = $bot->getUser()->getFirstName();
    $senderId = $bot->getUser()->getId();
    $bot->reply("Hi $firstName 👋!\n\nI think this is your first time using this chatbot right?\n\nI am 🤖UPortal🤖 giving you free access to University website.\n\nNow, I will give your Facebook ID and you just have to present it to the registrar.");
    $bot->reply('Facebook ID: '.$senderId);
});

/*
|--------------------------------------------------------------------------
| Facebook Personal Persistent Menu
|--------------------------------------------------------------------------
|
*/

$botman->hears('set_personal|Personal', function ($bot) {
    $bot->reply(ButtonTemplate::create('Please choose what type of information you want to check:')
            ->addButton(
                ElementButton::create('Student Information')
                    ->type('postback')
                    ->payload('student_information')
            )
            ->addButton(
                ElementButton::create('Grades')
                    ->type('postback')
                    ->payload('grades')
            )
    );
});

/*
|--------------------------------------------------------------------------
| Facebook Personal Persistent Menu (Student Information)
|--------------------------------------------------------------------------
|
*/

$botman->hears('student_information|Student Information', function ($bot) {
    $input = json_decode(file_get_contents('php://input'), true);
    $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
    $studentsData = json_decode(file_get_contents('https://my-json-server.typicode.com/199ocero/schoolDatabase/student_information/3308077482632477'), true);

    
    if (!empty($studentsData)) {
        $studentID = $studentsData['studentID'];
        $firstName = $studentsData['firstName'];
        $lastName = $studentsData['lastName'];
        $middleName = $studentsData['middleName'];
        $dateofBirth = $studentsData['dateofBirth'];
        $placeofBirth = $studentsData['placeofBirth'];
        $civilStatus = $studentsData['civilStatus'];
        $gender = $studentsData['gender'];
        $nationality = $studentsData['nationality'];
        $religion = $studentsData['religion'];
        $email = $studentsData['email'];
        $contactNo = $studentsData['contactNo'];
        $address = $studentsData['address'];
        $bot->reply("ℹ️ Student Information ℹ️\n\n▶️Student ID: $studentID\n▶️First Name: $firstName\n▶️Last Name: $lastName\n▶️Middle Name: $middleName\n▶️Date of Birth: $dateofBirth\n▶️Place of Birth: $placeofBirth\n▶️Civil Status: $civilStatus\n▶️Gender: $gender\n▶️Nationality: $nationality\n▶️Religion: $religion\n▶️Email: $email\n▶️Contact No: $contactNo\n▶️Addess: $address\n\nNote: This is a temporay data to show only the functionality of our chatbot.");
    } else {
        $bot->reply("Facebook ID is not yet registered. Please go to registrar's office.");
    }
});

/*
|--------------------------------------------------------------------------
| Facebook Personal Persistent Menu (Grades - Disabled Feature)
|--------------------------------------------------------------------------
|
*/

$botman->hears('grades', function ($bot) {
    $bot->reply('Grades function is temporarily unavailable.');
});

// $botman->hears('grades', function ($bot) {
//     $bot->reply(
//         ButtonTemplate::create('Please select a year:')
//             ->addButton(
//                 ElementButton::create('1st-2nd Year College')
//                     ->type('postback')
//                     ->payload('first_second_year_college')
//             )
//             ->addButton(
//                 ElementButton::create('3rd-4th Year College')
//                     ->type('postback')
//                     ->payload('third_fourth_year_college')
//             )
//             ->addButton(
//                 ElementButton::create('5th Year College')
//                     ->type('postback')
//                     ->payload('fifth_year_college')
//             )

//     );
// });

// /*
// |--------------------------------------------------------------------------
// | Facebook Personal Persistent Menu (Grades - 1st-2nd Year College)
// |--------------------------------------------------------------------------
// |
// */

// $botman->hears('first_second_year_college', function ($bot) {
//     $bot->reply(
//         ButtonTemplate::create('Please select a year:')
//             ->addButton(
//                 ElementButton::create('1st Year College')
//                     ->type('postback')
//                     ->payload('first_year_college')
//             )
//             ->addButton(
//                 ElementButton::create('2nd Year College')
//                     ->type('postback')
//                     ->payload('second_year_college')
//             )

//     );
// });

// $botman->hears('first_year_first_semester_grade', function ($bot) {
//     $input = json_decode(file_get_contents('php://input'), true);
//     $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
//     $studentsData = json_decode(file_get_contents('https://my-json-server.typicode.com/199ocero/schoolDatabase/check_grades/' . $senderId), true);
//     if (!empty($studentsData)) {
//         $studentID = $studentsData['studentID'];
//         $firstName = $studentsData['firstName'];
//         $lastName = $studentsData['lastName'];
//         $academic_year = $studentsData['academic_year'];
//         $semester = $studentsData['semester'];
//         $arrayLength = count($studentsData['grades']);

//         $answer = '';
//         for ($x = 0; $x < $arrayLength; $x++) {
//             $code = $studentsData['grades'][$x]['code'];
//             $name = $studentsData['grades'][$x]['name'];
//             $unit = $studentsData['grades'][$x]['unit'];
//             $grade_type = $studentsData['grades'][$x]['grade_type'];
//             $grade_value = $studentsData['grades'][$x]['grade_value'];
//             $remarks = $studentsData['grades'][$x]['remarks'];
//             $answer = "✅Subject: $code - $name\n\nUnit: $unit\nGrade Type: $grade_type\nGrade Value: $grade_value\nRemarks: $remarks\n\n".$answer;
//         }
//         $bot->reply("ℹ️ Student Grade ℹ️\n\n▶️Student ID: $studentID\n▶️First Name: $firstName\n▶️Last Name: $lastName\n\n".$answer);
//     } else {
//         $bot->reply("Facebook ID is not yet registered. Please go to registrar's office.");
//     }
// });

/*
|--------------------------------------------------------------------------
| Facebook School Persistent Menu
|--------------------------------------------------------------------------
|
*/

$botman->hears('set_school|School', function ($bot) {
    $bot->reply(
        ButtonTemplate::create('Please choose what type of information you want to check:')
            ->addButton(
                ElementButton::create('COR')
                    ->type('postback')
                    ->payload('cor')
            )
            ->addButton(
                ElementButton::create('Tasks & Deadlines')
                    ->type('postback')
                    ->payload('task_and_dealines')
            )
    );
});


$botman->hears('cor', function ($bot) {
    $bot->reply('COR function is temporarily unavailable.');
});


$botman->hears('task_and_dealines', function ($bot) {
    $bot->reply('Tasks & Deadlines function is temporarily unavailable.');
});

