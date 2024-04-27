<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\QMSDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division = new Division();
        $division->id = 1;
        $division->name = "KSA";
        $division->save();

        $division = new Division();
        $division->id = 2;
        $division->name = "Egypt";
        $division->save();

        $division = new Division();
        $division->id = 3;
        $division->name = "Estonia";
        $division->save();

        $division = new Division();
        $division->id = 4;
        $division->name = "EHS - North America";
        $division->save();

        $division = new Division();
        $division->id = 5;
        $division->name = "Global";
        $division->save();

        $division = new Division();
        $division->id = 6;
        $division->name = "Jordan";
        $division->save();

        $division = new Division();
        $division->id = 7;
        $division->name = "Dewas/India";
        $division->save();

        $division = new Division();
        $division->id = 8;
        $division->name = "Corporate/India";
        $division->save();


        $division = new Division();
        $division->id = 9;
        $division->name = "India";
        $division->save();

        $division = new Division();
        $division->id = 10;
        $division->name = "QMS - Asia";
        $division->save();

        $division = new Division();
        $division->id = 11;
        $division->name = "QMS - EMEA";
        $division->save();

        $division = new Division();
        $division->id = 12;
        $division->name = "SQM - APAC";
        $division->save();

        $division = new Division();
        $division->id = 13;
        $division->name = "QMS - South America";
        $division->save();

        $division = new Division();
        $division->id = 14;
        $division->name = "India APAC";
        $division->save();

        $division = new Division();
        $division->id = 15;
        $division->name = "South Korea";
        $division->save();

        $division = new Division();
        $division->id = 16;
        $division->name = "Japan";
        $division->save();

        $division = new Division();
        $division->id = 17;
        $division->name = "Corporate";
        $division->save();

        $division = new Division();
        $division->id = 18;
        $division->name = "Indonesia";
        $division->save();

        $division = new Division();
        $division->id = 19;
        $division->name = "Malaysia";
        $division->save();

        $division = new Division();
        $division->id = 20;
        $division->name = "Singapore";
        $division->save();

        $division = new Division();
        $division->id = 21;
        $division->name = "North America";
        $division->save();

        $division = new Division();
        $division->id = 22;
        $division->name = "EU";
        $division->save();

        $division = new Division();
        $division->id = 23;
        $division->name ="United Kingdom";
        $division->save();

        $division = new Division();
        $division->id = 24;
        $division->name = "Australia & New Zealand";
        $division->save();

        $division = new Division();
        $division->id = 25;
        $division->name = "South America";
        $division->save();

        $division = new Division();
        $division->id = 26;
        $division->name = "China";
        $division->save();

        $division = new Division();
        $division->id = 27;
        $division->name = "Taiwan";
        $division->save();

        // ---------------------------------------------

        $division = new QMSDivision();
        $division->id = 1;
        $division->name = "KSA";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 2;
        $division->name = "Egypt";
        $division->status = 1;  
        $division->save();

        $division = new QMSDivision();
        $division->id = 3;
        $division->name = "Estonia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 4;
        $division->name = "EHS - North America";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 5;
        $division->name = "Global";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 6;
        $division->name = "Jordan";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 7;
        $division->name = "Dewas/India";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 8;
        $division->name = "Corporate/India";
        $division->status = 1;
        $division->save();


        $division = new QMSDivision();
        $division->id = 9;
        $division->name = "India";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 10;
        $division->name = "QMS - Asia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 11;
        $division->name = "QMS - EMEA";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 12;
        $division->name = "SQM - APAC";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 13;
        $division->name = "QMS - South America";
        $division->save();

        $division = new QMSDivision();
        $division->id = 14;
        $division->name = "India APAC";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 15;
        $division->name = "South Korea";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 16;
        $division->name = "Japan";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 17;
        $division->name = "Corporate";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 18;
        $division->name = "Indonesia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 19;
        $division->name = "Malaysia";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 20;
        $division->name = "Singapore";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 21;
        $division->name = "North America";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 22;
        $division->name = "EU";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 23;
        $division->name ="United Kingdom";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 24;
        $division->name = "Australia & New Zealand";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 25;
        $division->name = "South America";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 26;
        $division->name = "China";
        $division->status = 1;
        $division->save();

        $division = new QMSDivision();
        $division->id = 27;
        $division->name = "Taiwan";
        $division->status = 1;
        $division->save();
    }
}
