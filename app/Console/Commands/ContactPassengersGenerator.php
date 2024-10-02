<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContactPassengersGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contact-passengers-generator {--c|count=1 : The number of passenger to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate contact and passengers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->option('count');

        $passengers = [];

        $email = fake()->email;
        $title = fake()->randomElement(['MR', 'MRS', 'MISS']);
        $firstName = fake()->firstName;
        $lastName = fake()->lastName;
        $phoneNumber = fake()->numerify('62##########'); //fake()->phoneNumber;
        $mobilePhoneNumber = fake()->numerify('62##########');
        $emergencyFullName = fake()->firstName . ' ' . fake()->lastName;
        $emergencyPhone = fake()->numerify('62##########');
        $emergencyEmail = fake()->email;

        $contact = [
            "email" => $email,
            "title" => $title,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "home_phone" => $phoneNumber,
            "mobile_phone" => $mobilePhoneNumber
        ];

        for ($i = 0; $i < $count; $i++) {
            $passenger = [
                "index" => $i + 1,
                "type" => 1,
                "title" => ($i === 0) ? $title : fake()->randomElement(['MR', 'MRS', 'MISS']),
                "first_name" => ($i === 0) ? $firstName : fake()->firstName,
                "last_name" => ($i === 0) ? $lastName : fake()->lastName,
                "is_senior_citizen" => true,
                "birth_date" => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                "email" => ($i === 0) ? $email : fake()->email,
                "home_phone" => ($i === 0) ? $phoneNumber : fake()->phoneNumber,
                "mobile_phone" => ($i === 0) ? $mobilePhoneNumber : fake()->numerify('62##########'),
                "other_phone" => fake()->numerify('62##########'),
                "id_number" => fake()->numerify('################'),
                "nationality" => "ID",
                "adult_assoc" => null,
                "passport_number" => strtoupper(fake()->lexify('??') . fake()->numerify('######')),
                "passport_expire" => fake()->dateTimeBetween('now', '+10 years')->format('Y-m-d'),
                "passport_origin" => "ID",
                "emergency_full_name" => $emergencyFullName,
                "emergency_phone" => $emergencyPhone,
                "emergency_email" => $emergencyEmail,
                "seats" => [],
                "ssrs" => []
            ];

            array_push($passengers, $passenger);
        }

        $this->info('Contact generated:');
        $this->info(json_encode($contact, JSON_PRETTY_PRINT));

        $this->info('Passenger generated:');
        $this->info(json_encode($passengers, JSON_PRETTY_PRINT));

        return 0;
    }
}
