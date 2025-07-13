<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SlideshowCortroller;
use App\Http\Controllers\Backend\PopupsController; 
use App\Http\Controllers\Backend\MenuCortroller;
use App\Http\Controllers\Backend\NewsCortroller;
use App\Http\Controllers\Backend\ActivityCortroller;
use App\Http\Controllers\Backend\RelatedsitesCortroller;
use App\Http\Controllers\Backend\PageCortroller;
use App\Http\Controllers\Backend\ActiconservationController;
use App\Http\Controllers\Backend\ResearchController;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\LearningController;
use App\Http\Controllers\Backend\LearningtypeController;
use App\Http\Controllers\Backend\JournalController;
use App\Http\Controllers\Backend\QualitieController;  
use App\Http\Controllers\Backend\NetworksController;
use App\Http\Controllers\Backend\ReportannualsController;
use App\Http\Controllers\Backend\StudysController;
use App\Http\Controllers\Backend\CulturehallsController;
use App\Http\Controllers\Backend\SummernoteUploadImageController;

// Login & Register //
Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('login-check', [AuthenticationController::class, 'logincheck'])->name('login-check');
Route::post('signOut', [AuthenticationController::class, 'signOut'])->name('signOut');
Route::get('/register', [AuthenticationController::class, 'register'])->name('register')->middleware('isusers');
Route::post('registration', [AuthenticationController::class, 'registration'])->name('registration')->middleware('isusers');

// Forget //
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


// ========= Frontend ========= //
Route::get('/', [FrontendHomeController::class, 'index'])->name('index');
Route::get('/newslist', [FrontendHomeController::class, 'newslist'])->name('newslist');
Route::get('/news/{id}', [FrontendHomeController::class, 'news'])->name('news');

Route::get('/activitylist', [FrontendHomeController::class, 'activitylist'])->name('activitylist');
Route::get('/activity/{id}', [FrontendHomeController::class, 'activity'])->name('activity'); 

Route::get('/journalslist', [FrontendHomeController::class, 'journalslist'])->name('journalslist'); 
Route::get('/journals/{id}', [FrontendHomeController::class, 'journals'])->name('journals');

Route::get('/bookslist', [FrontendHomeController::class, 'bookslist'])->name('bookslist'); 
Route::get('/books/{id}', [FrontendHomeController::class, 'books'])->name('books');
  
Route::get('/researchslist', [FrontendHomeController::class, 'researchslist'])->name('researchslist'); 
Route::get('/researchs/{id}', [FrontendHomeController::class, 'researchs'])->name('researchs');

Route::get('/acticonservationslist', [FrontendHomeController::class, 'acticonservationslist'])->name('acticonservationslist'); 
Route::get('/acticonservations/{id}', [FrontendHomeController::class, 'acticonservations'])->name('acticonservations');

Route::get('/learningslist', [FrontendHomeController::class, 'learningslist'])->name('learningslist'); 
Route::get('/learnings/{id}', [FrontendHomeController::class, 'learnings'])->name('learnings');

Route::get('/networkslist', [FrontendHomeController::class, 'networkslist'])->name('networkslist');
Route::get('/networks/{id}', [FrontendHomeController::class, 'networks'])->name('networks');

Route::get('/reportannualslist', [FrontendHomeController::class, 'reportannualslist'])->name('reportannualslist'); 
Route::get('/reportannuals/{id}', [FrontendHomeController::class, 'reportannuals'])->name('reportannuals');

Route::get('/qualitieslist', [FrontendHomeController::class, 'qualitieslist'])->name('qualitieslist');
Route::get('/qualities/{id}', [FrontendHomeController::class, 'qualities'])->name('qualities');
 
Route::get('/page/{id}', [FrontendHomeController::class, 'page'])->name('page');

Route::get('/appeals', [FrontendHomeController::class, 'appeals'])->name('appeals');
Route::post('save-appeals', [FrontendHomeController::class, 'saveappeals'])->name('save.appeals');

