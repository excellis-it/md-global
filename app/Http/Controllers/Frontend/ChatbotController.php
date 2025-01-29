<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Symptoms;
use App\Models\User;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{

    public function handle()
    {
        $botman = app('botman');

        // Check if the user session exists and if the question has already been asked
        if (!Auth::check()) {
            if (!session()->has('asked_user_question')) {
                $botman->hears('{message}', function (BotMan $bot, $message) {
                    \Log::info('Start command received'); // Debugging statement

                    // Ask the user if they are an existing user
                    $bot->ask('<p>Hello! Are you an existing user?</p> <div class="row">
        <div class="col-md-12"> <button class="btn w-100 mb-2 reply-mes" style="border-radius: 25px; color: #fff;
    background-color: #2782ff; border:none;" data-response="Yes">Yes</button></div>
        <div class="col-md-12"> <button class="btn btn-danger w-100 reply-mes" style="border-radius: 25px; color: #fff;
    background-color: #000; border:none;" data-response="No">No</button></div>
    </div>', function (Answer $answer, $bot) {
                        $response = strtolower(trim($answer->getText()));

                        // Validate the user response
                        if (!in_array($response, ['yes', 'no'])) {
                            $bot->repeat('Please reply with "Yes" or "No".');
                            return;
                        }

                        if ($response === 'yes') {
                            $bot->say('Great! Please login to your account to continue <a href="' . route('login') . '" target="_blank">here</a>.');
                            if (Auth::check()) {
                                session(['asked_user_question' => true]);
                            }
                        } elseif ($response === 'no') {
                            $bot->say('No problem! Let\'s get you registered.');
                            $chatBotController = new ChatbotController();
                            $chatBotController->registerUser();
                        }
                    });
                });
            } else {
                // If the user has already been asked, handle health queries directly
                $this->handleHealthQueries();
            }
        } else {
            // If the user is already logged in, handle health queries directly
            $this->handleHealthQueries();
        }

        $botman->fallback(function ($bot) {
            $bot->reply('Sorry, I did not understand that. Can you please rephrase your health-related inquiry?');
        });

        $botman->listen();
    }


    public function registerUser()
    {
        $botman = app('botman');

        // Ask for user details
        $botman->ask('What is your first name?', function (Answer $answer, $bot) {
            $first_name = $answer->getText(); // Get the user's first name

            $bot->ask('What is your last name?', function (Answer $answer, $bot) use ($first_name) {
                $last_name = $answer->getText(); // Get the user's last name

                // Ask for email
                $bot->ask('What is your email address?', function (Answer $answer, $bot) use ($first_name, $last_name) {
                    $email = $answer->getText();

                    // Validate the email
                    $validator = Validator::make(['email' => $email], [
                        'email' => 'required|email|unique:users,email',
                    ]);

                    if ($validator->fails()) {
                        return $bot->repeat($validator->errors()->first());
                    }

                    // Ask for phone number
                    $bot->ask('What is your phone number?', function (Answer $answer, $bot) use ($first_name, $last_name, $email) {
                        $phone = $answer->getText();

                        // Validate the phone
                        $validator = Validator::make(['phone' => $phone], [
                            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                        ]);

                        if ($validator->fails()) {
                            return $bot->repeat($validator->errors()->first());
                        }

                        // Ask for age
                        $bot->ask('What is your age?', function (Answer $answer, $bot) use ($first_name, $last_name, $email, $phone) {
                            $age = $answer->getText();

                            $validator = Validator::make(['age' => $age], [
                                'age' => 'required|numeric|min:1',
                            ]);

                            if ($validator->fails()) {
                                return $bot->repeat($validator->errors()->first());
                            }

                            // Ask for gender
                            $bot->ask('<p>What is your gender?</p>
<div class="row">
    <div class="col-md-12">

        <button class="btn w-100 mb-2 reply-mes" style="border-radius: 25px; color: #fff;
background-color: #2782ff; border:none;" data-response="male">Male</button>

</div>
    <div class="col-md-12">
        <button class="btn btn-danger w-100 reply-mes" style="border-radius: 25px; color: #fff;
background-color: #000; border:none;" data-response="female">Female</button>
</div>
    <div class="col-md-12 mt-2">
        <button class="btn btn-danger w-100 reply-mes" style="border-radius: 25px; color: #fff;
background-color: #812626; border:none;" data-response="other">Other</button>
</div>
</div>', function (Answer $answer, $bot) use ($first_name, $last_name, $email, $phone, $age) {
                                $gender = strtolower($answer->getText());

                                $validator = Validator::make(['gender' => $gender], [
                                    'gender' => 'required|in:male,female,other',
                                ]);

                                if ($validator->fails()) {
                                    return $bot->repeat($validator->errors()->first());
                                }

                                // Ask for password
                                $bot->ask('Please enter a password', function (Answer $answer, $bot) use ($first_name, $last_name, $email, $phone, $age, $gender) {
                                    $password = $answer->getText();

                                    $validator = Validator::make(['password' => $password], [
                                        'password' => 'required|min:8|max:20',
                                    ]);

                                    if ($validator->fails()) {
                                        return $bot->repeat($validator->errors()->first());
                                    }


                                    // Ask for user type
                                    $bot->ask('<p>Are you aMedical Staff or a Patient?</p><div class="row">
        <div class="col-md-12"> <button class="btn w-100 mb-2 reply-mes" style="border-radius: 25px; color: #fff;
    background-color: #2782ff; border:none;" data-response="Doctor">Doctor</button></div>
        <div class="col-md-12"> <button class="btn btn-danger w-100 reply-mes" style="border-radius: 25px; color: #fff;
    background-color: #000; border:none;" data-response="Patient">Patient</button></div>
    </div>', function (Answer $answer, $bot) use ($first_name, $last_name, $email, $phone, $age, $gender, $password) {
                                        $type = ucfirst(strtolower($answer->getText()));

                                        $validator = Validator::make(['type' => $type], [
                                            'type' => 'required|in:Doctor,Patient',
                                        ]);

                                        if ($validator->fails()) {
                                            return $bot->repeat($validator->errors()->first());
                                        }

                                        // Create and save the user
                                        $user = new User();
                                        $user->name = $first_name . ' ' . $last_name;
                                        $user->gender = $gender;
                                        $user->age = $age;
                                        $user->phone = $phone;
                                        $user->email = $email;
                                        $user->password = bcrypt($password);
                                        $user->status = $type == 'Doctor' ? 0 : 1;
                                        $user->save();

                                        $user->assignRole($type == 'Doctor' ? 'DOCTOR' : 'PATIENT');

                                        $message = $type == 'Doctor' ? 'Medical Stuff registration successful. Please wait for admin approval.' : 'Patient registration successful. Please login to continue.';
                                        $bot->say($message);
                                        $bot->say('Great! Please login to your account to continue <a href="' . route('login') . '" target="_blank">here</a>.');
                                        session(['asked_user_question' => true]);
                                        (new ChatbotController())->handleHealthQueries();
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    }





    public function handleHealthQueries() // Remove the static keyword
    {
        $bot = app('botman');
        $specializations = Specialization::all()->pluck('name', 'id')->toArray();
        $symptomList = Symptoms::all()->pluck('symptom_name', 'id')->toArray();

        $bot->hears('{message}', function (BotMan $bot, $message) use ($specializations, $symptomList) {
            $reply = '';

            // Check for symptoms in the database
            foreach ($symptomList as $symptomId => $symptomName) {
                if (stripos($message, $symptomName) !== false) {
                    $this->findDoctorsBySymptom($bot, $symptomId, $symptomName);
                    return; // Exit once we have handled the symptom
                }
            }

            // Check for specializations in the database
            foreach ($specializations as $specializationId => $specializationName) {
                if (stripos($message, $specializationName) !== false) {
                    $this->findDoctorsBySpecialization($bot, $specializationId, $specializationName);
                    return; // Exit once we have handled the specialization
                }
            }

            // Attempt Gemini API with a focus on health-related queries
            $this->handleSearchPageQuery($bot, $message);
        });
    }




    public function findDoctorsBySymptom(BotMan $bot, $symptomId, $symptomName)
    {
        $symptomRecord = Symptoms::find($symptomId);
        if ($symptomRecord && $symptomRecord->specialization) {
            $specializationId = $symptomRecord->specialization->id;
            $doctors = User::role('DOCTOR')->with('specializations')
                ->whereHas('specializations', function ($query) use ($specializationId) {
                    $query->where('specialization_id', $specializationId);
                })->get();

            if ($doctors->count()) {
                $reply = 'Here are some doctors who specialize in this area:<br><br>';
                foreach ($doctors as $doctor) {
                    $reply .= $this->formatDoctorInfo($doctor);
                }
                $bot->reply($reply);
            } else {
                $bot->reply("I'm sorry, but I couldn't find any doctors specializing in {$symptomName}. Please try another symptom or specialization.");
            }
        }
    }

    public function findDoctorsBySpecialization(BotMan $bot, $specializationId, $specializationName)
    {
        $doctors = User::role('DOCTOR')->with('specializations')
            ->whereHas('specializations', function ($query) use ($specializationId) {
                $query->where('specialization_id', $specializationId);
            })->get();

        if ($doctors->count()) {
            $reply = 'Here are some doctors who specialize in this area:<br><br>';
            foreach ($doctors as $doctor) {
                $reply .= $this->formatDoctorInfo($doctor);
            }
            $bot->reply($reply);
        } else {
            $bot->reply("I'm sorry, but I couldn't find any doctors specializing in {$specializationName}. Please try another symptom or specialization.");
        }
    }

    public function formatDoctorInfo($doctor)
    {
        $profilePicture = $doctor->profile_picture
            ? Storage::url($doctor->profile_picture)
            : asset('frontend_assets/images/profile.png');
        $specializationNames = $doctor->specializations->pluck('name')->implode(', ');

        return "
        <div style='display: flex; align-items: center; margin-bottom: 10px;'>
            <img src='{$profilePicture}' style='width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;' alt='{$doctor->name}'>
            <div>
                <strong><a href='" . route('booking-and-consultancy', encrypt($doctor->id)) . "' target='_blank'>{$doctor->name}</a></strong><br>
                <span>Specialization: {$specializationNames}</span>
            </div>
        </div>
        ";
    }

    public function handleSearchPageQuery(BotMan $bot, $message)
    {
        if (preg_match('/\b(telehealth|contact(?:\s+us)?|plan|qa\/blogs|subscription|membership|connect|address|phone|email)\b/i', $message)) {
            if (preg_match('/\btelehealth\b/i', $message)) {
                $bot->reply("Looking for telehealth services? Here’s the link: <a href='" . route('telehealth') . "'>Telehealth</a>");
                return;
            }

            if (preg_match('/\b(plan|subscription|membership)\b/i', $message)) {
                $bot->reply("Explore our membership plans: <a href='" . route('membership-plans') . "'>Plans</a>");
                return;
            }

            if (preg_match('/\b(contact|connect|address|phone|email)\b/i', $message)) {
                $bot->reply("Need assistance? Contact us here: <a href='" . route('contact-us') . "'>Contact Us</a>");
                return;
            }

            if (preg_match('/\bqa\/blog\b/i', $message)) {
                $bot->reply("Check out our Q&A or Blogs: <a href='" . route('blogs') . "'>Q&A / Blogs</a>");
                return;
            }
        }

        $this->handleGeminiQuery($bot, $message);
    }



    public function handleGeminiQuery(BotMan $bot, $message)
    {
        // Attempt Gemini API with a focus on health-related queries
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY'), [
                'contents' => [
                    'parts' => [
                        'text' => $message,
                    ],
                ],
            ]);

            // Check for API response status
            if ($response->failed()) {
                $errorResponse = $response->json();
                $statusCode = $response->status();

                if ($statusCode === 503) {
                    // Handle service unavailable error
                    $bot->reply("The model is currently overloaded. Please try again later.");
                    return;
                } else {
                    // Log and handle other errors
                    Log::error('Gemini API Error: ' . $errorResponse['message']);
                    $bot->reply("I'm currently experiencing high traffic and cannot process requests right now. Please try again later.");
                    return;
                }
            }

            $medicalResponse = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
            Log::info($response);

            // Filter non-health-related responses using a corrected regex pattern
            if ($medicalResponse) {
                if (preg_match('/\b(health|healthcare|medicine|symptoms|doctor|pain|treatment|doctor|specialization|hospital|clinic|nurse|pharmacy)\b/i', $medicalResponse)) {
                    $formattedResponse = $this->convertBulletsToNumbers($medicalResponse);
                    // Display with line breaks in HTML
                    $bot->reply(nl2br($formattedResponse));
                } else {
                    $bot->reply('I am not sure what you are asking. Can you please ask about health-related topics?');
                }
            } else {
                $bot->reply("I'm currently experiencing high traffic and cannot process requests right now. Please try asking about symptoms or specializations directly, or try again later.");
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $bot->reply("I'm currently experiencing high traffic and cannot process requests right now. Please try asking about symptoms or specializations directly, or try again later.");
        }
    }


    public function convertBulletsToNumbers($text)
    {
        $lines = explode("\n", $text); // Split text into lines
        $count = 1;

        foreach ($lines as &$line) {
            // Check if the line starts with a bullet point
            if (preg_match('/^\* /', $line)) {
                $line = $count . ". " . substr($line, 2); // Replace '*' with the current number
                $count++;
            }
        }

        // Remove * from the whole text
        $text = str_replace('*', '', implode("\n", $lines));
        return $text;
    }
}
