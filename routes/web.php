<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BodyMetricsController;
use App\Mail\MealReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutProgressController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\AccountController;

// Public routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', function () {
    return view('register');
})->name('register.submit');

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::post('/chat', [ChatbotController::class, 'chat']);
Route::post('/generate-meal-plan', [MealController::class, 'generateMealPlan'])->name('generate_meal_plan');

Route::post('/workout-split', [WorkoutController::class, 'generateSplit']);
Route::post('/body-metrics', [BodyMetricsController::class, 'store']);

Route::get('/mealRemind', function () {
    $users = User::all();
    foreach ($users as $user) {
        Mail::to($user->email)->send(new MealReminder($user));
    }
});

Route::get('/glogin', function () {
    return view('login');
});

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/index', function () {
    return view('index');
})->name('logout');

Route::post('/workout_plan_1', [WorkoutController::class, 'storeGoal'])->name('workout_plan_1');
    Route::post('/workout_plan_2', [WorkoutController::class, 'storeSetup'])->name('workout_plan_2');
    Route::post('/workout_plan_3', [WorkoutController::class, 'storeIntensity'])->name('workout_plan_3');
    Route::post('/workout_plan_4', [WorkoutController::class, 'storeDays'])->name('workout_plan_4');
    Route::post('/workout_plan_5', [WorkoutController::class, 'storeLevel'])->name('workout_plan_5');
    Route::post('/workout_plan_6', [WorkoutController::class, 'storeSplitType'])->name('workout_plan_6');

// Guarded Routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

    Route::get('/overview_tab', function () {
        $user = Auth::user();
        return view('overview_tab', compact('user'));
    })->name('overview_tab');

    Route::get('/progress_tab', function () {
        $user = Auth::user();
        return view('progress_tab', compact('user'));
    })->name('progress_tab');

    Route::get('/welcome_page', function () {
        $user = Auth::user();
        return view('welcome_page', compact('user'));
    })->name('welcome_page');

    Route::get('/mealplan_tab', [MealController::class, 'showMealPlanTab'])->name('mealplan_tab');
    // Route::get('/mealplan_tab', function () {
    //     $user = Auth::user();
    //     return view('mealplan_tab', compact('user'));
    // })->name('mealplan_tab');

    Route::get('/profile_tab', function () {
        $user = Auth::user();
        return view('profile_tab', compact('user'));
    })->name('profile_tab');

    Route::get('/timer_tab', function () {
        $user = Auth::user();
        return view('timer_tab', compact('user'));
    })->name('timer_tab');

    Route::get('/workout-preview', function () {
        $user = Auth::user();
        return view('workout-preview', compact('user'));
    })->name('workout-preview');

    Route::get('/personal_info', function () {
        return view('personal_info');
    })->name('personal_info');

    Route::get('/workout_plan_1', function () {
        return view('workout_plan_1');
    })->name('workout_plan_1');

    Route::get('/workout_plan_2', function () {
        return view('workout_plan_2');
    })->name('workout_plan_2');

    Route::get('/workout_plan_3', function () {
        return view('workout_plan_3');
    })->name('workout_plan_3');

    Route::get('/workout_plan_4', function () {
        return view('workout_plan_4');
    })->name('workout_plan_4');

    Route::get('/workout_plan_5', function () {
        return view('workout_plan_5');
    })->name('workout_plan_5');

    Route::get('/workout_plan_6', function () {
        return view('workout_plan_6');
    })->name('workout_plan_6');

    Route::get('/workouts_tab', [WorkoutController::class, 'workoutsTab'])->name('workouts_tab');
    Route::get('/workout/show', [WorkoutController::class, 'show'])->name('workout.show');
    Route::get('/workouts/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');
    Route::put('/workouts/update', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::get('/update', [WorkoutController::class, 'update'])->name('/update');

    Route::get('/meal-plan', [MealController::class, 'showUserMealPlan'])->name('meal.show');
    Route::get('/mealplan/latest', [MealController::class, 'getLatestMealPlan'])->name('mealplan.latest');
    Route::post('/update-intake', [MealController::class, 'updateIntake'])->name('update_intake');
    Route::get('/intake/today', [MealController::class, 'getTodayIntake'])->name('get_today_intake');
    Route::get('/intake/latest', [MealController::class, 'latestIntake'])->name('intake.latest');
    Route::delete('/daily-intake', [MealController::class, 'destroyToday'])->name('daily-intake.destroy');

    Route::post('/progress', [ProgressController::class, 'store'])->name('progress.store');
    Route::get('/progress', [ProgressController::class, 'showProgressTab'])->name('progress_tab');

    Route::post('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile_tab');

    Route::get('/workout/progress', [WorkoutProgressController::class, 'show']);
    Route::post('/workout/progress', [WorkoutProgressController::class, 'store']);
    Route::get('/api/workout/progress', [WorkoutProgressController::class, 'show']);
    Route::post('/api/workout/progress', [WorkoutProgressController::class, 'store']);
    Route::get('/api/workout/summary', [WorkoutProgressController::class, 'summary']);
    Route::get('/api/workout/day', [WorkoutController::class, 'getWorkoutForDay']);
    Route::get('/workout-preview', [WorkoutController::class, 'workoutPreview'])->name('workout-preview');
    Route::get('/overview_tab', [MealController::class, 'showInOverview'])->name('overview_tab');
    Route::get('/api/workout/day', [WorkoutController::class, 'getWorkoutForOverview']);
    Route::get('/intake-history', [MealController::class, 'intakeHistory'])->name('intake.history');
    Route::post('/progress/goal', [ProgressController::class, 'storeGoal'])->name('progress.goal');
    Route::post('/profile/update-from-macros', [ProfileController::class, 'updateFromMacros'])->name('profile.updateFromMacros');
});
