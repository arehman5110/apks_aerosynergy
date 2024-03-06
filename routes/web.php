<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\web\admin\TeamController;
use App\Http\Controllers\web\admin\TeamUsersController;
use App\Http\Controllers\web\adminDashboardControllers\AdminDashboard;
use App\Http\Controllers\web\adminDashboardControllers\GraphCounts;
use App\Http\Controllers\web\CableBridgeController;
use App\Http\Controllers\web\CableBridgeMapController;
use App\Http\Controllers\web\Dashboard;
use App\Http\Controllers\web\excel\CableBridgeExcelController;
use App\Http\Controllers\web\excel\DigingExcelController;
use App\Http\Controllers\web\excel\FeederPillarExcelController;
use App\Http\Controllers\web\excel\LinkBoxExcelController;
use App\Http\Controllers\web\excel\SubstationExcelController;
use App\Http\Controllers\web\excel\ThirdPartyExcelController;
use App\Http\Controllers\web\excel\TiangExcelController;
use App\Http\Controllers\web\FeederPillarMapController;
use App\Http\Controllers\web\LinkBoxController;
use App\Http\Controllers\web\map\GeneratePDFController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\map\MapController;
use App\Http\Controllers\web\map\RoadController;
use App\Http\Controllers\web\map\WPController;
use App\Http\Controllers\web\TiangContoller;
use App\Http\Controllers\web\tnbes\StatusController;
use App\Http\Controllers\web\ThirdPartyDiggingController;
use App\Http\Controllers\web\SubstationController;
use App\Http\Controllers\web\FPController;
use App\Http\Controllers\web\GenerateNoticeController;
use App\Http\Controllers\web\LinkBoxMapController;
use App\Http\Controllers\web\PatrollingController;
use App\Http\Controllers\web\POController;
use App\Http\Controllers\web\SubstationMapController;
use App\Http\Controllers\web\TiangMapController;
use App\Models\ThirdPartyDiging;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\web\excel\PatrollingExcelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/{lang?}', function ($lang='en') {
//     App::setLocale($lang);
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::group(
    [
        'prefix' => '{locale}',
        'where' => ['locale' => '[a-zA-Z]{2}'],
        'middleware' => 'setlocale',
    ],
    function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            Route::middleware('isAdmin:' . false)->group(function () {
                Route::get('/map-1', [MapController::class, 'index'])->name('map-1');
                Route::get('/get-all-work-packages', [MapController::class, 'allWP'])->name('get-all-work-packages');
                Route::get('/proxy/{url}', [MapController::class, 'proxy'])->name('proxy');

                Route::post('/save-work-package', [WPController::class, 'saveWorkPackage']);
                Route::post('/save-road', [RoadController::class, 'saveRoad']);

                Route::post('/get-raod-info', [WPController::class, 'getRoadInfo']);
                Route::post('/get-ba-info', [WPController::class, 'getBaInfo']);
                Route::get('/get-work-package/{ba}/{zone}', [WPController::class, 'selectWP'])->name('get-work-package');
                Route::get('/getStats/{wp}', [WPController::class, 'getStats'])->name('getStats');

                Route::get('/send-to-tnbes/{id}/', [StatusController::class, 'sendToTnbes']);
                Route::get('/sbum-status/{id}/{status}', [StatusController::class, 'statusSUBM']);

                Route::get('/generate-third-party-diging-excel/{id}', [DigingExcelController::class, 'generateDigingExcel']);

                Route::get('/remove-road/{id}', [RoadController::class, 'removeRoad']);
                Route::get('/remove-work-package/{id}', [WPController::class, 'removeWP']);

                Route::get('/generate-third-party-pdf/{id}', [GeneratePDFController::class, 'generatePDF']);
                Route::get('/get-road-name/{lat}/{lng}', [RoadController::class, 'getRoadName']);

                /// tiang

                Route::resource('tiang-talian-vt-and-vr', TiangContoller::class);
                Route::post('generate-tiang-talian-vt-and-vr-excel', [TiangExcelController::class, 'generateTiangExcel'])->name('generate-tiang-talian-vt-and-vr-excel');
                Route::view('/tiang-talian-vt-and-vr-map', 'Tiang.map')->name('tiang-talian-vt-and-vr-map');
                Route::get('/search/find-tiang/{q}', [TiangMapController::class, 'seacrh'])->name('tiang-search');
                Route::get('/search/find-tiang-cordinated/{q}', [TiangMapController::class, 'seacrhCoordinated'])->name('tiang-coordinated');
                Route::get('/get-tiang-edit/{id}', [TiangMapController::class, 'editMap'])->name('get-tiang-edit');
                Route::post('/tiang-talian-vt-and-vr-map-edit/{id}', [TiangMapController::class, 'editMapStore'])->name('tiang-talian-vt-and-vr-map-edit');
                Route::get('/tiang-talian-vt-and-vr-update-QA-Status', [TiangContoller::class, 'updateQAStatus'])->name('tiang-talian-vt-and-vr-update-QA-Status');
        


                //// Link Box
                Route::resource('link-box-pelbagai-voltan', LinkBoxController::class);
                Route::post('generate-link-box-excel', [LinkBoxExcelController::class, 'generateLinkBoxExcel'])->name('generate-link-box-excel');
                Route::view('/link-box-pelbagai-voltan-map', 'link-box.map')->name('link-box-pelbagai-voltan-map');
                Route::get('/get-link-box-edit/{id}', [LinkBoxMapController::class, 'editMap'])->name('get-link-box-edit');
                Route::post('/update-link-box-map-edit/{id}', [LinkBoxMapController::class, 'update'])->name('update-link-box-map-edit');
                Route::get('/search/find-link-box/{q}', [LinkBoxMapController::class, 'seacrh'])->name('link-box-search');
                Route::get('/search/find-link-box-cordinated/{q}', [LinkBoxMapController::class, 'seacrhCoordinated'])->name('link-box-coordinated');
                Route::get('/link-box-pelbagai-voltan-update-QA-Status', [LinkBoxController::class, 'updateQAStatus'])->name('link-box-pelbagai-voltane-update-QA-Status');


                //// Cable Bridge

                Route::resource('cable-bridge', CableBridgeController::class);
                Route::post('generate-cable-bridge-excel', [CableBridgeExcelController::class, 'generateCableBridgeExcel'])->name('generate-cable-bridge-excel');
                Route::view('/cable-bridge-map', 'cable-bridge.map')->name('cable-bridge-map');
                Route::get('/get-cable-bridge-edit/{id}', [CableBridgeMapController::class, 'editMap'])->name('get-cable-bridge-edit');
                Route::post('/update-cable-bridge-map-edit/{id}', [CableBridgeMapController::class, 'update'])->name('update-cable-bridge-map-edit');
                Route::get('/search/find-cable-bridge/{q}', [CableBridgeMapController::class, 'seacrh'])->name('cable-bridge-search');
                Route::get('/search/find-cable-bridge-cordinated/{q}', [CableBridgeMapController::class, 'seacrhCoordinated'])->name('cable-bridge-coordinated');
                Route::get('/cable-bridge-update-QA-Status', [CableBridgeController::class, 'updateQAStatus'])->name('cable-bridge-update-QA-Status');

                ////third party digging routes
                Route::resource('third-party-digging', ThirdPartyDiggingController::class);
                Route::post('generate-third-party-digging-excel', [ThirdPartyExcelController::class, 'generateThirdPartExcel'])->name('generate-third-party-digging-excel');
                Route::get('/third-party-digging-update-QA-Status', [ThirdPartyDiggingController::class, 'updateQAStatus'])->name('third-party-digging-QA-Status');

                ////substation routes
                Route::resource('substation', SubstationController::class);
                Route::view('/substation-map', 'substation.map')->name('substation-map');
                Route::post('generate-substation-excel', [SubstationExcelController::class, 'generateSubstationExcel'])->name('generate-substation-excel');
                Route::get('/substation-paginate', [SubstationController::class, 'paginate'])->name('substation-paginate');
                Route::get('/get-substation-edit/{id}', [SubstationMapController::class, 'editMap'])->name('get-substation-edit');
                Route::post('/update-substation-map-edit/{id}', [SubstationMapController::class, 'update'])->name('update-substation-map-edit');
                Route::get('/search/find-substation/{q}', [SubstationMapController::class, 'seacrh'])->name('subsation-search');
                Route::get('/search/find-substation-cordinated/{q}', [SubstationMapController::class, 'seacrhCoordinated'])->name('subsation-coordinated');
                Route::get('/substation-update-QA-Status', [SubstationController::class, 'updateQAStatus'])->name('substation-update-QA-Status');

                ////feeder-piller routes
                Route::resource('feeder-pillar', FPController::class);
                Route::view('/feeder-pillar-map', 'feeder-pillar.map')->name('feeder-pillar-map');
                Route::post('generate-feeder-pillar-excel', [FeederPillarExcelController::class, 'generateFeederPillarExcel'])->name('generate-feeder-pillar-excel');
                Route::get('/get-feeder-pillar-edit/{id}', [FeederPillarMapController::class, 'editMap'])->name('get-feeder-pillar-edit');
                Route::post('/update-feeder-pillar-map-edit/{id}', [FeederPillarMapController::class, 'update'])->name('update-feeder-pillar-map-edit');
                Route::get('/search/find-feeder-pillar/{q}', [FeederPillarMapController::class, 'seacrh'])->name('feeder-pillar-search');

                Route::get('/search/find-feeder-pillar-cordinated/{q}', [FeederPillarMapController::class, 'seacrhCoordinated'])->name('feeder-pillar-coordinated');
                Route::get('/feeder-pillar-update-QA-Status', [FPController::class, 'updateQAStatus'])->name('feeder-pillar-update-QA-Status');


                //generate notice pdf
                Route::get('/generate-notice/{id}', [GenerateNoticeController::class, 'generateNotice']);
                Route::get('/notice', [GenerateNoticeController::class, 'index'])->name('notice');
                Route::get('/download-notice/{id}', [GenerateNoticeController::class, 'download'])->name('download-notice');
                Route::post('/upload-notice', [GenerateNoticeController::class, 'store'])->name('upload-notice');

                //PO routes

                Route::resource('po', POController::class);

                // Patrolling
                Route::get('/create-patrolling', [PatrollingController::class, 'create'])->name('create-patrolling');
                Route::post('/patrolling-update', [PatrollingController::class, 'updateRoads']);
                Route::get('/get-patrolling-json/{id}', [PatrollingController::class, 'getGeoJson'])->name('get-patrolling-json');
                Route::get('/patrolling', [PatrollingController::class, 'index'])->name('patroling.index');
                Route::get('/patrolling-paginate', [PatrollingController::class, 'paginate'])->name('patrolling-paginate');
                Route::post('/generate-patrolling-excel', [PatrollingExcelController::class, 'generateExcel'])->name('generate-patrolling-excel');
                Route::get('/patrolling-update-QA-Status', [PatrollingController::class, 'updateQAStatus'])->name('patrolling-update-QA-Status');


                Route::get('/get-roads-name/{id}', [PatrollingController::class, 'getRoads']);
                Route::get('/get-roads-id/{id}', [PatrollingController::class, 'getRoadsByID']);

                Route::get('/get-roads-details/{wpID}', [MapController::class, 'getRoadsDetails']);
                // PATROLING VIEWS
                Route::get('/edit-patrolling/{id}', [PatrollingController::class, 'editRoad']);
                Route::get('/patrolling-detail/{id}', [PatrollingController::class, 'getRoad'])->name('patrolling-detail');

                Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
                Route::get('/patrol_graph', [GraphCounts::class, 'patrol_graph'])->name('patrol_graph');
                Route::get('/statsTable', [GraphCounts::class, 'statsTable'])->name('statsTable');
                Route::get('/admin-statsTable', [AdminDashboard::class, 'statsTable'])->name('admin-statsTable');
                Route::get('/admin-get-all-counts', [AdminDashboard::class, 'getAllCounts'])->name('admin-get-all-counts');
                Route::get('/get-all-counts', [GraphCounts::class, 'getAllCounts'])->name('get-all-counts');
                Route::get('/admin-patrol_graph', [AdminDashboard::class, 'patrol_graph'])->name('admin-patrol_graph');
                Route::get('/get-users-by-team', [AdminDashboard::class, 'getUsersByTeam'])->name('get-users-by-team');
                Route::get('/admin-getstats-by-users', [AdminDashboard::class, 'getStatsByUsers'])->name('admin-getstats-by-users');









                Route::view('/map-2', 'map')->name('map-2');

                Route::get('/test-pagination/{id}/{status}', [MapController::class, 'teswtpagination']);
                Route::get('/preNext/{id}/{status}', [MapController::class, 'preNext']);
                });

            Route::middleware('isAdmin:' . true)->group(function () {
                //// Admin side
                Route::prefix('admin')->group(function () {
                    Route::resource('/team', TeamController::class);
                    Route::resource('team-users', TeamUsersController::class);
                });
            });
        });
        Route::view('/generate-pdf-for-notice', 'PDF.notice');

        Route::get('/third-party-digging-mobile/{id}', [ThirdPartyDiggingController::class, 'show']);
        Route::get('/get-work-package-detail/{id}', [WPController::class, 'detail'])->name('get-work-package-detail');
        require __DIR__ . '/auth.php';
    },
);

Route::get('/generate-third-party-pdf/{id}', [GeneratePDFController::class, 'generateP']);