Route::get('/studylist', [FrontendHomeController::class, 'studylist'])->name('studylist'); 
Route::get('/study/{id}', [FrontendHomeController::class, 'study'])->name('study');

Route::get('/culturehalllist', [FrontendHomeController::class, 'culturehalllist'])->name('culturehalllist'); 
Route::get('/culturehall/{id}', [FrontendHomeController::class, 'culturehall'])->name('culturehall');

Route::middleware(['isusers'])->group(function () {
    // ========= Backend ========= //
    Route::get('/home', [BackendHomeController::class, 'home'])->name('home');
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile'); 
    Route::post('save-profile', [ProfileController::class, 'saveprofile'])->name('save.profile'); 

    Route::get('/youtube-edit', [BackendHomeController::class, 'youtubeEdit'])->name('youtube.edit');
    Route::post('youtube-save', [BackendHomeController::class, 'youtubeSave'])->name('youtube.save'); 

    // Roles //
    Route::get('roles-list', [RolesController::class, 'roleslist'])->name('roles.list');
    Route::get('roles-add', [RolesController::class, 'rolesadd'])->name('roles.add'); 
    Route::get('/roles-edit/{id}', [RolesController::class, 'rolesedit'])->name('roles.edit'); 
    Route::post('close-roles', [RolesController::class, 'closeRoles'])->name('close.roles');  
    Route::post('save-roles', [RolesController::class, 'saveRoles'])->name('save.roles');  
    Route::get('datatable-roles', [RolesController::class, 'datatableRoles'])->name('datatable.roles');

    // Slideshow //
    Route::get('slideshow-list', [SlideshowCortroller::class, 'slideshowlist'])->name('slideshow.list'); 
    Route::get('datatable-slideshow', [SlideshowCortroller::class, 'datatableSlideshow'])->name('datatable.slideshow');
    Route::get('slideshow-add', [SlideshowCortroller::class, 'slideshowadd'])->name('slideshow.add'); 
    Route::get('/slideshow-edit/{id}', [SlideshowCortroller::class, 'slideshowedit'])->name('slideshow.edit'); 
    Route::post('close-slideshow', [SlideshowCortroller::class, 'closeSlideshow'])->name('close.slideshow');   
    Route::post('save-slideshow', [SlideshowCortroller::class, 'saveSlideshow'])->name('save.slideshow');

    // Popups //
    Route::get('popups-list', [PopupsController::class, 'popupslist'])->name('popups.list'); 
    Route::get('datatable-popups', [PopupsController::class, 'datatablePopups'])->name('datatable.popups');
    Route::get('popups-add', [PopupsController::class, 'popupsadd'])->name('popups.add'); 
    Route::get('/popups-edit/{id}', [PopupsController::class, 'popupsedit'])->name('popups.edit'); 
    Route::post('close-popups', [PopupsController::class, 'closePopups'])->name('close.popups');   
    Route::post('save-popups', [PopupsController::class, 'savePopups'])->name('save.popups');

     // Menu //
     Route::get('menu-list', [menuCortroller::class, 'menulist'])->name('menu.list');  
     Route::post('save-menu', [menuCortroller::class, 'savemenu'])->name('save.menu');
     Route::post('save-menu-items', [menuCortroller::class, 'savemenuitems'])->name('save.menu.items');
     
     Route::post('get-data-menu', [menuCortroller::class, 'getdatamenu'])->name('get.data.menu');
     Route::post('update-menu', [menuCortroller::class, 'updateMenu'])->name('update.menu');
     Route::post('delete-menu', [menuCortroller::class, 'deleteMenu'])->name('delete.menu');

    // News //
    Route::get('news-list', [NewsCortroller::class, 'newslist'])->name('news.list'); 
    Route::get('datatable-news', [NewsCortroller::class, 'datatableNews'])->name('datatable.news');
    Route::get('news-add', [NewsCortroller::class, 'newsadd'])->name('news.add'); 
    Route::get('/news-edit/{id}', [NewsCortroller::class, 'newsedit'])->name('news.edit'); 
    Route::post('close-news', [NewsCortroller::class, 'closeNews'])->name('close.news');  
    Route::post('save-news', [NewsCortroller::class, 'saveNews'])->name('save.news');   
    Route::post('close-news-pdf', [NewsCortroller::class, 'closeNewsPdf'])->name('close.newspdf'); 

    Route::get('/news-dropzone/{id}', [NewsCortroller::class, 'newsdropzone'])->name('news.dropzone');
    Route::post('save-news-dropzone', [NewsCortroller::class, 'saveNewsDropzone'])->name('save.news.dropzone');   
    Route::post('close-news-gallery', [NewsCortroller::class, 'closenewsgallery'])->name('close.news.gallery');  
    Route::post('close-news-dropzone-all', [NewsCortroller::class, 'closeNewsDropzoneAll'])->name('close.news.dropzone.all');  
    

    // Activity //
    Route::get('activity-list', [ActivityCortroller::class, 'activitylist'])->name('activity.list'); 
    Route::get('datatable-activity', [ActivityCortroller::class, 'datatableActivity'])->name('datatable.activity');
    Route::get('activity-add', [ActivityCortroller::class, 'activityadd'])->name('activity.add'); 
    Route::get('/activity-edit/{id}', [ActivityCortroller::class, 'activityedit'])->name('activity.edit'); 
    Route::post('close-activity', [ActivityCortroller::class, 'closeActivity'])->name('close.activity');  
    Route::post('save-activity', [ActivityCortroller::class, 'saveActivity'])->name('save.activity');   
    Route::post('close-activity-pdf', [ActivityCortroller::class, 'closeActivityPdf'])->name('close.activitypdf');
    
    Route::get('/activity-dropzone/{id}', [ActivityCortroller::class, 'activitydropzone'])->name('activity.dropzone');
    Route::post('save-activity-dropzone', [ActivityCortroller::class, 'saveActivityDropzone'])->name('save.activity.dropzone');   
    Route::post('close-activity-gallery', [ActivityCortroller::class, 'closeactivitygallery'])->name('close.activity.gallery');   
    Route::post('close-activity-dropzone-all', [ActivityCortroller::class, 'closeActivityDropzoneAll'])->name('close.activity.dropzone.all');  
    
    // Related Sites // 
    Route::get('relatedsites-list', [RelatedsitesCortroller::class, 'relatedsiteslist'])->name('relatedsites.list'); 
    Route::get('datatable-relatedsites', [RelatedsitesCortroller::class, 'datatableRelatedsites'])->name('datatable.relatedsites');
    Route::get('relatedsites-add', [RelatedsitesCortroller::class, 'relatedsitesadd'])->name('relatedsites.add'); 
    Route::get('/relatedsites-edit/{id}', [RelatedsitesCortroller::class, 'relatedsitesedit'])->name('relatedsites.edit'); 
    Route::post('close-relatedsites', [RelatedsitesCortroller::class, 'closeRelatedsites'])->name('close.relatedsites');   
    Route::post('save-relatedsites', [RelatedsitesCortroller::class, 'saveRelatedsites'])->name('save.relatedsites');

    // Page //
    Route::get('page-list', [PageCortroller::class, 'pagelist'])->name('page.list'); 
    Route::get('datatable-page', [PageCortroller::class, 'datatablePage'])->name('datatable.page');
    Route::get('page-add', [PageCortroller::class, 'pageadd'])->name('page.add'); 
    Route::get('/page-edit/{id}', [PageCortroller::class, 'pageedit'])->name('page.edit'); 
    Route::post('close-page', [PageCortroller::class, 'closePage'])->name('close.page');  
    Route::post('save-page', [PageCortroller::class, 'savePage'])->name('save.page');   
    Route::post('close-page-pdf', [PageCortroller::class, 'closePagePdf'])->name('close.pagepdf'); 

    Route::get('/page-dropzone/{id}', [PageCortroller::class, 'pagedropzone'])->name('page.dropzone');
    Route::post('save-page-dropzone', [PageCortroller::class, 'savePageDropzone'])->name('save.page.dropzone');   
    Route::post('close-page-gallery', [PageCortroller::class, 'closepagegallery'])->name('close.page.gallery'); 
    Route::post('close-page-dropzone-all', [PageCortroller::class, 'closePageDropzoneAll'])->name('close.page.dropzone.all');

    Route::post('ckeditor-upload', [PageCortroller::class, 'ckeditorupload'])->name('ckeditor.upload'); 

    // Acticonservation // 
    Route::get('acticonservation-list', [ActiconservationController::class, 'acticonservationlist'])->name('acticonservation.list'); 
    Route::get('datatable-acticonservation', [ActiconservationController::class, 'datatableActiconservation'])->name('datatable.acticonservation');
    Route::get('acticonservation-add', [ActiconservationController::class, 'acticonservationadd'])->name('acticonservation.add'); 
    Route::get('/acticonservation-edit/{id}', [ActiconservationController::class, 'acticonservationedit'])->name('acticonservation.edit'); 
    Route::post('close-acticonservation', [ActiconservationController::class, 'closeActiconservation'])->name('close.acticonservation');  
    Route::post('save-acticonservation', [ActiconservationController::class, 'saveActiconservation'])->name('save.acticonservation');   
    Route::post('close-acticonservation-pdf', [ActiconservationController::class, 'closeActiconservationPdf'])->name('close.acticonservationpdf');
    
    Route::get('/acticonservation-dropzone/{id}', [ActiconservationController::class, 'acticonservationdropzone'])->name('acticonservation.dropzone');
    Route::post('save-acticonservation-dropzone', [ActiconservationController::class, 'saveActiconservationDropzone'])->name('save.acticonservation.dropzone');   
    Route::post('close-acticonservation-gallery', [ActiconservationController::class, 'closeacticonservationgallery'])->name('close.acticonservation.gallery'); 
    Route::post('close-acticonservation-dropzone-all', [ActiconservationController::class, 'closeActiconservationDropzoneAll'])->name('close.acticonservation.dropzone.all'); 
    

    // Research // 
    Route::get('research-list', [ResearchController::class, 'researchlist'])->name('research.list'); 
    Route::get('datatable-research', [ResearchController::class, 'datatableResearch'])->name('datatable.research');
    Route::get('research-add', [ResearchController::class, 'researchadd'])->name('research.add'); 
    Route::get('/research-edit/{id}', [ResearchController::class, 'researchedit'])->name('research.edit'); 
    Route::post('close-research', [ResearchController::class, 'closeResearch'])->name('close.research');  
    Route::post('save-research', [ResearchController::class, 'saveResearch'])->name('save.research');   
    Route::post('close-research-pdf', [ResearchController::class, 'closeResearchPdf'])->name('close.researchpdf');
    
    Route::get('/research-dropzone/{id}', [ResearchController::class, 'researchdropzone'])->name('research.dropzone');
    Route::post('save-research-dropzone', [ResearchController::class, 'saveResearchDropzone'])->name('save.research.dropzone');   
    Route::post('close-research-gallery', [ResearchController::class, 'closeresearchgallery'])->name('close.research.gallery'); 
    Route::post('close-research-dropzone-all', [ResearchController::class, 'closereseaRchDropzoneAll'])->name('close.research.dropzone.all');

    // Book // 
    Route::get('book-list', [BookController::class, 'booklist'])->name('book.list'); 
    Route::get('datatable-book', [BookController::class, 'datatableBook'])->name('datatable.book');
    Route::get('book-add', [BookController::class, 'bookadd'])->name('book.add'); 
    Route::get('/book-edit/{id}', [BookController::class, 'bookedit'])->name('book.edit'); 
    Route::post('close-book', [BookController::class, 'closeBook'])->name('close.book');  
    Route::post('save-book', [BookController::class, 'saveBook'])->name('save.book');   
    Route::post('close-book-pdf', [BookController::class, 'closeBookPdf'])->name('close.bookpdf');
    
    Route::get('/book-dropzone/{id}', [BookController::class, 'bookdropzone'])->name('book.dropzone');
    Route::post('save-book-dropzone', [BookController::class, 'saveBookDropzone'])->name('save.book.dropzone');   
    Route::post('close-book-gallery', [BookController::class, 'closebookgallery'])->name('close.book.gallery'); 
    Route::post('close-book-dropzone-all', [BookController::class, 'closeBookDropzoneAll'])->name('close.book.dropzone.all');

    // Learning // 
    Route::get('learning-list', [LearningController::class, 'learninglist'])->name('learning.list'); 
    Route::get('datatable-learning', [LearningController::class, 'datatableLearning'])->name('datatable.learning');
    Route::get('learning-add', [LearningController::class, 'learningadd'])->name('learning.add'); 
    Route::get('/learning-edit/{id}', [LearningController::class, 'learningedit'])->name('learning.edit'); 
    Route::post('close-learning', [LearningController::class, 'closeLearning'])->name('close.learning');  
    Route::post('save-learning', [LearningController::class, 'saveLearning'])->name('save.learning');   
    Route::post('close-learning-pdf', [LearningController::class, 'closeLearningPdf'])->name('close.learningpdf');
    
    Route::get('/learning-dropzone/{id}', [LearningController::class, 'learningdropzone'])->name('learning.dropzone');
    Route::post('save-learning-dropzone', [LearningController::class, 'saveLearningDropzone'])->name('save.learning.dropzone');   
    Route::post('close-learning-gallery', [LearningController::class, 'closelearninggallery'])->name('close.learning.gallery'); 
    Route::post('close-learning-dropzone-all', [LearningController::class, 'closelearningDropzoneAll'])->name('close.learning.dropzone.all');

    // Learning Type // 
    Route::get('learningtype-list', [LearningtypeController::class, 'learningtypelist'])->name('learningtype.list'); 
    Route::get('datatable-learningtype', [LearningtypeController::class, 'datatableLearningtype'])->name('datatable.learningtype');
    Route::get('learningtype-add', [LearningtypeController::class, 'learningtypeadd'])->name('learningtype.add'); 
    Route::get('/learningtype-edit/{id}', [LearningtypeController::class, 'learningtypeedit'])->name('learningtype.edit'); 
    Route::post('close-learningtype', [LearningtypeController::class, 'closeLearningtype'])->name('close.learningtype');  
    Route::post('save-learningtype', [LearningtypeController::class, 'saveLearningtype'])->name('save.learningtype');    
      
 
    // Journals // 
    Route::get('journals-list', [JournalController::class, 'journalslist'])->name('journals.list'); 
    Route::get('datatable-journals', [JournalController::class, 'datatableJournals'])->name('datatable.journals');
    Route::get('journals-add', [JournalController::class, 'journalsadd'])->name('journals.add'); 
    Route::get('/journals-edit/{id}', [JournalController::class, 'journalsedit'])->name('journals.edit'); 
    Route::post('close-journals', [JournalController::class, 'closeJournals'])->name('close.journals');  
    Route::post('save-journals', [JournalController::class, 'saveJournals'])->name('save.journals');   
    Route::post('close-journals-pdf', [JournalController::class, 'closeJournalsPdf'])->name('close.journalspdf');
    
    Route::get('/journals-dropzone/{id}', [JournalController::class, 'journalsdropzone'])->name('journals.dropzone');
    Route::post('save-journals-dropzone', [JournalController::class, 'saveJournalsDropzone'])->name('save.journals.dropzone');   
    Route::post('close-journals-gallery', [JournalController::class, 'closejournalsgallery'])->name('close.journals.gallery');
    Route::post('close-journals-dropzone-all', [JournalController::class, 'closeJournalsDropzoneAll'])->name('close.journals.dropzone.all');

    // Qualitie // 
    Route::get('qualitie-list', [QualitieController::class, 'qualitielist'])->name('qualitie.list'); 
    Route::get('datatable-qualitie', [QualitieController::class, 'datatableQualities'])->name('datatable.qualitie');
    Route::get('qualitie-add', [QualitieController::class, 'qualitieadd'])->name('qualitie.add'); 
    Route::get('/qualitie-edit/{id}', [QualitieController::class, 'qualitieedit'])->name('qualitie.edit'); 
    Route::post('close-qualitie', [QualitieController::class, 'closeQualities'])->name('close.qualitie');  
    Route::post('save-qualitie', [QualitieController::class, 'saveQualities'])->name('save.qualitie');   
    Route::post('close-qualitie-pdf', [QualitieController::class, 'closeQualitiesPdf'])->name('close.qualitiepdf'); 
    
    Route::get('/qualitie-dropzone/{id}', [QualitieController::class, 'qualitiedropzone'])->name('qualitie.dropzone');
    Route::post('save-qualitie-dropzone', [QualitieController::class, 'saveQualitiesDropzone'])->name('save.qualitie.dropzone');   
    Route::post('close-qualitie-gallery', [QualitieController::class, 'closequalitiegallery'])->name('close.qualitie.gallery');
    Route::post('close-qualitie-dropzone-all', [QualitieController::class, 'closeQualitieDropzoneAll'])->name('close.qualitie.dropzone.all');
 
    // Network // 
    Route::get('networks-list', [NetworksController::class, 'networkslist'])->name('networks.list'); 
    Route::get('datatable-networks', [NetworksController::class, 'datatableNetworks'])->name('datatable.networks');
    Route::get('networks-add', [NetworksController::class, 'networksadd'])->name('networks.add'); 
    Route::get('/networks-edit/{id}', [NetworksController::class, 'networksedit'])->name('networks.edit'); 
    Route::post('close-networks', [NetworksController::class, 'closeNetworks'])->name('close.networks');  
    Route::post('save-networks', [NetworksController::class, 'saveNetworks'])->name('save.networks');   
    Route::post('close-networks-pdf', [NetworksController::class, 'closeNetworksPdf'])->name('close.networkspdf');
    
    Route::get('/networks-dropzone/{id}', [NetworksController::class, 'networksdropzone'])->name('networks.dropzone');
    Route::post('save-networks-dropzone', [NetworksController::class, 'saveNetworksDropzone'])->name('save.networks.dropzone');   
    Route::post('close-networks-gallery', [NetworksController::class, 'closenetworksgallery'])->name('close.networks.gallery'); 
    Route::post('close-networks-dropzone-all', [NetworksController::class, 'closeNetworksDropzoneAll'])->name('close.networks.dropzone.all');

    // Reportannuals // 
    Route::get('reportannuals-list', [ReportannualsController::class, 'reportannualslist'])->name('reportannuals.list'); 
    Route::get('datatable-reportannuals', [ReportannualsController::class, 'datatableReportannuals'])->name('datatable.reportannuals');
    Route::get('reportannuals-add', [ReportannualsController::class, 'reportannualsadd'])->name('reportannuals.add'); 
    Route::get('/reportannuals-edit/{id}', [ReportannualsController::class, 'reportannualsedit'])->name('reportannuals.edit'); 
    Route::post('close-reportannuals', [ReportannualsController::class, 'closeReportannuals'])->name('close.reportannuals');  
    Route::post('save-reportannuals', [ReportannualsController::class, 'saveReportannuals'])->name('save.reportannuals');   
    Route::post('close-reportannuals-pdf', [ReportannualsController::class, 'closeReportannualsPdf'])->name('close.reportannualspdf');
    
    Route::get('/reportannuals-dropzone/{id}', [ReportannualsController::class, 'reportannualsdropzone'])->name('reportannuals.dropzone');
    Route::post('save-reportannuals-dropzone', [ReportannualsController::class, 'saveReportannualsDropzone'])->name('save.reportannuals.dropzone');   
    Route::post('close-reportannuals-gallery', [ReportannualsController::class, 'closereportannualsgallery'])->name('close.reportannuals.gallery'); 
    Route::post('close-reportannuals-dropzone-all', [ReportannualsController::class, 'closeReportannualsDropzoneAll'])->name('close.reportannuals.dropzone.all');

    // Appeals // 
    Route::get('appeals-list', [BackendHomeController::class, 'appealslist'])->name('appeals.list'); 
    Route::get('/appeals-viwe/{id}', [BackendHomeController::class, 'appealsview'])->name('appeals.view'); 
    Route::get('datatable-appeals', [BackendHomeController::class, 'datatableAppeals'])->name('datatable.appeals'); 
    Route::post('close-appeals', [BackendHomeController::class, 'closeappeals'])->name('close.appeals');  

    // Studys //  
    Route::get('studys-list', [StudysController::class, 'studyslist'])->name('studys.list'); 
    Route::get('datatable-studys', [StudysController::class, 'datatableStudys'])->name('datatable.studys');
    Route::get('studys-add', [StudysController::class, 'studysadd'])->name('studys.add'); 
    Route::get('/studys-edit/{id}', [StudysController::class, 'studysedit'])->name('studys.edit'); 
    Route::post('close-studys', [StudysController::class, 'closeStudys'])->name('close.studys');  
    Route::post('save-studys', [StudysController::class, 'saveStudys'])->name('save.studys');   
    Route::post('close-studys-pdf', [StudysController::class, 'closeStudysPdf'])->name('close.studyspdf');
    
    Route::get('/studys-dropzone/{id}', [StudysController::class, 'studysdropzone'])->name('studys.dropzone');
    Route::post('save-studys-dropzone', [StudysController::class, 'saveStudysDropzone'])->name('save.studys.dropzone');   
    Route::post('close-studys-gallery', [StudysController::class, 'closestudysgallery'])->name('close.studys.gallery'); 
    Route::post('close-studys-dropzone-all', [StudysController::class, 'closeStudysDropzoneAll'])->name('close.studys.dropzone.all');

    // Culture Hall //   
    Route::get('culturehalls-list', [CulturehallsController::class, 'culturehallslist'])->name('culturehalls.list'); 
    Route::get('datatable-culturehalls', [CulturehallsController::class, 'datatableCulturehalls'])->name('datatable.culturehalls');
    Route::get('culturehalls-add', [CulturehallsController::class, 'culturehallsadd'])->name('culturehalls.add'); 
    Route::get('/culturehalls-edit/{id}', [CulturehallsController::class, 'culturehallsedit'])->name('culturehalls.edit'); 
    Route::post('close-culturehalls', [CulturehallsController::class, 'closeCulturehalls'])->name('close.culturehalls');  
    Route::post('save-culturehalls', [CulturehallsController::class, 'saveCulturehalls'])->name('save.culturehalls');   
    Route::post('close-culturehalls-pdf', [CulturehallsController::class, 'closeCulturehallsPdf'])->name('close.culturehallspdf');
    
    Route::get('/culturehalls-dropzone/{id}', [CulturehallsController::class, 'culturehallsdropzone'])->name('culturehalls.dropzone');
    Route::post('save-culturehalls-dropzone', [CulturehallsController::class, 'saveCulturehallsDropzone'])->name('save.culturehalls.dropzone');   
    Route::post('close-culturehalls-gallery', [CulturehallsController::class, 'closeculturehallsgallery'])->name('close.culturehalls.gallery'); 
    Route::post('close-culturehalls-dropzone-all', [CulturehallsController::class, 'closeCulturehallsDropzoneAll'])->name('close.culturehalls.dropzone.all');
   
    Route::post('summernote-upload-image-endpoint', [SummernoteUploadImageController::class, 'summernoteUploadImageEndpoint'])->name('summernote.upload.image.endpoint');
    Route::post('delete-image-endpoint', [SummernoteUploadImageController::class, 'deleteImageEndpoint'])->name('delete.image.endpoint');


}); 
