<?php

use App\Http\Controllers\Web\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\Web\ActivityController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BusinessAccountController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DynamicFieldController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\ServiceController;


// Login 
Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:web']], function () {

    // logout & FCM 
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('fcm/register-token', [FCMController::class, 'store'])->defaults('guardName', 'web');

    // Notifications
    Route::prefix('notifications/')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/{notification}/read', [NotificationController::class, 'readAndRedirect'])->name('notifications.readAndRedirect');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // Admins
    Route::group(['middleware' => ['permission:view-admins']], function () {
        Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
    });
    Route::group(['middleware' => ['permission:create-admins']], function () {
        Route::get('admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('admins', [AdminController::class, 'store'])->name('admins.store');
    });
    Route::group(['middleware' => ['permission:edit-admins']], function () {
        Route::get('admins/edit/{admin}', [AdminController::class, 'edit'])->name('admins.edit');
        Route::put('admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    });
    Route::group(['middleware' => ['permission:delete-admins']], function () {
        Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
    });

    // Roles
    Route::group(['middleware' => ['permission:view-roles']], function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    });
    Route::group(['middleware' => ['permission:create-roles']], function () {
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    });
    Route::group(['middleware' => ['permission:edit-roles']], function () {
        Route::get('roles/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });
    Route::group(['middleware' => ['permission:delete-roles']], function () {
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Cities
    Route::group(['middleware' => ['permission:view-cities']], function () {
        Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    });
    Route::group(['middleware' => ['permission:create-cities']], function () {
        Route::get('cities/create', [CityController::class, 'create'])->name('cities.create');
        Route::post('cities', [CityController::class, 'store'])->name('cities.store');
    });
    Route::group(['middleware' => ['permission:edit-cities']], function () {
        Route::get('cities/edit/{city}', [CityController::class, 'edit'])->name('cities.edit');
        Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
    });
    Route::group(['middleware' => ['permission:delete-cities']], function () {
        Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
    });

    // Activities
    Route::group(['middleware' => ['permission:view-activities']], function () {
        Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
    });
    Route::group(['middleware' => ['permission:create-activities']], function () {
        Route::get('activities/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('activities', [ActivityController::class, 'store'])->name('activities.store');
    });
    Route::group(['middleware' => ['permission:edit-activities']], function () {
        Route::get('activities/edit/{activity}', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::put('activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    });
    Route::group(['middleware' => ['permission:delete-activities']], function () {
        Route::delete('activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    });

    // Business Accounts
    Route::group(['middleware' => ['permission:view-business-accounts']], function () {
        Route::get('business-accounts', [BusinessAccountController::class, 'index'])->name('business-accounts.index');
        Route::get('business-accounts/{businessAccount}', [BusinessAccountController::class, 'show'])->name('business-accounts.show');
    });
    Route::group(['middleware' => ['permission:manage-business-accounts']], function () {
        Route::post('business-accounts/{businessAccount}/approve', [BusinessAccountController::class, 'approve'])->name('business-accounts.approve');
        Route::post('business-accounts/{businessAccount}/reject', [BusinessAccountController::class, 'reject'])->name('business-accounts.reject');
    });


    // Categories - Main & Sub
    Route::group(['middleware' => ['permission:view-categories']], function () {
        Route::get('categories/main', [CategoryController::class, 'indexMain'])->name('categories.main.index');
        Route::get('categories/sub', [CategoryController::class, 'indexSub'])->name('categories.sub.index');
    });
    Route::group(['middleware' => ['permission:create-categories']], function () {
        Route::get('categories/main/create', [CategoryController::class, 'createMain'])->name('categories.main.create');
        Route::get('categories/sub/create', [CategoryController::class, 'createSub'])->name('categories.sub.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    });
    Route::group(['middleware' => ['permission:edit-categories']], function () {
        Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    });
    Route::group(['middleware' => ['permission:delete-categories']], function () {
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // Dynamic Fields
    Route::prefix('categories/fields/')->group(function () {
        Route::group(['middleware' => ['permission:view-dynamic-fields']], function () {
            Route::get('{category}', [DynamicFieldController::class, 'index'])->name('categories.fields.index');
        });
        Route::group(['middleware' => ['permission:create-dynamic-fields']], function () {
            Route::get('{category}/create', [DynamicFieldController::class, 'create'])->name('categories.fields.create');
            Route::post('{category}', [DynamicFieldController::class, 'store'])->name('categories.fields.store');
        });
        Route::group(['middleware' => ['permission:edit-dynamic-fields']], function () {
            Route::get('{dynamicField}/{category}/edit', [DynamicFieldController::class, 'edit'])->name('categories.fields.edit');
            Route::put('{dynamicField}/{category}', [DynamicFieldController::class, 'update'])->name('categories.fields.update');
        });
        Route::group(['middleware' => ['permission:delete-dynamic-fields']], function () {
            Route::delete('{dynamicField}/{category}', [DynamicFieldController::class, 'destroy'])->name('categories.fields.destroy');
        });
    });

    // Services
    Route::prefix('services/')->group(function () {
        Route::group(['middleware' => ['permission:view-services']], function () {
            Route::get('/', [ServiceController::class, 'index'])->name('services.index');
            Route::get('/{service}', [ServiceController::class, 'show'])->name('services.show');
        });
        Route::group(['middleware' => ['permission:manage-services']], function () {
            Route::post('/{service}/approve', [ServiceController::class, 'approve'])->name('services.approve');
            Route::post('/{service}/reject', [ServiceController::class, 'reject'])->name('services.reject');
        });
    });

    // lang
    Route::get('locale/{lang}', function ($lang) {
        $supportedLanguages = ['en', 'ar'];
        if (in_array($lang, $supportedLanguages)) {
            session(['locale' => $lang]);
        }
        return redirect()->back();
    })->name('locale');

















    ///////////////////////////


    // Main Page Route
    Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

    // layout
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

    // pages
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

    // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

    // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

    // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

    // icons
    Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

    // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

    // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

    // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
});
