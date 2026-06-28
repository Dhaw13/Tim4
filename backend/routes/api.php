<?php

use App\Http\Controllers\API\AdminReviewController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RolePermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Authentication & Role Management
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::get('/reviews',             [ReviewController::class, 'index']);
Route::get('/reviews/{id}',        [ReviewController::class, 'show']);
Route::get('/products/{productId}/reviews', [ReviewController::class, 'productReviews']);

// ==================== PROTECTED ROUTES ====================
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('/profile',     [AuthController::class, 'profile']);
        Route::post('/logout',     [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });

    // Reviews
    Route::post('/reviews',             [ReviewController::class, 'store']);
    Route::put('/reviews/{id}',         [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}',      [ReviewController::class, 'destroy']);

    // Role & Permission Management (khusus admin)
    Route::middleware('role:admin')->prefix('admin')->group(function () {

        // Roles
        Route::get('/roles',            [RolePermissionController::class, 'indexRoles']);
        Route::post('/roles',           [RolePermissionController::class, 'storeRole']);
        Route::put('/roles/{id}',       [RolePermissionController::class, 'updateRole']);
        Route::delete('/roles/{id}',    [RolePermissionController::class, 'destroyRole']);

        // Permissions
        Route::get('/permissions',         [RolePermissionController::class, 'indexPermissions']);
        Route::post('/permissions',        [RolePermissionController::class, 'storePermission']);
        Route::delete('/permissions/{id}', [RolePermissionController::class, 'destroyPermission']);

        // Assign/Revoke role ke user
        Route::post('/users/{userId}/assign-role', [RolePermissionController::class, 'assignRole']);
        Route::post('/users/{userId}/revoke-role', [RolePermissionController::class, 'revokeRole']);

        // Admin Reviews
        Route::get('/reviews',                                [AdminReviewController::class, 'index']);
        Route::put('/reviews/{id}/toggle-visibility',        [AdminReviewController::class, 'toggleVisibility']);
        Route::put('/reviews/{id}/reply',                    [AdminReviewController::class, 'reply']);
        Route::delete('/reviews/{id}',                       [AdminReviewController::class, 'destroy']);
    });
});