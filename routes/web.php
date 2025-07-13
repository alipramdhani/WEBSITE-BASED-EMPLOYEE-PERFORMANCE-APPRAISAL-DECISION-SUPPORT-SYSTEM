<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\AuthManageController;
use App\Http\Controllers\CriteriaManageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementManageController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\EmployeeManageController;
use App\Http\Controllers\EvaluationResultController;
use App\Http\Controllers\EvaluationSMARTController;
use App\Http\Controllers\KMeansClusteringController;





Route::middleware('guest')->prefix('/')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('showLogin');
    Route::post('/', [AuthController::class, 'login'])->name('login');
});




//============= SUPERADMIN ============

Route::middleware(['auth', 'role:superadmin'])->prefix('/superadmin')->group(function () {

    // ---- Dashboard ----
    Route::get('/dashboard', [DashboardController::class, 'showSuperAdminDashboard'])->name('dashboard.superadmin');

    // ---- Manajemen Autentikasi ----
    Route::prefix('/manajemen-autentikasi')->group(function () {
        // Manajemen Autentikasi - views
        Route::get('/', [AuthManageController::class, 'showAuthManage'])->name('authManage.superadmin');
        // Manajemen Autentikasi - edit
        Route::put('/update/{id}', [AuthManageController::class, 'updateAuthManage'])->name('authManage.superadmin.update');
    });

    // ---- Manajemen Admin ----
    Route::prefix('/manajemen-admin')->group(function () {
        // Manajemen Admin - view
        Route::get('/', [AdminManageController::class, 'showAdminManage'])->name('adminManage.superadmin');
        // Manajemen Admin - Create
        Route::post('/create', [AdminManageController::class, 'create'])->name('adminManage.create');
        // Manajemen Admin - Update
        Route::put('/update/{id}', [AdminManageController::class, 'update'])->name('adminManage.update');
        // Manajemen Admin - Delete
        Route::delete('/delete/{id}', [AdminManageController::class, 'delete'])->name('adminManage.delete');
    });

    // ---- Manajemen Karyawan ----
    Route::prefix('/manajemen-karyawan')->group(function () {
        // Manajemen Karyawan - views
        Route::get('/', [EmployeeManageController::class, 'showEmployeeManage'])->name('employeeManage.superadmin'); //route table di controller
        // Manajemen Employee - Create
        Route::post('/create', [EmployeeManageController::class, 'create'])->name('employeeManage.superadmin.create'); //route proses di form create
        // Manajemen Employee - Update
        Route::put('/update/{id}', [EmployeeManageController::class, 'update'])->name('employeeManage.superadmin.update'); //route proses di form edit
        // Manajemen Karyawan - Delete
        Route::delete('/delete/{id}', [EmployeeManageController::class, 'delete'])->name('employeeManage.superadmin.delete'); //route proses di tombol delete
    });

    // ---- Manajemen Departemen ----
    Route::prefix('/manajemen-departemen')->group(function () {
        // Manajemen Departemen - views
        Route::get('/', [DepartementManageController::class, 'showDepartementManage'])->name('departementManage.superadmin');
        // Manajemen Departement - Create
        Route::post('/create', [DepartementManageController::class, 'create'])->name('departementManage.create');
        // Manajemen Karyawan - Delete
        Route::delete('/delete/{id}', [DepartementManageController::class, 'delete'])->name('departementManage.delete'); //route proses di button delete
    });

    // ---- Manajemen Kriteria ----
    Route::prefix('/manajemen-kriteria')->group(function () {
        // Manajemen Kriteria - views
        Route::get('/', [CriteriaManageController::class, 'showCriteriaManage'])->name('criteriaManage.superadmin');
        // Manajemen Kriteria - create
        Route::post('/create', [CriteriaManageController::class, 'create'])->name('criteriaManage.superadmin.create');
        // Manajemen Kriteria - delete
        Route::delete('/delete/{id}', [CriteriaManageController::class, 'delete'])->name('criteriaManage.superadmin.delete');
    });

    // ---- Evaluasi Kinerja ----
    Route::prefix('/evaluasi-kinerja')->group(function () {
        // Evaluasi Kinerja - views
        Route::get('/', [EvaluationSMARTController::class, 'showEvaluationForm'])->name('evaluation.superadmin');
        // Evaluasi Kinerja - Proses
        Route::post('/store', [EvaluationSMARTController::class, 'storeEvaluation'])->name('evaluation.superadmin.store');
        Route::delete('/delete', [EvaluationSMARTController::class, 'deleteStageResults'])->name('evaluation.superadmin.delete');
        Route::get('/evaluation/download/{id}/{tahap}', [EvaluationResultController::class, 'downloadPDFSMART'])->name('evaluation.superadmin.download');
    });

    // ---- Kinerja Terbaik ----
    Route::prefix('/kinerja-terbaik')->group(function () {
        // Kinerja Terbaik - views
        Route::get('/', [KMeansClusteringController::class, 'showBestPerformance'])->name('bestPerformance.superadmin');
        // Kinerja Terbaik - views
        Route::post('/generate-centroid', [KMeansClusteringController::class, 'generateCentroid'])->name('generateCentroid.superadmin');
        Route::post('/generate-clustering/{years}', [KMeansClusteringController::class, 'generateKMeans'])->name('generateKMeans.superadmin');
        Route::delete('/kmeans-clustering/reset/{evaluation_years}', [KMeansClusteringController::class, 'resetClustering'])
            ->name('clusteringReset.superadmin');
        Route::get('/download', [EvaluationResultController::class, 'downloadPDFKMEANS'])->name('bestPerformance.superadmin.download');
        Route::get('/preview', [EvaluationResultController::class, 'previewPDFKMEANS'])->name('bestPerformance.superadmin.preview');
    });

    // ---- Hasil Evaluasi ----
    Route::prefix('/hasil-evaluasi')->group(function () {
        // Hasil Evaluasi - views
        Route::get('/', [EvaluationResultController::class, 'showEvaluationResult'])->name('evaluation.superadmin.result');
        // routes/web.php
        Route::get('/evaluation', [EvaluationResultController::class, 'evaluation'])->name('evaluation.superadmin.result.evaluation');
        Route::get('/utility', [EvaluationResultController::class, 'utility'])->name('evaluation.superadmin.utility');
        Route::get('/finalScoreSmart', [EvaluationResultController::class, 'finalScoreSmart'])->name('evaluation.superadmin.finalScoreSmart');
    });
});





