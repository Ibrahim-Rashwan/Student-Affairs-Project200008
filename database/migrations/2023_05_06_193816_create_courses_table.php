<?php

use App\Models\Course;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(Doctor::class)->constrained();
            $table->foreignIdFor(Course::class, 'pre_requisite_id')->nullable()->constrained('courses');
            $table->string('name');
            $table->string('code');
            $table->integer('number_of_hours');
            $table->json('materials');
            $table->timestamps();

            // $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('doctor_id')->references('id')->on('doctors');
            // $table->foreign('pre_requisite_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
