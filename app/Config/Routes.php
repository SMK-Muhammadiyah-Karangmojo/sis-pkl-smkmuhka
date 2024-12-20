<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Api\RestApiController;
use App\Controllers\Auth\AuthController;
use App\Controllers\Mentor\MentorController;
use App\Controllers\Nilai\NilaiController;
use App\Controllers\Presence\PresenceController;
use App\Controllers\Student\StudentController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * An array that defines the mapping of routes to their corresponding handlers or controllers.
 *
 * The `$routes` array is typically used in routing systems to determine
 * which code should be executed for a given request URI or route. Each
 * route is associated with a specific handler function, controller class,
 * or closure that executes the desired logic.
 *
 * The structure of `$routes` may vary depending on the framework or
 * application, but it generally associates a URI path pattern with its
 * corresponding route handler. The pattern can often include variables,
 * wildcards, or regular expressions for dynamic route-matching.
 *
 * Example contents of `$routes` might include:
 *   - Static paths mapped to controllers or methods.
 *   - Dynamic paths with placeholders for variables.
 *
 * Modifying or extending `$routes` allows custom routing behavior to be
 * implemented.
 */

/**
 * this is auth controller
 */
$routes->get('/', [AuthController::class, 'index']);
$routes->get('error', [AuthController::class, 'error']);
$routes->group('auth', function ($auth) {
    $auth->post('login', [AuthController::class, 'login']);
    $auth->get('register', [AuthController::class, 'register']);
    $auth->post('logout', [AuthController::class, 'logout']);
});

/**
 * Rest Api service controller
 */
$routes->group('api/v1/', function ($v1) {
    /**
     * Student
     */
    $v1->group('student', function ($student) {
        $student->post('find-by-id', [RestApiController::class, 'findStudentById']);
        $student->post('add-presence', [RestApiController::class, 'addPresence']);
        $student->post('update-iduka', [RestApiController::class, 'updateIdukaStudent']);
        $student->post('find-sub-report', [RestApiController::class, 'findSubLaporan']);
        $student->post('find-sub-sub-report', [RestApiController::class, 'findSubSubLaporan']);
        $student->post('delete-report', [RestApiController::class, 'deleteReport']);
        $student->post('update-master-data-student', [RestApiController::class, 'updateMasterDataStudent']);
    });

    /**
     * Iduka
     */
    $v1->group('iduka', function ($iduka) {
        $iduka->post('add', [RestApiController::class, 'addIduka']);
        $iduka->post('detail', [RestApiController::class, 'detailIduka']);
        $iduka->post('update', [RestApiController::class, 'updateIduka']);
        $iduka->post('delete', [RestApiController::class, 'deleteIduka']);
        $iduka->post('find-all-by-tp/(:any)', [RestApiController::class, 'findAllIdukaByTp']);
        $iduka->post('find-all-by-major/(:any)', [RestApiController::class, 'findAllIdukaByMajor']);
        $iduka->post('find-all-by-major-and-tp', [RestApiController::class, 'findAllIdukaByMajorAndTp']);
    });

    /**
     * Tutor Service
     */
    $v1->group('tutor', function ($tutor) {
        $tutor->post('update-tutor', [RestApiController::class, 'updateTutor']);
        $tutor->post('find-by-id', [RestApiController::class, 'findTutorById']);
        $tutor->post('add', [RestApiController::class, 'addPendamping']);
    });

    /**
     * Presence
     */
    $v1->group('presence', function ($presence) {
        $presence->get('findAll', [RestApiController::class, 'findAllDataPresence']);
    });

    /**
     * Major (jurusan)
     */
    $v1->group('major', function ($major) {
        $major->post('find-all', [RestApiController::class, 'findAllMajor']);
        $major->post('detail', [RestApiController::class, 'detailMajor']);
    });

    /**
     * Mentor
     */
    $v1->group('mentor', function ($mentor) {
        $mentor->post('edit/(:num)', [RestApiController::class, 'editMentor']);
        $mentor->post('addMentor', [RestApiController::class, 'addMentor']);
    });
});

/**
 * Admin controller
 */
$routes->group('admin', function ($admin) {
    $admin->get('', [AdminController::class, 'index']);
    $admin->get('data-siswa', [AdminController::class, 'dataSiswa']);
    $admin->get('pendamping', [AdminController::class, 'pendamping']);
    $admin->get('rekap', [AdminController::class, 'rekap']);
    $admin->get('verification', [AdminController::class, 'verification']);
    $admin->post('verification-data-pkl', [AdminController::class, 'verificationData']);
    $admin->get('export-rekap-excel', [AdminController::class, 'exportDataRekapExcel']);
    $admin->get('export-rekap-pdf', [AdminController::class, 'exportDataRekapPdf']);
    $admin->get('iduka', [AdminController::class, 'iduka']);
});

/**
 * Nilai controller
 */
$routes->group('nilai', function ($nilai) {
    $nilai->get('', [NilaiController::class, 'index']);
    $nilai->get('export-nilai', [NilaiController::class, 'exportNilai']);
});

/**
 * Student controller
 */
$routes->group('student', function ($student) {
    $student->get('', [StudentController::class, 'index']);
    $student->get('profile', [StudentController::class, 'profile']);
    $student->post('update-profile', [StudentController::class, 'updateProfile']);
    $student->get('presence', [StudentController::class, 'presence']);
    $student->get('iduka', [StudentController::class, 'iduka']);
    $student->get('report', [StudentController::class, 'report']);
    $student->post('report', [StudentController::class, 'report']);
    $student->post('report', [StudentController::class, 'report']);
    $student->post('add-detail', [StudentController::class, 'addDetail']);
    $student->post('add-master-data', [StudentController::class, 'addMasterData']);
});

/**
 * Presence controller
 */
$routes->group('presence', function ($presence) {
    $presence->get('', [PresenceController::class, 'index']);
    $presence->get('detail/(:num)', [PresenceController::class, 'detail']);
});

/**
 * Mentor controller
 */
$routes->group('mentor', function ($mentor) {
    $mentor->get('', [MentorController::class, 'index']);
});