// ============= ADMIN ==============
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showAdminDashboard'])->name('dashboard.admin');

    // ---- Manajemen Autentikasi ----
    Route::prefix('/manajemen-autentikasi')->group(function () {
        // Manajemen Autentikasi - views
        Route::get('/', [AuthManageController::class, 'showAuthManage'])->name('authManage.admin');
        // Manajemen Autentikasi - edit
        Route::put('/update/{id}', [AuthManageController::class, 'updateAuthManage'])->name('authManage.admin.update');
    });

    // ---- Manajemen Karyawan ----
    Route::prefix('/manajemen-karyawan')->group(function () {
        // Manajemen Karyawan - views
        Route::get('/', [EmployeeManageController::class, 'showEmployeeManage'])->name('employeeManage.admin');
        // Manajemen Employee - Create
        Route::post('/create', [EmployeeManageController::class, 'create'])->name('employeeManage.admin.create');
        // Manajemen Employee - Update
        Route::put('/update/{id}', [EmployeeManageController::class, 'update'])->name('employeeManage.admin.update');
        // Manajemen Karyawan - Delete
        Route::delete('/delete/{id}', [EmployeeManageController::class, 'delete'])->name('employeeManage.admin.delete');
    });
    // ---- Manajemen Kriteria ----
    Route::prefix('/manajemen-kriteria')->group(function () {
        // Manajemen Kriteria - views
        Route::get('/', [CriteriaManageController::class, 'showCriteriaManage'])->name('criteriaManage.admin');
        // Manajemen Kriteria - create
        Route::post('/create', [CriteriaManageController::class, 'create'])->name('criteriaManage.admin.create');
        // Manajemen Kriteria - delete
        Route::delete('/delete/{id}', [CriteriaManageController::class, 'delete'])->name('criteriaManage.admin.delete');
    });

    // ---- Evaluasi Kinerja ----
    Route::prefix('/evaluasi-kinerja')->group(function () {
        // Evaluasi Kinerja - views
        Route::get('/', [EvaluationSMARTController::class, 'showEvaluationForm'])->name('evaluation.admin');
        // Evaluasi Kinerja - Proses
        Route::post('/store', [EvaluationSMARTController::class, 'storeEvaluation'])->name('evaluation.admin.store');
        Route::post('/evaluation/download/{id}/{tahap}', [EvaluationResultController::class, 'downloadPDFSMART'])->name('evaluation.admin.download');
    });

    // ---- Kinerja Terbaik ----
    Route::prefix('/kinerja-terbaik')->group(function () {
        // Kinerja Terbaik - views
        Route::get('/', [KMeansClusteringController::class, 'showBestPerformance'])->name('bestPerformance.admin');
        // Kinerja Terbaik - views
        Route::post('/generate-centroid', [KMeansClusteringController::class, 'generateCentroid'])->name('generateCentroid.admin');
        Route::post('/generate-clustering/{years}', [KMeansClusteringController::class, 'generateKMeans'])->name('generateKMeans.admin');
        Route::delete('/kmeans-clustering/reset/{evaluation_years}', [KMeansClusteringController::class, 'resetClustering'])
            ->name('clusteringReset.admin');
        Route::get('/download', [EvaluationResultController::class, 'downloadPDFKMEANS'])->name('bestPerformance.admin.download');
        Route::get('/preview', [EvaluationResultController::class, 'previewPDFKMEANS'])->name('bestPerformance.admin.preview');
    });

    // ---- Hasil Evaluasi ----
    Route::prefix('/hasil-evaluasi')->group(function () {
        // Hasil Evaluasi - views
        Route::get('/', [EvaluationResultController::class, 'showEvaluationResult'])->name('evaluation.admin.result');
        // routes/web.php
        Route::get('/evaluation', [EvaluationResultController::class, 'evaluation'])->name('evaluation.admin.result.evaluation');
        Route::get('/utility', [EvaluationResultController::class, 'utility'])->name('evaluation.admin.utility');
        Route::get('/finalScoreSmart', [EvaluationResultController::class, 'finalScoreSmart'])->name('evaluation.admin.finalScoreSmart');
    });
});




