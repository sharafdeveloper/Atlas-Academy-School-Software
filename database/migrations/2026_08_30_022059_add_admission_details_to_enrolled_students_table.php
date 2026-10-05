<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Father Name
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('enrolled_students', 'father_name')) {
            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->string('father_name')
                    ->nullable()
                    ->after('name');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Student Code
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('enrolled_students', 'student_code')) {
            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->string('student_code')
                    ->nullable()
                    ->after('id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Admission Fee
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('enrolled_students', 'admission_fee')) {
            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->decimal('admission_fee', 10, 2)
                    ->default(1000)
                    ->after('fees');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Student Codes
        |--------------------------------------------------------------------------
        */

        $year = date('Y');

        $students = DB::table('enrolled_students')
            ->where(function ($query) {
                $query->whereNull('student_code')
                    ->orWhere('student_code', '');
            })
            ->orderBy('id')
            ->get();

        /*
        | Find the highest existing number
        */

        $lastStudent = DB::table('enrolled_students')
            ->where('student_code', 'like', 'STD-' . $year . '-%')
            ->orderByDesc('id')
            ->first();

        $counter = 1;

        if ($lastStudent && $lastStudent->student_code) {

            $lastNumber = (int) substr(
                $lastStudent->student_code,
                -4
            );

            $counter = $lastNumber + 1;
        }


        /*
        | Generate codes for students without a code
        */

        foreach ($students as $student) {

            $studentCode = 'STD-' . $year . '-' . str_pad(
                $counter,
                4,
                '0',
                STR_PAD_LEFT
            );

            DB::table('enrolled_students')
                ->where('id', $student->id)
                ->update([
                    'student_code' => $studentCode,
                ]);

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Unique Student Code
        |--------------------------------------------------------------------------
        */

        // Check whether unique index already exists
        $indexes = DB::select(
            "SHOW INDEX FROM enrolled_students WHERE Key_name = 'enrolled_students_student_code_unique'"
        );

        if (empty($indexes)) {

            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->unique(
                    'student_code',
                    'enrolled_students_student_code_unique'
                );
            });
        }
    }


    public function down(): void
    {
        /*
        | Don't remove columns that existed before this migration
        | if they are already part of the database.
        */

        if (Schema::hasColumn('enrolled_students', 'student_code')) {

            $indexes = DB::select(
                "SHOW INDEX FROM enrolled_students WHERE Key_name = 'enrolled_students_student_code_unique'"
            );

            if (!empty($indexes)) {

                Schema::table('enrolled_students', function (Blueprint $table) {
                    $table->dropUnique(
                        'enrolled_students_student_code_unique'
                    );
                });
            }

            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->dropColumn('student_code');
            });
        }

        if (Schema::hasColumn('enrolled_students', 'father_name')) {
            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->dropColumn('father_name');
            });
        }

        if (Schema::hasColumn('enrolled_students', 'admission_fee')) {
            Schema::table('enrolled_students', function (Blueprint $table) {
                $table->dropColumn('admission_fee');
            });
        }
    }
};