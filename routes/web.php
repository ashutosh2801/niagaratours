<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Front\TourDetail;
use App\Livewire\Front\BookingForm;
use App\Livewire\Admin\TourList;
use App\Livewire\Admin\TourForm;
use App\Livewire\Admin\OrderList;
use App\Livewire\Admin\OrderShow;
use App\Livewire\Admin\PaymentList;
use App\Livewire\Admin\PageList;
use App\Livewire\Admin\PageForm;
use App\Livewire\Admin\NotificationList;
use App\Livewire\Admin\UserList;
use App\Livewire\Admin\DashboardStats;
use App\Livewire\Admin\CategoryList;
use App\Livewire\Admin\CategoryForm;
use App\Livewire\Admin\DestinationList;
use App\Livewire\Admin\DestinationForm;

Route::view('/', 'welcome')->name('home');
Route::get('/tours', App\Livewire\Front\TourList::class)->name('tours');
Route::get('/tour/{slug}', TourDetail::class)->name('tour.detail');
Route::get('/booking/{tour_id}', BookingForm::class)->name('booking');
Route::view('/booking-confirmation', 'front.booking-confirmation')->name('booking.confirmation');
Route::view('/about', 'front.about')->name('about');
Route::view('/contact', 'front.contact')->name('contact');
Route::get('/page/{page}', App\Livewire\Front\PageShow::class)->name('page.show');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardStats::class)->name('dashboard');
    Route::get('/categories', CategoryList::class)->name('categories');
    Route::get('/categories/create', CategoryForm::class)->name('categories.create');
    Route::get('/categories/{categoryId}/edit', CategoryForm::class)->name('categories.edit');
    Route::get('/destinations', DestinationList::class)->name('destinations');
    Route::get('/destinations/create', DestinationForm::class)->name('destinations.create');
    Route::get('/destinations/{destinationId}/edit', DestinationForm::class)->name('destinations.edit');
    Route::get('/tours', TourList::class)->name('tours');
    Route::get('/tours/create', TourForm::class)->name('tours.create');
    Route::get('/tours/{tourId}/edit', TourForm::class)->name('tours.edit');
    Route::get('/orders', OrderList::class)->name('orders');
    Route::get('/orders/{orderId}', OrderShow::class)->name('orders.show');
    Route::get('/payments', PaymentList::class)->name('payments');
    Route::get('/pages', PageList::class)->name('pages');
    Route::get('/pages/create', PageForm::class)->name('pages.create');
    Route::get('/pages/{pageId}/edit', PageForm::class)->name('pages.edit');
    Route::get('/notifications', NotificationList::class)->name('notifications');
    Route::get('/users', UserList::class)->name('users');
    Route::get('/media', App\Livewire\Admin\MediaLibrary::class)->name('media');
    Route::get('/sections', App\Livewire\Admin\SectionList::class)->name('sections');
    Route::get('/menus', App\Livewire\Admin\MenuList::class)->name('menus');
    Route::get('/settings', App\Livewire\Admin\SiteSettings::class)->name('settings');
});