// ============= Logout ADMIN & SUPERADMIN ==============
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




// ============= KARYAWAN ============
Route::middleware('guest')->prefix('karyawan')->group(function () {
    Route::get('/', [EmployeeController::class, 'showLoginForm'])->name('showLogin.employee');
    Route::post('/', [EmployeeController::class, 'loginEmployee'])->name('login.employee');
});

Route::middleware(['auth', 'role:employee'])->prefix('karyawan')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'showEmployeeDashboard'])->name('dashboard.employee');
    Route::post('/logout-employee', [EmployeeController::class, 'logout'])->name('logout.employee');

    Route::prefix('/hasil-evaluasi')->group(function () {
        // Hasil Evaluasi - views
        Route::get('/', [EvaluationResultController::class, 'showEvaluationResult'])->name('evaluation.employee.result');
        // routes/web.php
        Route::get('/evaluation', [EvaluationResultController::class, 'evaluation'])->name('evaluation.employee.result.evaluation');
        Route::get('/utility', [EvaluationResultController::class, 'utility'])->name('evaluation.employee.utility');
        Route::get('/finalScoreSmart', [EvaluationResultController::class, 'finalScoreSmart'])->name('evaluation.employee.finalScoreSmart');
    });
});





Route::get('/{role}/hasil-evaluasi/download-all', [EvaluationResultController::class, 'downloadAll'])->name('evaluationResult.download.all');
Route::get('/{role}/hasil-evaluasi/preview-all', [EvaluationResultController::class, 'previewAll'])->name('evaluationResult.preview.all');
