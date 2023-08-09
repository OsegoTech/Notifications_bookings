<?php

namespace Tests\Feature;

use App\Models\ClassType;
use App\Models\ScheduledClass;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    use RefreshDatabase;
   public function test_instructor_is_redirected_to_instructor_dashboard(): void
   {
       $user = User::factory()->create([
              'role' => 'instructor',
       ]);

       $response = $this
           ->actingAs($user)
           ->get('/dashboard');

       $response->assertRedirectToRoute('instructor.dashboard');

       $this->followRedirects($response)->assertSeeText('Hey Instructor');
   }

   public function test_instructor_can_schedule_a_class()
   {

    // GIVEN
    $user = User::factory()->create([
        'role' => 'instructor',
 ]);

 $this->seed(ClassTypeSeeder::class);

    // WHEN
    $response = $this->actingAs($user)
    ->post('instructor/schedule', [
        'class_type_id' => ClassType::first()->id,
        'date' => '2023-09-01',
        'time' => '12:00:00',
    ]);

    // THEN

    $this->assertDatabaseHas('scheduled_classes', [
        'class_type_id' => ClassType::first()->id,
        'date_time' => '2023-09-01 12:00:00',
    ]);
    $response->assertRedirectToRoute('schedule.index');
   } 

   public function test_instructor_can_cancel_a_class()
   {
    // GIVEN
    $user = User::factory()->create([
        'role' => 'instructor',
    ]);

    $this->seed(ClassTypeSeeder::class);
    $scheduledClass = ScheduledClass::create([
        'instructor_id' => $user->id,
        'class_type_id' => ClassType::first()->id,
        'date_time' => '2023-09-01 12:00:00',
    ]);


    // WHEN
    $response = $this->actingAs($user)
    ->delete('/instructor/schedule/' . $scheduledClass->id);

    // THEN
    $this->assertDatabaseMissing('scheduled_classes', [
        'id' => $scheduledClass->id,
    ]);
    
   }

   public function test_instructor_cannot_cancel_a_class_that_is_less_than_two_hours_before()
   {
    // GIVEN
    $user = User::factory()->create([
        'role' => 'instructor',
    ]);

    $this->seed(ClassTypeSeeder::class);
    $scheduledClass = ScheduledClass::create([
        'instructor_id' => $user->id,
        'class_type_id' => ClassType::first()->id,
        'date_time' => now()->addHours(1)->minutes(0)->seconds(0),
    ]);

    $response = $this->actingAs($user)
    ->get('instructor/schedule/' );

    $response->assertDontSeeText('Cancel');
    // WHEN
    $response = $this->actingAs($user)
    ->delete('/instructor/schedule/' . $scheduledClass->id);

    // THEN
    $this->assertDatabaseHas('scheduled_classes', [
        'id' => $scheduledClass->id,
    ]);
}
}
