<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['verifyEmail'],'namespace' => 'Web\User'], function() {
    Route::get('user-dashboard', "DashboardController@dashboard")->name('web.user.dashboard');
    //Education
    Route::get('user-index-education', "EducationController@index")->name('web.user.education.index');
    Route::get('user-education-data', "EducationController@educationData")->name('web.user.education.data');
    Route::post('user-store-education', "EducationController@storeEducation")->name('web.user.education.store');
    Route::patch('user-update-education', "EducationController@updateEducation")->name('web.user.education.update');
    Route::delete('user-delete-education', "EducationController@deleteEducation")->name('web.user.education.delete');
    //Project
    Route::get('user-index-project', "ProjectController@index")->name('web.user.projects.index');
    Route::get('user-project-data', "ProjectController@projectData")->name('web.user.projects.data');
    Route::post('user-store-project', "ProjectController@storeProject")->name('web.user.projects.store');
    Route::patch('user-update-project', "ProjectController@updateProject")->name('web.user.projects.update');
    Route::delete('user-delete-project', "ProjectController@deleteProject")->name('web.user.projects.delete');
    //WorkExperience
    Route::get('user-index-workExperience', "WorkExperienceController@index")->name('web.user.workExperience.index');
    Route::get('user-workExperience-data', "WorkExperienceController@workExperienceData")->name('web.user.workExperience.data');
    Route::post('user-store-workExperience', "WorkExperienceController@storeWorkExperience")->name('web.user.workExperience.store');
    Route::patch('user-update-workExperience', "WorkExperienceController@updateWorkExperience")->name('web.user.workExperience.update');
    Route::delete('user-delete-workExperience', "WorkExperienceController@deleteWorkExperience")->name('web.user.workExperience.delete');
    //Achievement
    Route::get('user-index-achievement', "AchievementController@index")->name('web.user.achievement.index');
    Route::get('user-achievement-data', "AchievementController@achievementData")->name('web.user.achievement.data');
    Route::post('user-store-achievement', "AchievementController@storeAchievement")->name('web.user.achievement.store');
    Route::patch('user-update-achievement', "AchievementController@updateAchievement")->name('web.user.achievement.update');
    Route::delete('user-delete-achievement', "AchievementController@deleteAchievement")->name('web.user.achievement.delete');
    //Resume
    Route::get('user-index-resume', "ResumeController@index")->name('web.user.resume.index');
    Route::get('user-resume-data', "ResumeController@resumeData")->name('web.user.resume.data');
    Route::post('user-store-resume', "ResumeController@storeResume")->name('web.user.resume.store');
    Route::delete('user-delete-resume', "ResumeController@deleteResume")->name('web.user.resume.delete');
    Route::get('user-download-resume', "ResumeController@downloadResume")->name('web.user.resume.download');
});
