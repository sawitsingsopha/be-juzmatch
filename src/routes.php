<?php

namespace PHPMaker2022\juzmatch;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // address
    $app->map(["GET","POST","OPTIONS"], '/addresslist[/{address_id}]', AddressController::class . ':list')->add(PermissionMiddleware::class)->setName('addresslist-address-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/addressedit[/{address_id}]', AddressController::class . ':edit')->add(PermissionMiddleware::class)->setName('addressedit-address-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/addressdelete[/{address_id}]', AddressController::class . ':delete')->add(PermissionMiddleware::class)->setName('addressdelete-address-delete'); // delete
    $app->map(["GET","OPTIONS"], '/addresspreview', AddressController::class . ':preview')->add(PermissionMiddleware::class)->setName('addresspreview-address-preview'); // preview
    $app->group(
        '/address',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{address_id}]', AddressController::class . ':list')->add(PermissionMiddleware::class)->setName('address/list-address-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{address_id}]', AddressController::class . ':edit')->add(PermissionMiddleware::class)->setName('address/edit-address-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{address_id}]', AddressController::class . ':delete')->add(PermissionMiddleware::class)->setName('address/delete-address-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AddressController::class . ':preview')->add(PermissionMiddleware::class)->setName('address/preview-address-preview-2'); // preview
        }
    );

    // amphur
    $app->map(["GET","POST","OPTIONS"], '/amphurlist[/{amphur_id}]', AmphurController::class . ':list')->add(PermissionMiddleware::class)->setName('amphurlist-amphur-list'); // list
    $app->group(
        '/amphur',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{amphur_id}]', AmphurController::class . ':list')->add(PermissionMiddleware::class)->setName('amphur/list-amphur-list-2'); // list
        }
    );

    // appointment
    $app->map(["GET","POST","OPTIONS"], '/appointmentlist[/{appointment_id}]', AppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('appointmentlist-appointment-list'); // list
    $app->map(["GET","OPTIONS"], '/appointmentpreview', AppointmentController::class . ':preview')->add(PermissionMiddleware::class)->setName('appointmentpreview-appointment-preview'); // preview
    $app->group(
        '/appointment',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{appointment_id}]', AppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('appointment/list-appointment-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AppointmentController::class . ':preview')->add(PermissionMiddleware::class)->setName('appointment/preview-appointment-preview-2'); // preview
        }
    );

    // article
    $app->map(["GET","POST","OPTIONS"], '/articlelist[/{article_id}]', ArticleController::class . ':list')->add(PermissionMiddleware::class)->setName('articlelist-article-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/articleadd[/{article_id}]', ArticleController::class . ':add')->add(PermissionMiddleware::class)->setName('articleadd-article-add'); // add
    $app->map(["GET","OPTIONS"], '/articleview[/{article_id}]', ArticleController::class . ':view')->add(PermissionMiddleware::class)->setName('articleview-article-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/articleedit[/{article_id}]', ArticleController::class . ':edit')->add(PermissionMiddleware::class)->setName('articleedit-article-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/articledelete[/{article_id}]', ArticleController::class . ':delete')->add(PermissionMiddleware::class)->setName('articledelete-article-delete'); // delete
    $app->group(
        '/article',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{article_id}]', ArticleController::class . ':list')->add(PermissionMiddleware::class)->setName('article/list-article-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{article_id}]', ArticleController::class . ':add')->add(PermissionMiddleware::class)->setName('article/add-article-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{article_id}]', ArticleController::class . ':view')->add(PermissionMiddleware::class)->setName('article/view-article-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{article_id}]', ArticleController::class . ':edit')->add(PermissionMiddleware::class)->setName('article/edit-article-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{article_id}]', ArticleController::class . ':delete')->add(PermissionMiddleware::class)->setName('article/delete-article-delete-2'); // delete
        }
    );

    // article_banner
    $app->map(["GET","POST","OPTIONS"], '/articlebannerlist[/{article_banner_id}]', ArticleBannerController::class . ':list')->add(PermissionMiddleware::class)->setName('articlebannerlist-article_banner-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/articlebanneradd[/{article_banner_id}]', ArticleBannerController::class . ':add')->add(PermissionMiddleware::class)->setName('articlebanneradd-article_banner-add'); // add
    $app->map(["GET","OPTIONS"], '/articlebannerview[/{article_banner_id}]', ArticleBannerController::class . ':view')->add(PermissionMiddleware::class)->setName('articlebannerview-article_banner-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/articlebanneredit[/{article_banner_id}]', ArticleBannerController::class . ':edit')->add(PermissionMiddleware::class)->setName('articlebanneredit-article_banner-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/articlebannerdelete[/{article_banner_id}]', ArticleBannerController::class . ':delete')->add(PermissionMiddleware::class)->setName('articlebannerdelete-article_banner-delete'); // delete
    $app->group(
        '/article_banner',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{article_banner_id}]', ArticleBannerController::class . ':list')->add(PermissionMiddleware::class)->setName('article_banner/list-article_banner-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{article_banner_id}]', ArticleBannerController::class . ':add')->add(PermissionMiddleware::class)->setName('article_banner/add-article_banner-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{article_banner_id}]', ArticleBannerController::class . ':view')->add(PermissionMiddleware::class)->setName('article_banner/view-article_banner-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{article_banner_id}]', ArticleBannerController::class . ':edit')->add(PermissionMiddleware::class)->setName('article_banner/edit-article_banner-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{article_banner_id}]', ArticleBannerController::class . ':delete')->add(PermissionMiddleware::class)->setName('article_banner/delete-article_banner-delete-2'); // delete
        }
    );

    // article_category
    $app->map(["GET","POST","OPTIONS"], '/articlecategorylist[/{article_category_id}]', ArticleCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('articlecategorylist-article_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/articlecategoryadd[/{article_category_id}]', ArticleCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('articlecategoryadd-article_category-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/articlecategoryedit[/{article_category_id}]', ArticleCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('articlecategoryedit-article_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/articlecategorydelete[/{article_category_id}]', ArticleCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('articlecategorydelete-article_category-delete'); // delete
    $app->group(
        '/article_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{article_category_id}]', ArticleCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('article_category/list-article_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{article_category_id}]', ArticleCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('article_category/add-article_category-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{article_category_id}]', ArticleCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('article_category/edit-article_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{article_category_id}]', ArticleCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('article_category/delete-article_category-delete-2'); // delete
        }
    );

    // asset
    $app->map(["GET","POST","OPTIONS"], '/assetlist[/{asset_id}]', AssetController::class . ':list')->add(PermissionMiddleware::class)->setName('assetlist-asset-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetadd[/{asset_id}]', AssetController::class . ':add')->add(PermissionMiddleware::class)->setName('assetadd-asset-add'); // add
    $app->map(["GET","OPTIONS"], '/assetview[/{asset_id}]', AssetController::class . ':view')->add(PermissionMiddleware::class)->setName('assetview-asset-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/assetedit[/{asset_id}]', AssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetedit-asset-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetdelete[/{asset_id}]', AssetController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetdelete-asset-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetpreview', AssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetpreview-asset-preview'); // preview
    $app->group(
        '/asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_id}]', AssetController::class . ':list')->add(PermissionMiddleware::class)->setName('asset/list-asset-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_id}]', AssetController::class . ':add')->add(PermissionMiddleware::class)->setName('asset/add-asset-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{asset_id}]', AssetController::class . ':view')->add(PermissionMiddleware::class)->setName('asset/view-asset-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_id}]', AssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset/edit-asset-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_id}]', AssetController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset/delete-asset-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset/preview-asset-preview-2'); // preview
        }
    );

    // asset_attribute
    $app->map(["GET","POST","OPTIONS"], '/assetattributelist[/{asset_attribute_id}]', AssetAttributeController::class . ':list')->add(PermissionMiddleware::class)->setName('assetattributelist-asset_attribute-list'); // list
    $app->group(
        '/asset_attribute',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_attribute_id}]', AssetAttributeController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_attribute/list-asset_attribute-list-2'); // list
        }
    );

    // asset_banner
    $app->map(["GET","POST","OPTIONS"], '/assetbannerlist[/{asset_banner_id}]', AssetBannerController::class . ':list')->add(PermissionMiddleware::class)->setName('assetbannerlist-asset_banner-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetbanneradd[/{asset_banner_id}]', AssetBannerController::class . ':add')->add(PermissionMiddleware::class)->setName('assetbanneradd-asset_banner-add'); // add
    $app->map(["GET","OPTIONS"], '/assetbannerview[/{asset_banner_id}]', AssetBannerController::class . ':view')->add(PermissionMiddleware::class)->setName('assetbannerview-asset_banner-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/assetbanneredit[/{asset_banner_id}]', AssetBannerController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetbanneredit-asset_banner-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetbannerdelete[/{asset_banner_id}]', AssetBannerController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetbannerdelete-asset_banner-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetbannerpreview', AssetBannerController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetbannerpreview-asset_banner-preview'); // preview
    $app->group(
        '/asset_banner',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_banner_id}]', AssetBannerController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_banner/list-asset_banner-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_banner_id}]', AssetBannerController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_banner/add-asset_banner-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{asset_banner_id}]', AssetBannerController::class . ':view')->add(PermissionMiddleware::class)->setName('asset_banner/view-asset_banner-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_banner_id}]', AssetBannerController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_banner/edit-asset_banner-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_banner_id}]', AssetBannerController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_banner/delete-asset_banner-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetBannerController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_banner/preview-asset_banner-preview-2'); // preview
        }
    );

    // asset_category
    $app->map(["GET","POST","OPTIONS"], '/assetcategorylist[/{asset_category_id}]', AssetCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('assetcategorylist-asset_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetcategoryadd[/{asset_category_id}]', AssetCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('assetcategoryadd-asset_category-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetcategoryedit[/{asset_category_id}]', AssetCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetcategoryedit-asset_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetcategorydelete[/{asset_category_id}]', AssetCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetcategorydelete-asset_category-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetcategorypreview', AssetCategoryController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetcategorypreview-asset_category-preview'); // preview
    $app->group(
        '/asset_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_category_id}]', AssetCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_category/list-asset_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_category_id}]', AssetCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_category/add-asset_category-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_category_id}]', AssetCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_category/edit-asset_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_category_id}]', AssetCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_category/delete-asset_category-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetCategoryController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_category/preview-asset_category-preview-2'); // preview
        }
    );

    // asset_config_schedule
    $app->map(["GET","POST","OPTIONS"], '/assetconfigschedulelist[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('assetconfigschedulelist-asset_config_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetconfigscheduleadd[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('assetconfigscheduleadd-asset_config_schedule-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetconfigscheduleedit[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetconfigscheduleedit-asset_config_schedule-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetconfigscheduledelete[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetconfigscheduledelete-asset_config_schedule-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetconfigschedulepreview', AssetConfigScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetconfigschedulepreview-asset_config_schedule-preview'); // preview
    $app->group(
        '/asset_config_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_config_schedule/list-asset_config_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_config_schedule/add-asset_config_schedule-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_config_schedule/edit-asset_config_schedule-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_config_schedule_id}]', AssetConfigScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_config_schedule/delete-asset_config_schedule-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetConfigScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_config_schedule/preview-asset_config_schedule-preview-2'); // preview
        }
    );

    // asset_facilities
    $app->map(["GET","POST","OPTIONS"], '/assetfacilitieslist[/{asset_facilities_id}]', AssetFacilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('assetfacilitieslist-asset_facilities-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetfacilitiesadd[/{asset_facilities_id}]', AssetFacilitiesController::class . ':add')->add(PermissionMiddleware::class)->setName('assetfacilitiesadd-asset_facilities-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetfacilitiesedit[/{asset_facilities_id}]', AssetFacilitiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetfacilitiesedit-asset_facilities-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetfacilitiesdelete[/{asset_facilities_id}]', AssetFacilitiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetfacilitiesdelete-asset_facilities-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetfacilitiespreview', AssetFacilitiesController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetfacilitiespreview-asset_facilities-preview'); // preview
    $app->group(
        '/asset_facilities',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_facilities_id}]', AssetFacilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_facilities/list-asset_facilities-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_facilities_id}]', AssetFacilitiesController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_facilities/add-asset_facilities-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_facilities_id}]', AssetFacilitiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_facilities/edit-asset_facilities-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_facilities_id}]', AssetFacilitiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_facilities/delete-asset_facilities-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetFacilitiesController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_facilities/preview-asset_facilities-preview-2'); // preview
        }
    );

    // asset_favorite
    $app->map(["GET","POST","OPTIONS"], '/assetfavoritelist[/{asset_favorite_id}]', AssetFavoriteController::class . ':list')->add(PermissionMiddleware::class)->setName('assetfavoritelist-asset_favorite-list'); // list
    $app->map(["GET","OPTIONS"], '/assetfavoritepreview', AssetFavoriteController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetfavoritepreview-asset_favorite-preview'); // preview
    $app->group(
        '/asset_favorite',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_favorite_id}]', AssetFavoriteController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_favorite/list-asset_favorite-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetFavoriteController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_favorite/preview-asset_favorite-preview-2'); // preview
        }
    );

    // asset_interested
    $app->map(["GET","POST","OPTIONS"], '/assetinterestedlist[/{asset_interested_id}]', AssetInterestedController::class . ':list')->add(PermissionMiddleware::class)->setName('assetinterestedlist-asset_interested-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetinterestedadd[/{asset_interested_id}]', AssetInterestedController::class . ':add')->add(PermissionMiddleware::class)->setName('assetinterestedadd-asset_interested-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetinterestededit[/{asset_interested_id}]', AssetInterestedController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetinterestededit-asset_interested-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetinteresteddelete[/{asset_interested_id}]', AssetInterestedController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetinteresteddelete-asset_interested-delete'); // delete
    $app->group(
        '/asset_interested',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_interested_id}]', AssetInterestedController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_interested/list-asset_interested-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_interested_id}]', AssetInterestedController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_interested/add-asset_interested-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_interested_id}]', AssetInterestedController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_interested/edit-asset_interested-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_interested_id}]', AssetInterestedController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_interested/delete-asset_interested-delete-2'); // delete
        }
    );

    // asset_pros
    $app->map(["GET","POST","OPTIONS"], '/assetproslist[/{asset_pros_id}]', AssetProsController::class . ':list')->add(PermissionMiddleware::class)->setName('assetproslist-asset_pros-list'); // list
    $app->group(
        '/asset_pros',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_pros_id}]', AssetProsController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_pros/list-asset_pros-list-2'); // list
        }
    );

    // asset_pros_detail
    $app->map(["GET","POST","OPTIONS"], '/assetprosdetaillist[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('assetprosdetaillist-asset_pros_detail-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetprosdetailadd[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('assetprosdetailadd-asset_pros_detail-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetprosdetailedit[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetprosdetailedit-asset_pros_detail-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetprosdetaildelete[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetprosdetaildelete-asset_pros_detail-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetprosdetailpreview', AssetProsDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetprosdetailpreview-asset_pros_detail-preview'); // preview
    $app->group(
        '/asset_pros_detail',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_pros_detail/list-asset_pros_detail-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_pros_detail/add-asset_pros_detail-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_pros_detail/edit-asset_pros_detail-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_pros_detail_id}]', AssetProsDetailController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_pros_detail/delete-asset_pros_detail-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetProsDetailController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_pros_detail/preview-asset_pros_detail-preview-2'); // preview
        }
    );

    // asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/assetschedulelist[/{asset_schedule_id}]', AssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('assetschedulelist-asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetscheduleadd[/{asset_schedule_id}]', AssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('assetscheduleadd-asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/assetscheduleview[/{asset_schedule_id}]', AssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('assetscheduleview-asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/assetscheduleedit[/{asset_schedule_id}]', AssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetscheduleedit-asset_schedule-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetscheduledelete[/{asset_schedule_id}]', AssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetscheduledelete-asset_schedule-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetschedulepreview', AssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetschedulepreview-asset_schedule-preview'); // preview
    $app->group(
        '/asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_schedule_id}]', AssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_schedule/list-asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_schedule_id}]', AssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_schedule/add-asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{asset_schedule_id}]', AssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('asset_schedule/view-asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_schedule_id}]', AssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_schedule/edit-asset_schedule-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_schedule_id}]', AssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_schedule/delete-asset_schedule-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_schedule/preview-asset_schedule-preview-2'); // preview
        }
    );

    // asset_view2
    $app->map(["GET","POST","OPTIONS"], '/assetview2list', AssetView2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('assetview2list-asset_view2-list'); // list
    $app->group(
        '/asset_view2',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', AssetView2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('asset_view2/list-asset_view2-list-2'); // list
        }
    );

    // asset_warning
    $app->map(["GET","POST","OPTIONS"], '/assetwarninglist[/{asset_warning_id}]', AssetWarningController::class . ':list')->add(PermissionMiddleware::class)->setName('assetwarninglist-asset_warning-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/assetwarningadd[/{asset_warning_id}]', AssetWarningController::class . ':add')->add(PermissionMiddleware::class)->setName('assetwarningadd-asset_warning-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/assetwarningedit[/{asset_warning_id}]', AssetWarningController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetwarningedit-asset_warning-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/assetwarningdelete[/{asset_warning_id}]', AssetWarningController::class . ':delete')->add(PermissionMiddleware::class)->setName('assetwarningdelete-asset_warning-delete'); // delete
    $app->map(["GET","OPTIONS"], '/assetwarningpreview', AssetWarningController::class . ':preview')->add(PermissionMiddleware::class)->setName('assetwarningpreview-asset_warning-preview'); // preview
    $app->group(
        '/asset_warning',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_warning_id}]', AssetWarningController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_warning/list-asset_warning-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_warning_id}]', AssetWarningController::class . ':add')->add(PermissionMiddleware::class)->setName('asset_warning/add-asset_warning-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_warning_id}]', AssetWarningController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_warning/edit-asset_warning-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{asset_warning_id}]', AssetWarningController::class . ':delete')->add(PermissionMiddleware::class)->setName('asset_warning/delete-asset_warning-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AssetWarningController::class . ':preview')->add(PermissionMiddleware::class)->setName('asset_warning/preview-asset_warning-preview-2'); // preview
        }
    );

    // audittrail
    $app->map(["GET","POST","OPTIONS"], '/audittraillist[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('audittraillist-audittrail-list'); // list
    $app->group(
        '/audittrail',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('audittrail/list-audittrail-list-2'); // list
        }
    );

    // brand
    $app->map(["GET","POST","OPTIONS"], '/brandlist[/{brand_id}]', BrandController::class . ':list')->add(PermissionMiddleware::class)->setName('brandlist-brand-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/brandadd[/{brand_id}]', BrandController::class . ':add')->add(PermissionMiddleware::class)->setName('brandadd-brand-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/brandedit[/{brand_id}]', BrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('brandedit-brand-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/branddelete[/{brand_id}]', BrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('branddelete-brand-delete'); // delete
    $app->group(
        '/brand',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{brand_id}]', BrandController::class . ':list')->add(PermissionMiddleware::class)->setName('brand/list-brand-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{brand_id}]', BrandController::class . ':add')->add(PermissionMiddleware::class)->setName('brand/add-brand-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{brand_id}]', BrandController::class . ':edit')->add(PermissionMiddleware::class)->setName('brand/edit-brand-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{brand_id}]', BrandController::class . ':delete')->add(PermissionMiddleware::class)->setName('brand/delete-brand-delete-2'); // delete
        }
    );

    // buy_save_location_search
    $app->map(["GET","POST","OPTIONS"], '/buysavelocationsearchlist', BuySaveLocationSearchController::class . ':list')->add(PermissionMiddleware::class)->setName('buysavelocationsearchlist-buy_save_location_search-list'); // list
    $app->group(
        '/buy_save_location_search',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', BuySaveLocationSearchController::class . ':list')->add(PermissionMiddleware::class)->setName('buy_save_location_search/list-buy_save_location_search-list-2'); // list
        }
    );

    // buyer_asset_ready_buy
    $app->map(["GET","POST","OPTIONS"], '/buyerassetreadybuylist[/{buyer_asset_ready_buy_id}]', BuyerAssetReadyBuyController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerassetreadybuylist-buyer_asset_ready_buy-list'); // list
    $app->map(["GET","OPTIONS"], '/buyerassetreadybuypreview', BuyerAssetReadyBuyController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerassetreadybuypreview-buyer_asset_ready_buy-preview'); // preview
    $app->group(
        '/buyer_asset_ready_buy',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_asset_ready_buy_id}]', BuyerAssetReadyBuyController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_asset_ready_buy/list-buyer_asset_ready_buy-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerAssetReadyBuyController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_asset_ready_buy/preview-buyer_asset_ready_buy-preview-2'); // preview
        }
    );

    // buyer_asset_rent
    $app->map(["GET","POST","OPTIONS"], '/buyerassetrentlist[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerassetrentlist-buyer_asset_rent-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyerassetrentadd[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':add')->add(PermissionMiddleware::class)->setName('buyerassetrentadd-buyer_asset_rent-add'); // add
    $app->map(["GET","OPTIONS"], '/buyerassetrentview[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerassetrentview-buyer_asset_rent-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerassetrentedit[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerassetrentedit-buyer_asset_rent-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/buyerassetrentdelete[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyerassetrentdelete-buyer_asset_rent-delete'); // delete
    $app->map(["GET","OPTIONS"], '/buyerassetrentpreview', BuyerAssetRentController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerassetrentpreview-buyer_asset_rent-preview'); // preview
    $app->group(
        '/buyer_asset_rent',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/list-buyer_asset_rent-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':add')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/add-buyer_asset_rent-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/view-buyer_asset_rent-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/edit-buyer_asset_rent-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAssetRentController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/delete-buyer_asset_rent-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerAssetRentController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_asset_rent/preview-buyer_asset_rent-preview-2'); // preview
        }
    );

    // buyer_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/buyerassetschedulelist[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerassetschedulelist-buyer_asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyerassetscheduleadd[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('buyerassetscheduleadd-buyer_asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/buyerassetscheduleview[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerassetscheduleview-buyer_asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerassetscheduleedit[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerassetscheduleedit-buyer_asset_schedule-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/buyerassetscheduledelete[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyerassetscheduledelete-buyer_asset_schedule-delete'); // delete
    $app->map(["GET","OPTIONS"], '/buyerassetschedulepreview', BuyerAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerassetschedulepreview-buyer_asset_schedule-preview'); // preview
    $app->group(
        '/buyer_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/list-buyer_asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/add-buyer_asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/view-buyer_asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/edit-buyer_asset_schedule-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{buyer_asset_schedule_id}]', BuyerAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/delete-buyer_asset_schedule-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_asset_schedule/preview-buyer_asset_schedule-preview-2'); // preview
        }
    );

    // buyer
    $app->map(["GET","POST","OPTIONS"], '/buyerlist[/{member_id}]', BuyerController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerlist-buyer-list'); // list
    $app->map(["GET","OPTIONS"], '/buyerview[/{member_id}]', BuyerController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerview-buyer-view'); // view
    $app->group(
        '/buyer',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_id}]', BuyerController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer/list-buyer-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_id}]', BuyerController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer/view-buyer-view-2'); // view
        }
    );

    // buyer_asset
    $app->map(["GET","POST","OPTIONS"], '/buyerassetlist[/{buyer_booking_asset_id}]', BuyerAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerassetlist-buyer_asset-list'); // list
    $app->map(["GET","OPTIONS"], '/buyerassetpreview', BuyerAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerassetpreview-buyer_asset-preview'); // preview
    $app->group(
        '/buyer_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_booking_asset_id}]', BuyerAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_asset/list-buyer_asset-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_asset/preview-buyer_asset-preview-2'); // preview
        }
    );

    // buyer_booking_asset
    $app->map(["GET","POST","OPTIONS"], '/buyerbookingassetlist[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerbookingassetlist-buyer_booking_asset-list'); // list
    $app->map(["GET","OPTIONS"], '/buyerbookingassetview[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerbookingassetview-buyer_booking_asset-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerbookingassetedit[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerbookingassetedit-buyer_booking_asset-edit'); // edit
    $app->map(["GET","OPTIONS"], '/buyerbookingassetpreview', BuyerBookingAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerbookingassetpreview-buyer_booking_asset-preview'); // preview
    $app->group(
        '/buyer_booking_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_booking_asset/list-buyer_booking_asset-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_booking_asset/view-buyer_booking_asset-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_booking_asset_id}]', BuyerBookingAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_booking_asset/edit-buyer_booking_asset-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerBookingAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_booking_asset/preview-buyer_booking_asset-preview-2'); // preview
        }
    );

    // buyer_config_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/buyerconfigassetschedulelist[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerconfigassetschedulelist-buyer_config_asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyerconfigassetscheduleadd[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('buyerconfigassetscheduleadd-buyer_config_asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/buyerconfigassetscheduleview[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerconfigassetscheduleview-buyer_config_asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerconfigassetscheduleedit[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerconfigassetscheduleedit-buyer_config_asset_schedule-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/buyerconfigassetscheduledelete[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyerconfigassetscheduledelete-buyer_config_asset_schedule-delete'); // delete
    $app->map(["GET","OPTIONS"], '/buyerconfigassetschedulepreview', BuyerConfigAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerconfigassetschedulepreview-buyer_config_asset_schedule-preview'); // preview
    $app->group(
        '/buyer_config_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/list-buyer_config_asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/add-buyer_config_asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/view-buyer_config_asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/edit-buyer_config_asset_schedule-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{buyer_config_asset_schedule_id}]', BuyerConfigAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/delete-buyer_config_asset_schedule-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerConfigAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_config_asset_schedule/preview-buyer_config_asset_schedule-preview-2'); // preview
        }
    );

    // buyer_save_buy_asset
    $app->map(["GET","POST","OPTIONS"], '/buyersavebuyassetlist[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyersavebuyassetlist-buyer_save_buy_asset-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyersavebuyassetadd[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':add')->add(PermissionMiddleware::class)->setName('buyersavebuyassetadd-buyer_save_buy_asset-add'); // add
    $app->map(["GET","OPTIONS"], '/buyersavebuyassetview[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyersavebuyassetview-buyer_save_buy_asset-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyersavebuyassetedit[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyersavebuyassetedit-buyer_save_buy_asset-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/buyersavebuyassetdelete[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyersavebuyassetdelete-buyer_save_buy_asset-delete'); // delete
    $app->group(
        '/buyer_save_buy_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_save_buy_asset/list-buyer_save_buy_asset-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':add')->add(PermissionMiddleware::class)->setName('buyer_save_buy_asset/add-buyer_save_buy_asset-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_save_buy_asset/view-buyer_save_buy_asset-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_save_buy_asset/edit-buyer_save_buy_asset-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{buyer_save_buy_asset_id}]', BuyerSaveBuyAssetController::class . ':delete')->add(PermissionMiddleware::class)->setName('buyer_save_buy_asset/delete-buyer_save_buy_asset-delete-2'); // delete
        }
    );

    // buyer_verify
    $app->map(["GET","POST","OPTIONS"], '/buyerverifylist[/{buyer_verify_id}]', BuyerVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerverifylist-buyer_verify-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyerverifyedit[/{buyer_verify_id}]', BuyerVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerverifyedit-buyer_verify-edit'); // edit
    $app->map(["GET","OPTIONS"], '/buyerverifypreview', BuyerVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerverifypreview-buyer_verify-preview'); // preview
    $app->group(
        '/buyer_verify',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_verify_id}]', BuyerVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_verify/list-buyer_verify-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_verify_id}]', BuyerVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_verify/edit-buyer_verify-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_verify/preview-buyer_verify-preview-2'); // preview
        }
    );

    // category
    $app->map(["GET","POST","OPTIONS"], '/categorylist[/{category_id}]', CategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('categorylist-category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/categoryadd[/{category_id}]', CategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('categoryadd-category-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/categoryedit[/{category_id}]', CategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('categoryedit-category-edit'); // edit
    $app->group(
        '/category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{category_id}]', CategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('category/list-category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{category_id}]', CategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('category/add-category-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{category_id}]', CategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('category/edit-category-edit-2'); // edit
        }
    );

    // districts
    $app->map(["GET","POST","OPTIONS"], '/districtslist[/{district_id}]', DistrictsController::class . ':list')->add(PermissionMiddleware::class)->setName('districtslist-districts-list'); // list
    $app->group(
        '/districts',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{district_id}]', DistrictsController::class . ':list')->add(PermissionMiddleware::class)->setName('districts/list-districts-list-2'); // list
        }
    );

    // home_popup
    $app->map(["GET","POST","OPTIONS"], '/homepopuplist[/{home_popup_id}]', HomePopupController::class . ':list')->add(PermissionMiddleware::class)->setName('homepopuplist-home_popup-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/homepopupedit[/{home_popup_id}]', HomePopupController::class . ':edit')->add(PermissionMiddleware::class)->setName('homepopupedit-home_popup-edit'); // edit
    $app->group(
        '/home_popup',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{home_popup_id}]', HomePopupController::class . ':list')->add(PermissionMiddleware::class)->setName('home_popup/list-home_popup-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{home_popup_id}]', HomePopupController::class . ':edit')->add(PermissionMiddleware::class)->setName('home_popup/edit-home_popup-edit-2'); // edit
        }
    );

    // invertor_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/invertorassetschedulelist[/{invertor_asset_schedule_id}]', InvertorAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('invertorassetschedulelist-invertor_asset_schedule-list'); // list
    $app->group(
        '/invertor_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{invertor_asset_schedule_id}]', InvertorAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('invertor_asset_schedule/list-invertor_asset_schedule-list-2'); // list
        }
    );

    // invertor_booking
    $app->map(["GET","POST","OPTIONS"], '/invertorbookinglist[/{invertor_booking_id}]', InvertorBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('invertorbookinglist-invertor_booking-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/invertorbookingadd[/{invertor_booking_id}]', InvertorBookingController::class . ':add')->add(PermissionMiddleware::class)->setName('invertorbookingadd-invertor_booking-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/invertorbookingedit[/{invertor_booking_id}]', InvertorBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('invertorbookingedit-invertor_booking-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/invertorbookingdelete[/{invertor_booking_id}]', InvertorBookingController::class . ':delete')->add(PermissionMiddleware::class)->setName('invertorbookingdelete-invertor_booking-delete'); // delete
    $app->map(["GET","OPTIONS"], '/invertorbookingpreview', InvertorBookingController::class . ':preview')->add(PermissionMiddleware::class)->setName('invertorbookingpreview-invertor_booking-preview'); // preview
    $app->group(
        '/invertor_booking',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{invertor_booking_id}]', InvertorBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('invertor_booking/list-invertor_booking-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{invertor_booking_id}]', InvertorBookingController::class . ':add')->add(PermissionMiddleware::class)->setName('invertor_booking/add-invertor_booking-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{invertor_booking_id}]', InvertorBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('invertor_booking/edit-invertor_booking-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{invertor_booking_id}]', InvertorBookingController::class . ':delete')->add(PermissionMiddleware::class)->setName('invertor_booking/delete-invertor_booking-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', InvertorBookingController::class . ':preview')->add(PermissionMiddleware::class)->setName('invertor_booking/preview-invertor_booking-preview-2'); // preview
        }
    );

    // juzcalculator
    $app->map(["GET","POST","OPTIONS"], '/juzcalculatorlist[/{juzcalculator_id}]', JuzcalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculatorlist-juzcalculator-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/juzcalculatoredit[/{juzcalculator_id}]', JuzcalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('juzcalculatoredit-juzcalculator-edit'); // edit
    $app->map(["GET","OPTIONS"], '/juzcalculatorpreview', JuzcalculatorController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculatorpreview-juzcalculator-preview'); // preview
    $app->group(
        '/juzcalculator',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{juzcalculator_id}]', JuzcalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculator/list-juzcalculator-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{juzcalculator_id}]', JuzcalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('juzcalculator/edit-juzcalculator-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', JuzcalculatorController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculator/preview-juzcalculator-preview-2'); // preview
        }
    );

    // juzcalculator_income
    $app->map(["GET","POST","OPTIONS"], '/juzcalculatorincomelist[/{juzcalculator_income_id}]', JuzcalculatorIncomeController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculatorincomelist-juzcalculator_income-list'); // list
    $app->map(["GET","OPTIONS"], '/juzcalculatorincomepreview', JuzcalculatorIncomeController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculatorincomepreview-juzcalculator_income-preview'); // preview
    $app->group(
        '/juzcalculator_income',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{juzcalculator_income_id}]', JuzcalculatorIncomeController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculator_income/list-juzcalculator_income-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', JuzcalculatorIncomeController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculator_income/preview-juzcalculator_income-preview-2'); // preview
        }
    );

    // juzcalculator_outcome
    $app->map(["GET","POST","OPTIONS"], '/juzcalculatoroutcomelist[/{juzcalculator_outcome_id}]', JuzcalculatorOutcomeController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculatoroutcomelist-juzcalculator_outcome-list'); // list
    $app->map(["GET","OPTIONS"], '/juzcalculatoroutcomepreview', JuzcalculatorOutcomeController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculatoroutcomepreview-juzcalculator_outcome-preview'); // preview
    $app->group(
        '/juzcalculator_outcome',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{juzcalculator_outcome_id}]', JuzcalculatorOutcomeController::class . ':list')->add(PermissionMiddleware::class)->setName('juzcalculator_outcome/list-juzcalculator_outcome-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', JuzcalculatorOutcomeController::class . ':preview')->add(PermissionMiddleware::class)->setName('juzcalculator_outcome/preview-juzcalculator_outcome-preview-2'); // preview
        }
    );

    // master_buyer_calculator
    $app->map(["GET","POST","OPTIONS"], '/masterbuyercalculatorlist[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('masterbuyercalculatorlist-master_buyer_calculator-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/masterbuyercalculatoredit[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('masterbuyercalculatoredit-master_buyer_calculator-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/masterbuyercalculatordelete[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':delete')->add(PermissionMiddleware::class)->setName('masterbuyercalculatordelete-master_buyer_calculator-delete'); // delete
    $app->group(
        '/master_buyer_calculator',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('master_buyer_calculator/list-master_buyer_calculator-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('master_buyer_calculator/edit-master_buyer_calculator-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{master_buyer_calculator_id}]', MasterBuyerCalculatorController::class . ':delete')->add(PermissionMiddleware::class)->setName('master_buyer_calculator/delete-master_buyer_calculator-delete-2'); // delete
        }
    );

    // master_config
    $app->map(["GET","POST","OPTIONS"], '/masterconfiglist[/{master_config_id}]', MasterConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('masterconfiglist-master_config-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/masterconfigedit[/{master_config_id}]', MasterConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('masterconfigedit-master_config-edit'); // edit
    $app->group(
        '/master_config',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{master_config_id}]', MasterConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('master_config/list-master_config-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{master_config_id}]', MasterConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('master_config/edit-master_config-edit-2'); // edit
        }
    );

    // investor
    $app->map(["GET","POST","OPTIONS"], '/investorlist[/{member_id}]', InvestorController::class . ':list')->add(PermissionMiddleware::class)->setName('investorlist-investor-list'); // list
    $app->map(["GET","OPTIONS"], '/investorview[/{member_id}]', InvestorController::class . ':view')->add(PermissionMiddleware::class)->setName('investorview-investor-view'); // view
    $app->group(
        '/investor',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_id}]', InvestorController::class . ':list')->add(PermissionMiddleware::class)->setName('investor/list-investor-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_id}]', InvestorController::class . ':view')->add(PermissionMiddleware::class)->setName('investor/view-investor-view-2'); // view
        }
    );

    // master_facilities
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitieslist[/{master_facilities_id}]', MasterFacilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('masterfacilitieslist-master_facilities-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesadd[/{master_facilities_id}]', MasterFacilitiesController::class . ':add')->add(PermissionMiddleware::class)->setName('masterfacilitiesadd-master_facilities-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesedit[/{master_facilities_id}]', MasterFacilitiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('masterfacilitiesedit-master_facilities-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesdelete[/{master_facilities_id}]', MasterFacilitiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('masterfacilitiesdelete-master_facilities-delete'); // delete
    $app->group(
        '/master_facilities',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{master_facilities_id}]', MasterFacilitiesController::class . ':list')->add(PermissionMiddleware::class)->setName('master_facilities/list-master_facilities-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{master_facilities_id}]', MasterFacilitiesController::class . ':add')->add(PermissionMiddleware::class)->setName('master_facilities/add-master_facilities-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{master_facilities_id}]', MasterFacilitiesController::class . ':edit')->add(PermissionMiddleware::class)->setName('master_facilities/edit-master_facilities-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{master_facilities_id}]', MasterFacilitiesController::class . ':delete')->add(PermissionMiddleware::class)->setName('master_facilities/delete-master_facilities-delete-2'); // delete
        }
    );

    // master_facilities_group
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesgrouplist[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':list')->add(PermissionMiddleware::class)->setName('masterfacilitiesgrouplist-master_facilities_group-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesgroupadd[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':add')->add(PermissionMiddleware::class)->setName('masterfacilitiesgroupadd-master_facilities_group-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesgroupedit[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':edit')->add(PermissionMiddleware::class)->setName('masterfacilitiesgroupedit-master_facilities_group-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/masterfacilitiesgroupdelete[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':delete')->add(PermissionMiddleware::class)->setName('masterfacilitiesgroupdelete-master_facilities_group-delete'); // delete
    $app->group(
        '/master_facilities_group',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':list')->add(PermissionMiddleware::class)->setName('master_facilities_group/list-master_facilities_group-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':add')->add(PermissionMiddleware::class)->setName('master_facilities_group/add-master_facilities_group-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':edit')->add(PermissionMiddleware::class)->setName('master_facilities_group/edit-master_facilities_group-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{master_facilities_group_id}]', MasterFacilitiesGroupController::class . ':delete')->add(PermissionMiddleware::class)->setName('master_facilities_group/delete-master_facilities_group-delete-2'); // delete
        }
    );

    // master_invertor_calculator
    $app->map(["GET","POST","OPTIONS"], '/masterinvertorcalculatorlist[/{master_invertor_calculator_id}]', MasterInvertorCalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('masterinvertorcalculatorlist-master_invertor_calculator-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/masterinvertorcalculatoredit[/{master_invertor_calculator_id}]', MasterInvertorCalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('masterinvertorcalculatoredit-master_invertor_calculator-edit'); // edit
    $app->group(
        '/master_invertor_calculator',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{master_invertor_calculator_id}]', MasterInvertorCalculatorController::class . ':list')->add(PermissionMiddleware::class)->setName('master_invertor_calculator/list-master_invertor_calculator-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{master_invertor_calculator_id}]', MasterInvertorCalculatorController::class . ':edit')->add(PermissionMiddleware::class)->setName('master_invertor_calculator/edit-master_invertor_calculator-edit-2'); // edit
        }
    );

    // member
    $app->map(["GET","POST","OPTIONS"], '/memberlist[/{member_id}]', MemberController::class . ':list')->add(PermissionMiddleware::class)->setName('memberlist-member-list'); // list
    $app->map(["GET","OPTIONS"], '/memberview[/{member_id}]', MemberController::class . ':view')->add(PermissionMiddleware::class)->setName('memberview-member-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/memberedit[/{member_id}]', MemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('memberedit-member-edit'); // edit
    $app->group(
        '/member',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_id}]', MemberController::class . ':list')->add(PermissionMiddleware::class)->setName('member/list-member-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_id}]', MemberController::class . ':view')->add(PermissionMiddleware::class)->setName('member/view-member-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{member_id}]', MemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('member/edit-member-edit-2'); // edit
        }
    );

    // notification
    $app->map(["GET","POST","OPTIONS"], '/notificationlist[/{notification_id}]', NotificationController::class . ':list')->add(PermissionMiddleware::class)->setName('notificationlist-notification-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/notificationedit[/{notification_id}]', NotificationController::class . ':edit')->add(PermissionMiddleware::class)->setName('notificationedit-notification-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/notificationdelete[/{notification_id}]', NotificationController::class . ':delete')->add(PermissionMiddleware::class)->setName('notificationdelete-notification-delete'); // delete
    $app->group(
        '/notification',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{notification_id}]', NotificationController::class . ':list')->add(PermissionMiddleware::class)->setName('notification/list-notification-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{notification_id}]', NotificationController::class . ':edit')->add(PermissionMiddleware::class)->setName('notification/edit-notification-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{notification_id}]', NotificationController::class . ':delete')->add(PermissionMiddleware::class)->setName('notification/delete-notification-delete-2'); // delete
        }
    );

    // payment_inverter_booking
    $app->map(["GET","POST","OPTIONS"], '/paymentinverterbookinglist[/{payment_inverter_booking_id}]', PaymentInverterBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('paymentinverterbookinglist-payment_inverter_booking-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/paymentinverterbookingedit[/{payment_inverter_booking_id}]', PaymentInverterBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('paymentinverterbookingedit-payment_inverter_booking-edit'); // edit
    $app->map(["GET","OPTIONS"], '/paymentinverterbookingpreview', PaymentInverterBookingController::class . ':preview')->add(PermissionMiddleware::class)->setName('paymentinverterbookingpreview-payment_inverter_booking-preview'); // preview
    $app->group(
        '/payment_inverter_booking',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{payment_inverter_booking_id}]', PaymentInverterBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('payment_inverter_booking/list-payment_inverter_booking-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{payment_inverter_booking_id}]', PaymentInverterBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('payment_inverter_booking/edit-payment_inverter_booking-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', PaymentInverterBookingController::class . ':preview')->add(PermissionMiddleware::class)->setName('payment_inverter_booking/preview-payment_inverter_booking-preview-2'); // preview
        }
    );

    // plan_loan
    $app->map(["GET","POST","OPTIONS"], '/planloanlist[/{plan_loan_id}]', PlanLoanController::class . ':list')->add(PermissionMiddleware::class)->setName('planloanlist-plan_loan-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/planloanedit[/{plan_loan_id}]', PlanLoanController::class . ':edit')->add(PermissionMiddleware::class)->setName('planloanedit-plan_loan-edit'); // edit
    $app->map(["GET","OPTIONS"], '/planloanpreview', PlanLoanController::class . ':preview')->add(PermissionMiddleware::class)->setName('planloanpreview-plan_loan-preview'); // preview
    $app->group(
        '/plan_loan',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{plan_loan_id}]', PlanLoanController::class . ':list')->add(PermissionMiddleware::class)->setName('plan_loan/list-plan_loan-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{plan_loan_id}]', PlanLoanController::class . ':edit')->add(PermissionMiddleware::class)->setName('plan_loan/edit-plan_loan-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', PlanLoanController::class . ':preview')->add(PermissionMiddleware::class)->setName('plan_loan/preview-plan_loan-preview-2'); // preview
        }
    );

    // province
    $app->map(["GET","POST","OPTIONS"], '/provincelist[/{province_id}]', ProvinceController::class . ':list')->add(PermissionMiddleware::class)->setName('provincelist-province-list'); // list
    $app->group(
        '/province',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{province_id}]', ProvinceController::class . ':list')->add(PermissionMiddleware::class)->setName('province/list-province-list-2'); // list
        }
    );

    // sale_asset
    $app->map(["GET","POST","OPTIONS"], '/saleassetlist[/{sale_asset_id}]', SaleAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('saleassetlist-sale_asset-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/saleassetedit[/{sale_asset_id}]', SaleAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('saleassetedit-sale_asset-edit'); // edit
    $app->map(["GET","OPTIONS"], '/saleassetpreview', SaleAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('saleassetpreview-sale_asset-preview'); // preview
    $app->group(
        '/sale_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{sale_asset_id}]', SaleAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('sale_asset/list-sale_asset-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{sale_asset_id}]', SaleAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('sale_asset/edit-sale_asset-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', SaleAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('sale_asset/preview-sale_asset-preview-2'); // preview
        }
    );

    // save_interest
    $app->map(["GET","POST","OPTIONS"], '/saveinterestlist[/{save_interest_id}]', SaveInterestController::class . ':list')->add(PermissionMiddleware::class)->setName('saveinterestlist-save_interest-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/saveinterestadd[/{save_interest_id}]', SaveInterestController::class . ':add')->add(PermissionMiddleware::class)->setName('saveinterestadd-save_interest-add'); // add
    $app->map(["GET","OPTIONS"], '/saveinterestview[/{save_interest_id}]', SaveInterestController::class . ':view')->add(PermissionMiddleware::class)->setName('saveinterestview-save_interest-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/saveinterestedit[/{save_interest_id}]', SaveInterestController::class . ':edit')->add(PermissionMiddleware::class)->setName('saveinterestedit-save_interest-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/saveinterestdelete[/{save_interest_id}]', SaveInterestController::class . ':delete')->add(PermissionMiddleware::class)->setName('saveinterestdelete-save_interest-delete'); // delete
    $app->group(
        '/save_interest',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{save_interest_id}]', SaveInterestController::class . ':list')->add(PermissionMiddleware::class)->setName('save_interest/list-save_interest-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{save_interest_id}]', SaveInterestController::class . ':add')->add(PermissionMiddleware::class)->setName('save_interest/add-save_interest-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{save_interest_id}]', SaveInterestController::class . ':view')->add(PermissionMiddleware::class)->setName('save_interest/view-save_interest-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{save_interest_id}]', SaveInterestController::class . ':edit')->add(PermissionMiddleware::class)->setName('save_interest/edit-save_interest-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{save_interest_id}]', SaveInterestController::class . ':delete')->add(PermissionMiddleware::class)->setName('save_interest/delete-save_interest-delete-2'); // delete
        }
    );

    // save_log_search_nonmember
    $app->map(["GET","POST","OPTIONS"], '/savelogsearchnonmemberlist[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':list')->add(PermissionMiddleware::class)->setName('savelogsearchnonmemberlist-save_log_search_nonmember-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/savelogsearchnonmemberadd[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':add')->add(PermissionMiddleware::class)->setName('savelogsearchnonmemberadd-save_log_search_nonmember-add'); // add
    $app->map(["GET","OPTIONS"], '/savelogsearchnonmemberview[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':view')->add(PermissionMiddleware::class)->setName('savelogsearchnonmemberview-save_log_search_nonmember-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/savelogsearchnonmemberedit[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('savelogsearchnonmemberedit-save_log_search_nonmember-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/savelogsearchnonmemberdelete[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('savelogsearchnonmemberdelete-save_log_search_nonmember-delete'); // delete
    $app->group(
        '/save_log_search_nonmember',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':list')->add(PermissionMiddleware::class)->setName('save_log_search_nonmember/list-save_log_search_nonmember-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':add')->add(PermissionMiddleware::class)->setName('save_log_search_nonmember/add-save_log_search_nonmember-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':view')->add(PermissionMiddleware::class)->setName('save_log_search_nonmember/view-save_log_search_nonmember-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':edit')->add(PermissionMiddleware::class)->setName('save_log_search_nonmember/edit-save_log_search_nonmember-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{save_log_search_nonmember_id}]', SaveLogSearchNonmemberController::class . ':delete')->add(PermissionMiddleware::class)->setName('save_log_search_nonmember/delete-save_log_search_nonmember-delete-2'); // delete
        }
    );

    // save_search
    $app->map(["GET","POST","OPTIONS"], '/savesearchlist[/{save_search_id}]', SaveSearchController::class . ':list')->add(PermissionMiddleware::class)->setName('savesearchlist-save_search-list'); // list
    $app->map(["GET","OPTIONS"], '/savesearchpreview', SaveSearchController::class . ':preview')->add(PermissionMiddleware::class)->setName('savesearchpreview-save_search-preview'); // preview
    $app->group(
        '/save_search',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{save_search_id}]', SaveSearchController::class . ':list')->add(PermissionMiddleware::class)->setName('save_search/list-save_search-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', SaveSearchController::class . ':preview')->add(PermissionMiddleware::class)->setName('save_search/preview-save_search-preview-2'); // preview
        }
    );

    // seller_verify
    $app->map(["GET","POST","OPTIONS"], '/sellerverifylist[/{seller_verify_id}]', SellerVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('sellerverifylist-seller_verify-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/sellerverifyadd[/{seller_verify_id}]', SellerVerifyController::class . ':add')->add(PermissionMiddleware::class)->setName('sellerverifyadd-seller_verify-add'); // add
    $app->map(["GET","OPTIONS"], '/sellerverifyview[/{seller_verify_id}]', SellerVerifyController::class . ':view')->add(PermissionMiddleware::class)->setName('sellerverifyview-seller_verify-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/sellerverifyedit[/{seller_verify_id}]', SellerVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('sellerverifyedit-seller_verify-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/sellerverifydelete[/{seller_verify_id}]', SellerVerifyController::class . ':delete')->add(PermissionMiddleware::class)->setName('sellerverifydelete-seller_verify-delete'); // delete
    $app->map(["GET","OPTIONS"], '/sellerverifypreview', SellerVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('sellerverifypreview-seller_verify-preview'); // preview
    $app->group(
        '/seller_verify',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{seller_verify_id}]', SellerVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('seller_verify/list-seller_verify-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{seller_verify_id}]', SellerVerifyController::class . ':add')->add(PermissionMiddleware::class)->setName('seller_verify/add-seller_verify-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{seller_verify_id}]', SellerVerifyController::class . ':view')->add(PermissionMiddleware::class)->setName('seller_verify/view-seller_verify-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{seller_verify_id}]', SellerVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('seller_verify/edit-seller_verify-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{seller_verify_id}]', SellerVerifyController::class . ':delete')->add(PermissionMiddleware::class)->setName('seller_verify/delete-seller_verify-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', SellerVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('seller_verify/preview-seller_verify-preview-2'); // preview
        }
    );

    // setting_lang
    $app->map(["GET","POST","OPTIONS"], '/settinglanglist[/{setting_lang_id}]', SettingLangController::class . ':list')->add(PermissionMiddleware::class)->setName('settinglanglist-setting_lang-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/settinglangadd[/{setting_lang_id}]', SettingLangController::class . ':add')->add(PermissionMiddleware::class)->setName('settinglangadd-setting_lang-add'); // add
    $app->map(["GET","OPTIONS"], '/settinglangview[/{setting_lang_id}]', SettingLangController::class . ':view')->add(PermissionMiddleware::class)->setName('settinglangview-setting_lang-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/settinglangedit[/{setting_lang_id}]', SettingLangController::class . ':edit')->add(PermissionMiddleware::class)->setName('settinglangedit-setting_lang-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/settinglangdelete[/{setting_lang_id}]', SettingLangController::class . ':delete')->add(PermissionMiddleware::class)->setName('settinglangdelete-setting_lang-delete'); // delete
    $app->group(
        '/setting_lang',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{setting_lang_id}]', SettingLangController::class . ':list')->add(PermissionMiddleware::class)->setName('setting_lang/list-setting_lang-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{setting_lang_id}]', SettingLangController::class . ':add')->add(PermissionMiddleware::class)->setName('setting_lang/add-setting_lang-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{setting_lang_id}]', SettingLangController::class . ':view')->add(PermissionMiddleware::class)->setName('setting_lang/view-setting_lang-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{setting_lang_id}]', SettingLangController::class . ':edit')->add(PermissionMiddleware::class)->setName('setting_lang/edit-setting_lang-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{setting_lang_id}]', SettingLangController::class . ':delete')->add(PermissionMiddleware::class)->setName('setting_lang/delete-setting_lang-delete-2'); // delete
        }
    );

    // subdistrict
    $app->map(["GET","POST","OPTIONS"], '/subdistrictlist[/{subdistrict_id}]', SubdistrictController::class . ':list')->add(PermissionMiddleware::class)->setName('subdistrictlist-subdistrict-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/subdistrictadd[/{subdistrict_id}]', SubdistrictController::class . ':add')->add(PermissionMiddleware::class)->setName('subdistrictadd-subdistrict-add'); // add
    $app->map(["GET","OPTIONS"], '/subdistrictview[/{subdistrict_id}]', SubdistrictController::class . ':view')->add(PermissionMiddleware::class)->setName('subdistrictview-subdistrict-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/subdistrictedit[/{subdistrict_id}]', SubdistrictController::class . ':edit')->add(PermissionMiddleware::class)->setName('subdistrictedit-subdistrict-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/subdistrictdelete[/{subdistrict_id}]', SubdistrictController::class . ':delete')->add(PermissionMiddleware::class)->setName('subdistrictdelete-subdistrict-delete'); // delete
    $app->group(
        '/subdistrict',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{subdistrict_id}]', SubdistrictController::class . ':list')->add(PermissionMiddleware::class)->setName('subdistrict/list-subdistrict-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{subdistrict_id}]', SubdistrictController::class . ':add')->add(PermissionMiddleware::class)->setName('subdistrict/add-subdistrict-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{subdistrict_id}]', SubdistrictController::class . ':view')->add(PermissionMiddleware::class)->setName('subdistrict/view-subdistrict-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{subdistrict_id}]', SubdistrictController::class . ':edit')->add(PermissionMiddleware::class)->setName('subdistrict/edit-subdistrict-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{subdistrict_id}]', SubdistrictController::class . ':delete')->add(PermissionMiddleware::class)->setName('subdistrict/delete-subdistrict-delete-2'); // delete
        }
    );

    // subscriptions
    $app->map(["GET","POST","OPTIONS"], '/subscriptionslist[/{id}]', SubscriptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('subscriptionslist-subscriptions-list'); // list
    $app->group(
        '/subscriptions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', SubscriptionsController::class . ':list')->add(PermissionMiddleware::class)->setName('subscriptions/list-subscriptions-list-2'); // list
        }
    );

    // todo_list
    $app->map(["GET","POST","OPTIONS"], '/todolistlist[/{todo_list_id}]', TodoListController::class . ':list')->add(PermissionMiddleware::class)->setName('todolistlist-todo_list-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/todolistadd[/{todo_list_id}]', TodoListController::class . ':add')->add(PermissionMiddleware::class)->setName('todolistadd-todo_list-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/todolistedit[/{todo_list_id}]', TodoListController::class . ':edit')->add(PermissionMiddleware::class)->setName('todolistedit-todo_list-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/todolistdelete[/{todo_list_id}]', TodoListController::class . ':delete')->add(PermissionMiddleware::class)->setName('todolistdelete-todo_list-delete'); // delete
    $app->map(["GET","OPTIONS"], '/todolistpreview', TodoListController::class . ':preview')->add(PermissionMiddleware::class)->setName('todolistpreview-todo_list-preview'); // preview
    $app->group(
        '/todo_list',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{todo_list_id}]', TodoListController::class . ':list')->add(PermissionMiddleware::class)->setName('todo_list/list-todo_list-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{todo_list_id}]', TodoListController::class . ':add')->add(PermissionMiddleware::class)->setName('todo_list/add-todo_list-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{todo_list_id}]', TodoListController::class . ':edit')->add(PermissionMiddleware::class)->setName('todo_list/edit-todo_list-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{todo_list_id}]', TodoListController::class . ':delete')->add(PermissionMiddleware::class)->setName('todo_list/delete-todo_list-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', TodoListController::class . ':preview')->add(PermissionMiddleware::class)->setName('todo_list/preview-todo_list-preview-2'); // preview
        }
    );

    // userlevelpermissions
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionslist[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissionslist-userlevelpermissions-list'); // list
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
        }
    );

    // userlevels
    $app->map(["GET","POST","OPTIONS"], '/userlevelslist[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelslist-userlevels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/userlevelsadd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelsadd-userlevels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/userlevelsedit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelsedit-userlevels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/userlevelsdelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelsdelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // users
    $app->map(["GET","POST","OPTIONS"], '/userslist[/{users_id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('userslist-users-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/usersadd[/{users_id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('usersadd-users-add'); // add
    $app->map(["GET","OPTIONS"], '/usersview[/{users_id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('usersview-users-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/usersedit[/{users_id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('usersedit-users-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/usersdelete[/{users_id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('usersdelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{users_id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{users_id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{users_id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{users_id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{users_id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // seller
    $app->map(["GET","POST","OPTIONS"], '/sellerlist[/{member_id}]', SellerController::class . ':list')->add(PermissionMiddleware::class)->setName('sellerlist-seller-list'); // list
    $app->map(["GET","OPTIONS"], '/sellerview[/{member_id}]', SellerController::class . ':view')->add(PermissionMiddleware::class)->setName('sellerview-seller-view'); // view
    $app->group(
        '/seller',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_id}]', SellerController::class . ':list')->add(PermissionMiddleware::class)->setName('seller/list-seller-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_id}]', SellerController::class . ':view')->add(PermissionMiddleware::class)->setName('seller/view-seller-view-2'); // view
        }
    );

    // seller_appointment
    $app->map(["GET","POST","OPTIONS"], '/sellerappointmentlist[/{appointment_id}]', SellerAppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('sellerappointmentlist-seller_appointment-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/sellerappointmentedit[/{appointment_id}]', SellerAppointmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('sellerappointmentedit-seller_appointment-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/sellerappointmentdelete[/{appointment_id}]', SellerAppointmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('sellerappointmentdelete-seller_appointment-delete'); // delete
    $app->group(
        '/seller_appointment',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{appointment_id}]', SellerAppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('seller_appointment/list-seller_appointment-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{appointment_id}]', SellerAppointmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('seller_appointment/edit-seller_appointment-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{appointment_id}]', SellerAppointmentController::class . ':delete')->add(PermissionMiddleware::class)->setName('seller_appointment/delete-seller_appointment-delete-2'); // delete
        }
    );

    // member_scb
    $app->map(["GET","POST","OPTIONS"], '/memberscblist[/{member_scb_id}]', MemberScbController::class . ':list')->add(PermissionMiddleware::class)->setName('memberscblist-member_scb-list'); // list
    $app->map(["GET","OPTIONS"], '/memberscbview[/{member_scb_id}]', MemberScbController::class . ':view')->add(PermissionMiddleware::class)->setName('memberscbview-member_scb-view'); // view
    $app->group(
        '/member_scb',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_scb_id}]', MemberScbController::class . ':list')->add(PermissionMiddleware::class)->setName('member_scb/list-member_scb-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_scb_id}]', MemberScbController::class . ':view')->add(PermissionMiddleware::class)->setName('member_scb/view-member_scb-view-2'); // view
        }
    );

    // member_scb_detail
    $app->map(["GET","POST","OPTIONS"], '/memberscbdetaillist[/{member_scb_detail_id}]', MemberScbDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('memberscbdetaillist-member_scb_detail-list'); // list
    $app->group(
        '/member_scb_detail',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_scb_detail_id}]', MemberScbDetailController::class . ':list')->add(PermissionMiddleware::class)->setName('member_scb_detail/list-member_scb_detail-list-2'); // list
        }
    );

    // inverter_asset
    $app->map(["GET","POST","OPTIONS"], '/inverterassetlist[/{payment_inverter_booking_id}]', InverterAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('inverterassetlist-inverter_asset-list'); // list
    $app->map(["GET","OPTIONS"], '/inverterassetpreview', InverterAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('inverterassetpreview-inverter_asset-preview'); // preview
    $app->group(
        '/inverter_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{payment_inverter_booking_id}]', InverterAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('inverter_asset/list-inverter_asset-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', InverterAssetController::class . ':preview')->add(PermissionMiddleware::class)->setName('inverter_asset/preview-inverter_asset-preview-2'); // preview
        }
    );

    // web_config
    $app->map(["GET","POST","OPTIONS"], '/webconfiglist[/{web_config_id}]', WebConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('webconfiglist-web_config-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/webconfigedit[/{web_config_id}]', WebConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('webconfigedit-web_config-edit'); // edit
    $app->group(
        '/web_config',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{web_config_id}]', WebConfigController::class . ':list')->add(PermissionMiddleware::class)->setName('web_config/list-web_config-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{web_config_id}]', WebConfigController::class . ':edit')->add(PermissionMiddleware::class)->setName('web_config/edit-web_config-edit-2'); // edit
        }
    );

    // investor_verify
    $app->map(["GET","POST","OPTIONS"], '/investorverifylist[/{juzcalculator_id}]', InvestorVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('investorverifylist-investor_verify-list'); // list
    $app->map(["GET","OPTIONS"], '/investorverifyview[/{juzcalculator_id}]', InvestorVerifyController::class . ':view')->add(PermissionMiddleware::class)->setName('investorverifyview-investor_verify-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/investorverifyedit[/{juzcalculator_id}]', InvestorVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('investorverifyedit-investor_verify-edit'); // edit
    $app->map(["GET","OPTIONS"], '/investorverifypreview', InvestorVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('investorverifypreview-investor_verify-preview'); // preview
    $app->group(
        '/investor_verify',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{juzcalculator_id}]', InvestorVerifyController::class . ':list')->add(PermissionMiddleware::class)->setName('investor_verify/list-investor_verify-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{juzcalculator_id}]', InvestorVerifyController::class . ':view')->add(PermissionMiddleware::class)->setName('investor_verify/view-investor_verify-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{juzcalculator_id}]', InvestorVerifyController::class . ':edit')->add(PermissionMiddleware::class)->setName('investor_verify/edit-investor_verify-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', InvestorVerifyController::class . ':preview')->add(PermissionMiddleware::class)->setName('investor_verify/preview-investor_verify-preview-2'); // preview
        }
    );

    // dashboard2
    $app->map(["GET", "POST", "OPTIONS"], '/dashboard/dashboard2[/{params:.*}]', Dashboard2Controller::class)->add(PermissionMiddleware::class)->setName('dashboard/dashboard2-dashboard2-custom'); // custom

    // investorReceiveMonthly
    $app->map(["GET", "POST", "OPTIONS"], '/investorreceivemonthly/investorreceivemonthly[/{params:.*}]', InvestorReceiveMonthlyController::class)->add(PermissionMiddleware::class)->setName('investorreceivemonthly/investorreceivemonthly-investorReceiveMonthly-custom'); // custom

    // buyerPaymentMonthly
    $app->map(["GET", "POST", "OPTIONS"], '/buyerpaymentmonthly/buyerpaymentmonthly[/{params:.*}]', BuyerPaymentMonthlyController::class)->add(PermissionMiddleware::class)->setName('buyerpaymentmonthly/buyerpaymentmonthly-buyerPaymentMonthly-custom'); // custom

    // buyer_all_booking_asset
    $app->map(["GET","POST","OPTIONS"], '/buyerallbookingassetlist[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerallbookingassetlist-buyer_all_booking_asset-list'); // list
    $app->map(["GET","OPTIONS"], '/buyerallbookingassetview[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerallbookingassetview-buyer_all_booking_asset-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerallbookingassetedit[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerallbookingassetedit-buyer_all_booking_asset-edit'); // edit
    $app->group(
        '/buyer_all_booking_asset',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_all_booking_asset/list-buyer_all_booking_asset-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_all_booking_asset/view-buyer_all_booking_asset-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_booking_asset_id}]', BuyerAllBookingAssetController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_all_booking_asset/edit-buyer_all_booking_asset-edit-2'); // edit
        }
    );

    // invertor_all_booking
    $app->map(["GET","POST","OPTIONS"], '/invertorallbookinglist[/{invertor_booking_id}]', InvertorAllBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('invertorallbookinglist-invertor_all_booking-list'); // list
    $app->map(["GET","OPTIONS"], '/invertorallbookingview[/{invertor_booking_id}]', InvertorAllBookingController::class . ':view')->add(PermissionMiddleware::class)->setName('invertorallbookingview-invertor_all_booking-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/invertorallbookingedit[/{invertor_booking_id}]', InvertorAllBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('invertorallbookingedit-invertor_all_booking-edit'); // edit
    $app->group(
        '/invertor_all_booking',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{invertor_booking_id}]', InvertorAllBookingController::class . ':list')->add(PermissionMiddleware::class)->setName('invertor_all_booking/list-invertor_all_booking-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{invertor_booking_id}]', InvertorAllBookingController::class . ':view')->add(PermissionMiddleware::class)->setName('invertor_all_booking/view-invertor_all_booking-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{invertor_booking_id}]', InvertorAllBookingController::class . ':edit')->add(PermissionMiddleware::class)->setName('invertor_all_booking/edit-invertor_all_booking-edit-2'); // edit
        }
    );

    // buyer_all_asset_rent
    $app->map(["GET","POST","OPTIONS"], '/buyerallassetrentlist[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':list')->add(PermissionMiddleware::class)->setName('buyerallassetrentlist-buyer_all_asset_rent-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/buyerallassetrentadd[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':add')->add(PermissionMiddleware::class)->setName('buyerallassetrentadd-buyer_all_asset_rent-add'); // add
    $app->map(["GET","OPTIONS"], '/buyerallassetrentview[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':view')->add(PermissionMiddleware::class)->setName('buyerallassetrentview-buyer_all_asset_rent-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/buyerallassetrentedit[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyerallassetrentedit-buyer_all_asset_rent-edit'); // edit
    $app->map(["GET","OPTIONS"], '/buyerallassetrentpreview', BuyerAllAssetRentController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyerallassetrentpreview-buyer_all_asset_rent-preview'); // preview
    $app->group(
        '/buyer_all_asset_rent',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':list')->add(PermissionMiddleware::class)->setName('buyer_all_asset_rent/list-buyer_all_asset_rent-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':add')->add(PermissionMiddleware::class)->setName('buyer_all_asset_rent/add-buyer_all_asset_rent-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':view')->add(PermissionMiddleware::class)->setName('buyer_all_asset_rent/view-buyer_all_asset_rent-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_asset_rent_id}]', BuyerAllAssetRentController::class . ':edit')->add(PermissionMiddleware::class)->setName('buyer_all_asset_rent/edit-buyer_all_asset_rent-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', BuyerAllAssetRentController::class . ':preview')->add(PermissionMiddleware::class)->setName('buyer_all_asset_rent/preview-buyer_all_asset_rent-preview-2'); // preview
        }
    );

    // log_notification
    $app->map(["GET","POST","OPTIONS"], '/lognotificationlist[/{log_notification_id}]', LogNotificationController::class . ':list')->add(PermissionMiddleware::class)->setName('lognotificationlist-log_notification-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/lognotificationadd[/{log_notification_id}]', LogNotificationController::class . ':add')->add(PermissionMiddleware::class)->setName('lognotificationadd-log_notification-add'); // add
    $app->map(["GET","OPTIONS"], '/lognotificationview[/{log_notification_id}]', LogNotificationController::class . ':view')->add(PermissionMiddleware::class)->setName('lognotificationview-log_notification-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/lognotificationedit[/{log_notification_id}]', LogNotificationController::class . ':edit')->add(PermissionMiddleware::class)->setName('lognotificationedit-log_notification-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/lognotificationdelete[/{log_notification_id}]', LogNotificationController::class . ':delete')->add(PermissionMiddleware::class)->setName('lognotificationdelete-log_notification-delete'); // delete
    $app->group(
        '/log_notification',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{log_notification_id}]', LogNotificationController::class . ':list')->add(PermissionMiddleware::class)->setName('log_notification/list-log_notification-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{log_notification_id}]', LogNotificationController::class . ':add')->add(PermissionMiddleware::class)->setName('log_notification/add-log_notification-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{log_notification_id}]', LogNotificationController::class . ':view')->add(PermissionMiddleware::class)->setName('log_notification/view-log_notification-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{log_notification_id}]', LogNotificationController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_notification/edit-log_notification-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{log_notification_id}]', LogNotificationController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_notification/delete-log_notification-delete-2'); // delete
        }
    );

    // log_send_email
    $app->map(["GET","POST","OPTIONS"], '/logsendemaillist[/{log_email_id}]', LogSendEmailController::class . ':list')->add(PermissionMiddleware::class)->setName('logsendemaillist-log_send_email-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/logsendemailadd[/{log_email_id}]', LogSendEmailController::class . ':add')->add(PermissionMiddleware::class)->setName('logsendemailadd-log_send_email-add'); // add
    $app->map(["GET","OPTIONS"], '/logsendemailview[/{log_email_id}]', LogSendEmailController::class . ':view')->add(PermissionMiddleware::class)->setName('logsendemailview-log_send_email-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/logsendemailedit[/{log_email_id}]', LogSendEmailController::class . ':edit')->add(PermissionMiddleware::class)->setName('logsendemailedit-log_send_email-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/logsendemaildelete[/{log_email_id}]', LogSendEmailController::class . ':delete')->add(PermissionMiddleware::class)->setName('logsendemaildelete-log_send_email-delete'); // delete
    $app->group(
        '/log_send_email',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{log_email_id}]', LogSendEmailController::class . ':list')->add(PermissionMiddleware::class)->setName('log_send_email/list-log_send_email-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{log_email_id}]', LogSendEmailController::class . ':add')->add(PermissionMiddleware::class)->setName('log_send_email/add-log_send_email-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{log_email_id}]', LogSendEmailController::class . ':view')->add(PermissionMiddleware::class)->setName('log_send_email/view-log_send_email-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{log_email_id}]', LogSendEmailController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_send_email/edit-log_send_email-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{log_email_id}]', LogSendEmailController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_send_email/delete-log_send_email-delete-2'); // delete
        }
    );

    // all_asset_config_schedule
    $app->map(["GET","POST","OPTIONS"], '/allassetconfigschedulelist[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('allassetconfigschedulelist-all_asset_config_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/allassetconfigscheduleadd[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('allassetconfigscheduleadd-all_asset_config_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/allassetconfigscheduleview[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('allassetconfigscheduleview-all_asset_config_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/allassetconfigscheduleedit[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('allassetconfigscheduleedit-all_asset_config_schedule-edit'); // edit
    $app->map(["GET","OPTIONS"], '/allassetconfigschedulepreview', AllAssetConfigScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('allassetconfigschedulepreview-all_asset_config_schedule-preview'); // preview
    $app->group(
        '/all_asset_config_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('all_asset_config_schedule/list-all_asset_config_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('all_asset_config_schedule/add-all_asset_config_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('all_asset_config_schedule/view-all_asset_config_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_config_schedule_id}]', AllAssetConfigScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('all_asset_config_schedule/edit-all_asset_config_schedule-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AllAssetConfigScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('all_asset_config_schedule/preview-all_asset_config_schedule-preview-2'); // preview
        }
    );

    // all_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/allassetschedulelist[/{asset_schedule_id}]', AllAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('allassetschedulelist-all_asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/allassetscheduleadd[/{asset_schedule_id}]', AllAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('allassetscheduleadd-all_asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/allassetscheduleview[/{asset_schedule_id}]', AllAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('allassetscheduleview-all_asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/allassetscheduleedit[/{asset_schedule_id}]', AllAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('allassetscheduleedit-all_asset_schedule-edit'); // edit
    $app->map(["GET","OPTIONS"], '/allassetschedulepreview', AllAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('allassetschedulepreview-all_asset_schedule-preview'); // preview
    $app->group(
        '/all_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_schedule_id}]', AllAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('all_asset_schedule/list-all_asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{asset_schedule_id}]', AllAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('all_asset_schedule/add-all_asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{asset_schedule_id}]', AllAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('all_asset_schedule/view-all_asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{asset_schedule_id}]', AllAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('all_asset_schedule/edit-all_asset_schedule-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AllAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('all_asset_schedule/preview-all_asset_schedule-preview-2'); // preview
        }
    );

    // all_buyer_config_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/allbuyerconfigassetschedulelist[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetschedulelist-all_buyer_config_asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/allbuyerconfigassetscheduleadd[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetscheduleadd-all_buyer_config_asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/allbuyerconfigassetscheduleview[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetscheduleview-all_buyer_config_asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/allbuyerconfigassetscheduleedit[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetscheduleedit-all_buyer_config_asset_schedule-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/allbuyerconfigassetscheduledelete[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetscheduledelete-all_buyer_config_asset_schedule-delete'); // delete
    $app->map(["GET","OPTIONS"], '/allbuyerconfigassetschedulepreview', AllBuyerConfigAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('allbuyerconfigassetschedulepreview-all_buyer_config_asset_schedule-preview'); // preview
    $app->group(
        '/all_buyer_config_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/list-all_buyer_config_asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/add-all_buyer_config_asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/view-all_buyer_config_asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/edit-all_buyer_config_asset_schedule-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{buyer_config_asset_schedule_id}]', AllBuyerConfigAssetScheduleController::class . ':delete')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/delete-all_buyer_config_asset_schedule-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AllBuyerConfigAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('all_buyer_config_asset_schedule/preview-all_buyer_config_asset_schedule-preview-2'); // preview
        }
    );

    // all_buyer_asset_schedule
    $app->map(["GET","POST","OPTIONS"], '/allbuyerassetschedulelist[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('allbuyerassetschedulelist-all_buyer_asset_schedule-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/allbuyerassetscheduleadd[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('allbuyerassetscheduleadd-all_buyer_asset_schedule-add'); // add
    $app->map(["GET","OPTIONS"], '/allbuyerassetscheduleview[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('allbuyerassetscheduleview-all_buyer_asset_schedule-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/allbuyerassetscheduleedit[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('allbuyerassetscheduleedit-all_buyer_asset_schedule-edit'); // edit
    $app->map(["GET","OPTIONS"], '/allbuyerassetschedulepreview', AllBuyerAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('allbuyerassetschedulepreview-all_buyer_asset_schedule-preview'); // preview
    $app->group(
        '/all_buyer_asset_schedule',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':list')->add(PermissionMiddleware::class)->setName('all_buyer_asset_schedule/list-all_buyer_asset_schedule-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':add')->add(PermissionMiddleware::class)->setName('all_buyer_asset_schedule/add-all_buyer_asset_schedule-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':view')->add(PermissionMiddleware::class)->setName('all_buyer_asset_schedule/view-all_buyer_asset_schedule-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{buyer_asset_schedule_id}]', AllBuyerAssetScheduleController::class . ':edit')->add(PermissionMiddleware::class)->setName('all_buyer_asset_schedule/edit-all_buyer_asset_schedule-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', AllBuyerAssetScheduleController::class . ':preview')->add(PermissionMiddleware::class)->setName('all_buyer_asset_schedule/preview-all_buyer_asset_schedule-preview-2'); // preview
        }
    );

    // asset_appointment
    $app->map(["GET","POST","OPTIONS"], '/assetappointmentlist[/{appointment_id}]', AssetAppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('assetappointmentlist-asset_appointment-list'); // list
    $app->map(["GET","OPTIONS"], '/assetappointmentview[/{appointment_id}]', AssetAppointmentController::class . ':view')->add(PermissionMiddleware::class)->setName('assetappointmentview-asset_appointment-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/assetappointmentedit[/{appointment_id}]', AssetAppointmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('assetappointmentedit-asset_appointment-edit'); // edit
    $app->group(
        '/asset_appointment',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{appointment_id}]', AssetAppointmentController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_appointment/list-asset_appointment-list-2'); // list
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{appointment_id}]', AssetAppointmentController::class . ':view')->add(PermissionMiddleware::class)->setName('asset_appointment/view-asset_appointment-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{appointment_id}]', AssetAppointmentController::class . ':edit')->add(PermissionMiddleware::class)->setName('asset_appointment/edit-asset_appointment-edit-2'); // edit
        }
    );

    // asset_address
    $app->map(["GET","POST","OPTIONS"], '/assetaddresslist[/{asset_id}]', AssetAddressController::class . ':list')->add(PermissionMiddleware::class)->setName('assetaddresslist-asset_address-list'); // list
    $app->group(
        '/asset_address',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{asset_id}]', AssetAddressController::class . ':list')->add(PermissionMiddleware::class)->setName('asset_address/list-asset_address-list-2'); // list
        }
    );

    // log_member_scb
    $app->map(["GET","POST","OPTIONS"], '/logmemberscblist[/{log_member_scb_id}]', LogMemberScbController::class . ':list')->add(PermissionMiddleware::class)->setName('logmemberscblist-log_member_scb-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/logmemberscbadd[/{log_member_scb_id}]', LogMemberScbController::class . ':add')->add(PermissionMiddleware::class)->setName('logmemberscbadd-log_member_scb-add'); // add
    $app->map(["GET","OPTIONS"], '/logmemberscbview[/{log_member_scb_id}]', LogMemberScbController::class . ':view')->add(PermissionMiddleware::class)->setName('logmemberscbview-log_member_scb-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/logmemberscbedit[/{log_member_scb_id}]', LogMemberScbController::class . ':edit')->add(PermissionMiddleware::class)->setName('logmemberscbedit-log_member_scb-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/logmemberscbdelete[/{log_member_scb_id}]', LogMemberScbController::class . ':delete')->add(PermissionMiddleware::class)->setName('logmemberscbdelete-log_member_scb-delete'); // delete
    $app->group(
        '/log_member_scb',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{log_member_scb_id}]', LogMemberScbController::class . ':list')->add(PermissionMiddleware::class)->setName('log_member_scb/list-log_member_scb-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{log_member_scb_id}]', LogMemberScbController::class . ':add')->add(PermissionMiddleware::class)->setName('log_member_scb/add-log_member_scb-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{log_member_scb_id}]', LogMemberScbController::class . ':view')->add(PermissionMiddleware::class)->setName('log_member_scb/view-log_member_scb-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{log_member_scb_id}]', LogMemberScbController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_member_scb/edit-log_member_scb-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{log_member_scb_id}]', LogMemberScbController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_member_scb/delete-log_member_scb-delete-2'); // delete
        }
    );

    // member_scb_detail_log
    $app->map(["GET","POST","OPTIONS"], '/memberscbdetailloglist[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':list')->add(PermissionMiddleware::class)->setName('memberscbdetailloglist-member_scb_detail_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/memberscbdetaillogadd[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':add')->add(PermissionMiddleware::class)->setName('memberscbdetaillogadd-member_scb_detail_log-add'); // add
    $app->map(["GET","OPTIONS"], '/memberscbdetaillogview[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':view')->add(PermissionMiddleware::class)->setName('memberscbdetaillogview-member_scb_detail_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/memberscbdetaillogedit[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('memberscbdetaillogedit-member_scb_detail_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/memberscbdetaillogdelete[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('memberscbdetaillogdelete-member_scb_detail_log-delete'); // delete
    $app->group(
        '/member_scb_detail_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':list')->add(PermissionMiddleware::class)->setName('member_scb_detail_log/list-member_scb_detail_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':add')->add(PermissionMiddleware::class)->setName('member_scb_detail_log/add-member_scb_detail_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':view')->add(PermissionMiddleware::class)->setName('member_scb_detail_log/view-member_scb_detail_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('member_scb_detail_log/edit-member_scb_detail_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{member_scb_detail_log_id}]', MemberScbDetailLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('member_scb_detail_log/delete-member_scb_detail_log-delete-2'); // delete
        }
    );

    // peak_contact
    $app->map(["GET","POST","OPTIONS"], '/peakcontactlist[/{id}]', PeakContactController::class . ':list')->add(PermissionMiddleware::class)->setName('peakcontactlist-peak_contact-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakcontactadd[/{id}]', PeakContactController::class . ':add')->add(PermissionMiddleware::class)->setName('peakcontactadd-peak_contact-add'); // add
    $app->map(["GET","OPTIONS"], '/peakcontactview[/{id}]', PeakContactController::class . ':view')->add(PermissionMiddleware::class)->setName('peakcontactview-peak_contact-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakcontactedit[/{id}]', PeakContactController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakcontactedit-peak_contact-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakcontactdelete[/{id}]', PeakContactController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakcontactdelete-peak_contact-delete'); // delete
    $app->group(
        '/peak_contact',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PeakContactController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_contact/list-peak_contact-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PeakContactController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_contact/add-peak_contact-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PeakContactController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_contact/view-peak_contact-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PeakContactController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_contact/edit-peak_contact-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PeakContactController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_contact/delete-peak_contact-delete-2'); // delete
        }
    );

    // peak_product
    $app->map(["GET","POST","OPTIONS"], '/peakproductlist[/{id}]', PeakProductController::class . ':list')->add(PermissionMiddleware::class)->setName('peakproductlist-peak_product-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakproductadd[/{id}]', PeakProductController::class . ':add')->add(PermissionMiddleware::class)->setName('peakproductadd-peak_product-add'); // add
    $app->map(["GET","OPTIONS"], '/peakproductview[/{id}]', PeakProductController::class . ':view')->add(PermissionMiddleware::class)->setName('peakproductview-peak_product-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakproductedit[/{id}]', PeakProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakproductedit-peak_product-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakproductdelete[/{id}]', PeakProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakproductdelete-peak_product-delete'); // delete
    $app->group(
        '/peak_product',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PeakProductController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_product/list-peak_product-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PeakProductController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_product/add-peak_product-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PeakProductController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_product/view-peak_product-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PeakProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_product/edit-peak_product-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PeakProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_product/delete-peak_product-delete-2'); // delete
        }
    );

    // peak_receipt
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptlist[/{id}]', PeakReceiptController::class . ':list')->add(PermissionMiddleware::class)->setName('peakreceiptlist-peak_receipt-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptadd[/{id}]', PeakReceiptController::class . ':add')->add(PermissionMiddleware::class)->setName('peakreceiptadd-peak_receipt-add'); // add
    $app->map(["GET","OPTIONS"], '/peakreceiptview[/{id}]', PeakReceiptController::class . ':view')->add(PermissionMiddleware::class)->setName('peakreceiptview-peak_receipt-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptedit[/{id}]', PeakReceiptController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakreceiptedit-peak_receipt-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptdelete[/{id}]', PeakReceiptController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakreceiptdelete-peak_receipt-delete'); // delete
    $app->group(
        '/peak_receipt',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PeakReceiptController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_receipt/list-peak_receipt-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PeakReceiptController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_receipt/add-peak_receipt-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PeakReceiptController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_receipt/view-peak_receipt-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PeakReceiptController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_receipt/edit-peak_receipt-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PeakReceiptController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_receipt/delete-peak_receipt-delete-2'); // delete
        }
    );

    // peak_receipt_product
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptproductlist[/{id}]', PeakReceiptProductController::class . ':list')->add(PermissionMiddleware::class)->setName('peakreceiptproductlist-peak_receipt_product-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptproductadd[/{id}]', PeakReceiptProductController::class . ':add')->add(PermissionMiddleware::class)->setName('peakreceiptproductadd-peak_receipt_product-add'); // add
    $app->map(["GET","OPTIONS"], '/peakreceiptproductview[/{id}]', PeakReceiptProductController::class . ':view')->add(PermissionMiddleware::class)->setName('peakreceiptproductview-peak_receipt_product-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptproductedit[/{id}]', PeakReceiptProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakreceiptproductedit-peak_receipt_product-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakreceiptproductdelete[/{id}]', PeakReceiptProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakreceiptproductdelete-peak_receipt_product-delete'); // delete
    $app->group(
        '/peak_receipt_product',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PeakReceiptProductController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_receipt_product/list-peak_receipt_product-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PeakReceiptProductController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_receipt_product/add-peak_receipt_product-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PeakReceiptProductController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_receipt_product/view-peak_receipt_product-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PeakReceiptProductController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_receipt_product/edit-peak_receipt_product-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PeakReceiptProductController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_receipt_product/delete-peak_receipt_product-delete-2'); // delete
        }
    );

    // peak_req_log
    $app->map(["GET","POST","OPTIONS"], '/peakreqloglist[/{id}]', PeakReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('peakreqloglist-peak_req_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakreqlogadd[/{id}]', PeakReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('peakreqlogadd-peak_req_log-add'); // add
    $app->map(["GET","OPTIONS"], '/peakreqlogview[/{id}]', PeakReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('peakreqlogview-peak_req_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakreqlogedit[/{id}]', PeakReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakreqlogedit-peak_req_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakreqlogdelete[/{id}]', PeakReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakreqlogdelete-peak_req_log-delete'); // delete
    $app->group(
        '/peak_req_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', PeakReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_req_log/list-peak_req_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', PeakReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_req_log/add-peak_req_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', PeakReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_req_log/view-peak_req_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', PeakReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_req_log/edit-peak_req_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', PeakReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_req_log/delete-peak_req_log-delete-2'); // delete
        }
    );

    // assetReport
    $app->map(["GET","POST","OPTIONS"], '/assetreportlist', AssetReportController::class . ':list')->add(PermissionMiddleware::class)->setName('assetreportlist-assetReport-list'); // list
    $app->group(
        '/assetreport',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', AssetReportController::class . ':list')->add(PermissionMiddleware::class)->setName('assetreport/list-assetReport-list-2'); // list
        }
    );

    // assetStockReport
    $app->map(["GET","POST","OPTIONS"], '/assetstockreportlist', AssetStockReportController::class . ':list')->add(PermissionMiddleware::class)->setName('assetstockreportlist-assetStockReport-list'); // list
    $app->group(
        '/assetstockreport',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', AssetStockReportController::class . ':list')->add(PermissionMiddleware::class)->setName('assetstockreport/list-assetStockReport-list-2'); // list
        }
    );

    // monthlyPayment
    $app->map(["GET", "POST", "OPTIONS"], '/monthlypayment/monthlypayment[/{params:.*}]', MonthlyPaymentController::class)->add(PermissionMiddleware::class)->setName('monthlypayment/monthlypayment-monthlyPayment-custom'); // custom

    // number_deals_available
    $app->map(["GET","POST","OPTIONS"], '/numberdealsavailablelist', NumberDealsAvailableController::class . ':list')->add(PermissionMiddleware::class)->setName('numberdealsavailablelist-number_deals_available-list'); // list
    $app->group(
        '/number_deals_available',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', NumberDealsAvailableController::class . ':list')->add(PermissionMiddleware::class)->setName('number_deals_available/list-number_deals_available-list-2'); // list
        }
    );

    // number_of_accrued
    $app->map(["GET","POST","OPTIONS"], '/numberofaccruedlist', NumberOfAccruedController::class . ':list')->add(PermissionMiddleware::class)->setName('numberofaccruedlist-number_of_accrued-list'); // list
    $app->group(
        '/number_of_accrued',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', NumberOfAccruedController::class . ':list')->add(PermissionMiddleware::class)->setName('number_of_accrued/list-number_of_accrued-list-2'); // list
        }
    );

    // number_of_unpaid_units
    $app->map(["GET","POST","OPTIONS"], '/numberofunpaidunitslist', NumberOfUnpaidUnitsController::class . ':list')->add(PermissionMiddleware::class)->setName('numberofunpaidunitslist-number_of_unpaid_units-list'); // list
    $app->group(
        '/number_of_unpaid_units',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', NumberOfUnpaidUnitsController::class . ':list')->add(PermissionMiddleware::class)->setName('number_of_unpaid_units/list-number_of_unpaid_units-list-2'); // list
        }
    );

    // outstanding_amount
    $app->map(["GET","POST","OPTIONS"], '/outstandingamountlist', OutstandingAmountController::class . ':list')->add(PermissionMiddleware::class)->setName('outstandingamountlist-outstanding_amount-list'); // list
    $app->group(
        '/outstanding_amount',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', OutstandingAmountController::class . ':list')->add(PermissionMiddleware::class)->setName('outstanding_amount/list-outstanding_amount-list-2'); // list
        }
    );

    // log_2c2p
    $app->map(["GET","POST","OPTIONS"], '/log2c2plist[/{log_2c2p_id}]', Log2c2pController::class . ':list')->add(PermissionMiddleware::class)->setName('log2c2plist-log_2c2p-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/log2c2padd[/{log_2c2p_id}]', Log2c2pController::class . ':add')->add(PermissionMiddleware::class)->setName('log2c2padd-log_2c2p-add'); // add
    $app->map(["GET","OPTIONS"], '/log2c2pview[/{log_2c2p_id}]', Log2c2pController::class . ':view')->add(PermissionMiddleware::class)->setName('log2c2pview-log_2c2p-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/log2c2pedit[/{log_2c2p_id}]', Log2c2pController::class . ':edit')->add(PermissionMiddleware::class)->setName('log2c2pedit-log_2c2p-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/log2c2pdelete[/{log_2c2p_id}]', Log2c2pController::class . ':delete')->add(PermissionMiddleware::class)->setName('log2c2pdelete-log_2c2p-delete'); // delete
    $app->group(
        '/log_2c2p',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{log_2c2p_id}]', Log2c2pController::class . ':list')->add(PermissionMiddleware::class)->setName('log_2c2p/list-log_2c2p-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{log_2c2p_id}]', Log2c2pController::class . ':add')->add(PermissionMiddleware::class)->setName('log_2c2p/add-log_2c2p-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{log_2c2p_id}]', Log2c2pController::class . ':view')->add(PermissionMiddleware::class)->setName('log_2c2p/view-log_2c2p-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{log_2c2p_id}]', Log2c2pController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_2c2p/edit-log_2c2p-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{log_2c2p_id}]', Log2c2pController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_2c2p/delete-log_2c2p-delete-2'); // delete
        }
    );

    // log_test_payment
    $app->map(["GET","POST","OPTIONS"], '/logtestpaymentlist[/{log_test_payment_id}]', LogTestPaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('logtestpaymentlist-log_test_payment-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/logtestpaymentadd[/{log_test_payment_id}]', LogTestPaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('logtestpaymentadd-log_test_payment-add'); // add
    $app->map(["GET","OPTIONS"], '/logtestpaymentview[/{log_test_payment_id}]', LogTestPaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('logtestpaymentview-log_test_payment-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/logtestpaymentedit[/{log_test_payment_id}]', LogTestPaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('logtestpaymentedit-log_test_payment-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/logtestpaymentdelete[/{log_test_payment_id}]', LogTestPaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('logtestpaymentdelete-log_test_payment-delete'); // delete
    $app->group(
        '/log_test_payment',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{log_test_payment_id}]', LogTestPaymentController::class . ':list')->add(PermissionMiddleware::class)->setName('log_test_payment/list-log_test_payment-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{log_test_payment_id}]', LogTestPaymentController::class . ':add')->add(PermissionMiddleware::class)->setName('log_test_payment/add-log_test_payment-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{log_test_payment_id}]', LogTestPaymentController::class . ':view')->add(PermissionMiddleware::class)->setName('log_test_payment/view-log_test_payment-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{log_test_payment_id}]', LogTestPaymentController::class . ':edit')->add(PermissionMiddleware::class)->setName('log_test_payment/edit-log_test_payment-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{log_test_payment_id}]', LogTestPaymentController::class . ':delete')->add(PermissionMiddleware::class)->setName('log_test_payment/delete-log_test_payment-delete-2'); // delete
        }
    );

    // log_cronjob
    $app->map(["GET","POST","OPTIONS"], '/logcronjoblist', LogCronjobController::class . ':list')->add(PermissionMiddleware::class)->setName('logcronjoblist-log_cronjob-list'); // list
    $app->group(
        '/log_cronjob',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '', LogCronjobController::class . ':list')->add(PermissionMiddleware::class)->setName('log_cronjob/list-log_cronjob-list-2'); // list
        }
    );

    // peak_expense
    $app->map(["GET","POST","OPTIONS"], '/peakexpenselist[/{peak_expense_id}]', PeakExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('peakexpenselist-peak_expense-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseadd[/{peak_expense_id}]', PeakExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('peakexpenseadd-peak_expense-add'); // add
    $app->map(["GET","OPTIONS"], '/peakexpenseview[/{peak_expense_id}]', PeakExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('peakexpenseview-peak_expense-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseedit[/{peak_expense_id}]', PeakExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakexpenseedit-peak_expense-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakexpensedelete[/{peak_expense_id}]', PeakExpenseController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakexpensedelete-peak_expense-delete'); // delete
    $app->group(
        '/peak_expense',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{peak_expense_id}]', PeakExpenseController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_expense/list-peak_expense-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{peak_expense_id}]', PeakExpenseController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_expense/add-peak_expense-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{peak_expense_id}]', PeakExpenseController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_expense/view-peak_expense-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{peak_expense_id}]', PeakExpenseController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_expense/edit-peak_expense-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{peak_expense_id}]', PeakExpenseController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_expense/delete-peak_expense-delete-2'); // delete
        }
    );

    // peak_expense_item
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseitemlist[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':list')->add(PermissionMiddleware::class)->setName('peakexpenseitemlist-peak_expense_item-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseitemadd[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':add')->add(PermissionMiddleware::class)->setName('peakexpenseitemadd-peak_expense_item-add'); // add
    $app->map(["GET","OPTIONS"], '/peakexpenseitemview[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':view')->add(PermissionMiddleware::class)->setName('peakexpenseitemview-peak_expense_item-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseitemedit[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':edit')->add(PermissionMiddleware::class)->setName('peakexpenseitemedit-peak_expense_item-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/peakexpenseitemdelete[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':delete')->add(PermissionMiddleware::class)->setName('peakexpenseitemdelete-peak_expense_item-delete'); // delete
    $app->group(
        '/peak_expense_item',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':list')->add(PermissionMiddleware::class)->setName('peak_expense_item/list-peak_expense_item-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':add')->add(PermissionMiddleware::class)->setName('peak_expense_item/add-peak_expense_item-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':view')->add(PermissionMiddleware::class)->setName('peak_expense_item/view-peak_expense_item-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':edit')->add(PermissionMiddleware::class)->setName('peak_expense_item/edit-peak_expense_item-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{peak_expense_item_id}]', PeakExpenseItemController::class . ':delete')->add(PermissionMiddleware::class)->setName('peak_expense_item/delete-peak_expense_item-delete-2'); // delete
        }
    );

    // cancelTheLease
    $app->map(["GET", "POST", "OPTIONS"], '/cancelthelease/cancelthelease[/{params:.*}]', CancelTheLeaseController::class)->add(PermissionMiddleware::class)->setName('cancelthelease/cancelthelease-cancelTheLease-custom'); // custom

    // scb_req_log
    $app->map(["GET","POST","OPTIONS"], '/scbreqloglist[/{id}]', ScbReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('scbreqloglist-scb_req_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/scbreqlogadd[/{id}]', ScbReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('scbreqlogadd-scb_req_log-add'); // add
    $app->map(["GET","OPTIONS"], '/scbreqlogview[/{id}]', ScbReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('scbreqlogview-scb_req_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/scbreqlogedit[/{id}]', ScbReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('scbreqlogedit-scb_req_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/scbreqlogdelete[/{id}]', ScbReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('scbreqlogdelete-scb_req_log-delete'); // delete
    $app->group(
        '/scb_req_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', ScbReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('scb_req_log/list-scb_req_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', ScbReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('scb_req_log/add-scb_req_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', ScbReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('scb_req_log/view-scb_req_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', ScbReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('scb_req_log/edit-scb_req_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', ScbReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('scb_req_log/delete-scb_req_log-delete-2'); // delete
        }
    );

    // creden_log
    $app->map(["GET","POST","OPTIONS"], '/credenloglist[/{id}]', CredenLogController::class . ':list')->add(PermissionMiddleware::class)->setName('credenloglist-creden_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/credenlogadd[/{id}]', CredenLogController::class . ':add')->add(PermissionMiddleware::class)->setName('credenlogadd-creden_log-add'); // add
    $app->map(["GET","OPTIONS"], '/credenlogview[/{id}]', CredenLogController::class . ':view')->add(PermissionMiddleware::class)->setName('credenlogview-creden_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/credenlogedit[/{id}]', CredenLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('credenlogedit-creden_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/credenlogdelete[/{id}]', CredenLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('credenlogdelete-creden_log-delete'); // delete
    $app->group(
        '/creden_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', CredenLogController::class . ':list')->add(PermissionMiddleware::class)->setName('creden_log/list-creden_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', CredenLogController::class . ':add')->add(PermissionMiddleware::class)->setName('creden_log/add-creden_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', CredenLogController::class . ':view')->add(PermissionMiddleware::class)->setName('creden_log/view-creden_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', CredenLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('creden_log/edit-creden_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', CredenLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('creden_log/delete-creden_log-delete-2'); // delete
        }
    );

    // doc_creden
    $app->map(["GET","POST","OPTIONS"], '/doccredenlist[/{doc_creden_id}]', DocCredenController::class . ':list')->add(PermissionMiddleware::class)->setName('doccredenlist-doc_creden-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/doccredenadd[/{doc_creden_id}]', DocCredenController::class . ':add')->add(PermissionMiddleware::class)->setName('doccredenadd-doc_creden-add'); // add
    $app->map(["GET","OPTIONS"], '/doccredenview[/{doc_creden_id}]', DocCredenController::class . ':view')->add(PermissionMiddleware::class)->setName('doccredenview-doc_creden-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/doccredenedit[/{doc_creden_id}]', DocCredenController::class . ':edit')->add(PermissionMiddleware::class)->setName('doccredenedit-doc_creden-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/doccredendelete[/{doc_creden_id}]', DocCredenController::class . ':delete')->add(PermissionMiddleware::class)->setName('doccredendelete-doc_creden-delete'); // delete
    $app->group(
        '/doc_creden',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{doc_creden_id}]', DocCredenController::class . ':list')->add(PermissionMiddleware::class)->setName('doc_creden/list-doc_creden-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{doc_creden_id}]', DocCredenController::class . ':add')->add(PermissionMiddleware::class)->setName('doc_creden/add-doc_creden-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{doc_creden_id}]', DocCredenController::class . ':view')->add(PermissionMiddleware::class)->setName('doc_creden/view-doc_creden-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{doc_creden_id}]', DocCredenController::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_creden/edit-doc_creden-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{doc_creden_id}]', DocCredenController::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_creden/delete-doc_creden-delete-2'); // delete
        }
    );

    // doc_creden_log
    $app->map(["GET","POST","OPTIONS"], '/doccredenloglist[/{id}]', DocCredenLogController::class . ':list')->add(PermissionMiddleware::class)->setName('doccredenloglist-doc_creden_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/doccredenlogadd[/{id}]', DocCredenLogController::class . ':add')->add(PermissionMiddleware::class)->setName('doccredenlogadd-doc_creden_log-add'); // add
    $app->map(["GET","OPTIONS"], '/doccredenlogview[/{id}]', DocCredenLogController::class . ':view')->add(PermissionMiddleware::class)->setName('doccredenlogview-doc_creden_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/doccredenlogedit[/{id}]', DocCredenLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('doccredenlogedit-doc_creden_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/doccredenlogdelete[/{id}]', DocCredenLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('doccredenlogdelete-doc_creden_log-delete'); // delete
    $app->group(
        '/doc_creden_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', DocCredenLogController::class . ':list')->add(PermissionMiddleware::class)->setName('doc_creden_log/list-doc_creden_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', DocCredenLogController::class . ':add')->add(PermissionMiddleware::class)->setName('doc_creden_log/add-doc_creden_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', DocCredenLogController::class . ':view')->add(PermissionMiddleware::class)->setName('doc_creden_log/view-doc_creden_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', DocCredenLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_creden_log/edit-doc_creden_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', DocCredenLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_creden_log/delete-doc_creden_log-delete-2'); // delete
        }
    );

    // doc_creden_running
    $app->map(["GET","POST","OPTIONS"], '/doccredenrunninglist[/{keys:.*}]', DocCredenRunningController::class . ':list')->add(PermissionMiddleware::class)->setName('doccredenrunninglist-doc_creden_running-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/doccredenrunningadd[/{keys:.*}]', DocCredenRunningController::class . ':add')->add(PermissionMiddleware::class)->setName('doccredenrunningadd-doc_creden_running-add'); // add
    $app->map(["GET","OPTIONS"], '/doccredenrunningview[/{keys:.*}]', DocCredenRunningController::class . ':view')->add(PermissionMiddleware::class)->setName('doccredenrunningview-doc_creden_running-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/doccredenrunningedit[/{keys:.*}]', DocCredenRunningController::class . ':edit')->add(PermissionMiddleware::class)->setName('doccredenrunningedit-doc_creden_running-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/doccredenrunningdelete[/{keys:.*}]', DocCredenRunningController::class . ':delete')->add(PermissionMiddleware::class)->setName('doccredenrunningdelete-doc_creden_running-delete'); // delete
    $app->group(
        '/doc_creden_running',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', DocCredenRunningController::class . ':list')->add(PermissionMiddleware::class)->setName('doc_creden_running/list-doc_creden_running-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{keys:.*}]', DocCredenRunningController::class . ':add')->add(PermissionMiddleware::class)->setName('doc_creden_running/add-doc_creden_running-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{keys:.*}]', DocCredenRunningController::class . ':view')->add(PermissionMiddleware::class)->setName('doc_creden_running/view-doc_creden_running-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{keys:.*}]', DocCredenRunningController::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_creden_running/edit-doc_creden_running-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{keys:.*}]', DocCredenRunningController::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_creden_running/delete-doc_creden_running-delete-2'); // delete
        }
    );

    // doc_creden_signer
    $app->map(["GET","POST","OPTIONS"], '/doccredensignerlist[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':list')->add(PermissionMiddleware::class)->setName('doccredensignerlist-doc_creden_signer-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/doccredensigneradd[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':add')->add(PermissionMiddleware::class)->setName('doccredensigneradd-doc_creden_signer-add'); // add
    $app->map(["GET","OPTIONS"], '/doccredensignerview[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':view')->add(PermissionMiddleware::class)->setName('doccredensignerview-doc_creden_signer-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/doccredensigneredit[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':edit')->add(PermissionMiddleware::class)->setName('doccredensigneredit-doc_creden_signer-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/doccredensignerdelete[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':delete')->add(PermissionMiddleware::class)->setName('doccredensignerdelete-doc_creden_signer-delete'); // delete
    $app->group(
        '/doc_creden_signer',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':list')->add(PermissionMiddleware::class)->setName('doc_creden_signer/list-doc_creden_signer-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':add')->add(PermissionMiddleware::class)->setName('doc_creden_signer/add-doc_creden_signer-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':view')->add(PermissionMiddleware::class)->setName('doc_creden_signer/view-doc_creden_signer-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_creden_signer/edit-doc_creden_signer-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{doc_creden_signer_id}]', DocCredenSignerController::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_creden_signer/delete-doc_creden_signer-delete-2'); // delete
        }
    );

    // doc_juzmatch1
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch1list[/{id}]', DocJuzmatch1Controller::class . ':list')->add(PermissionMiddleware::class)->setName('docjuzmatch1list-doc_juzmatch1-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch1add[/{id}]', DocJuzmatch1Controller::class . ':add')->add(PermissionMiddleware::class)->setName('docjuzmatch1add-doc_juzmatch1-add'); // add
    $app->map(["GET","OPTIONS"], '/docjuzmatch1view[/{id}]', DocJuzmatch1Controller::class . ':view')->add(PermissionMiddleware::class)->setName('docjuzmatch1view-doc_juzmatch1-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch1edit[/{id}]', DocJuzmatch1Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('docjuzmatch1edit-doc_juzmatch1-edit'); // edit
    $app->map(["GET","OPTIONS"], '/docjuzmatch1preview', DocJuzmatch1Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('docjuzmatch1preview-doc_juzmatch1-preview'); // preview
    $app->group(
        '/doc_juzmatch1',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', DocJuzmatch1Controller::class . ':list')->add(PermissionMiddleware::class)->setName('doc_juzmatch1/list-doc_juzmatch1-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', DocJuzmatch1Controller::class . ':add')->add(PermissionMiddleware::class)->setName('doc_juzmatch1/add-doc_juzmatch1-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', DocJuzmatch1Controller::class . ':view')->add(PermissionMiddleware::class)->setName('doc_juzmatch1/view-doc_juzmatch1-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', DocJuzmatch1Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_juzmatch1/edit-doc_juzmatch1-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', DocJuzmatch1Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('doc_juzmatch1/preview-doc_juzmatch1-preview-2'); // preview
        }
    );

    // doc_juzmatch2
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch2list[/{id}]', DocJuzmatch2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('docjuzmatch2list-doc_juzmatch2-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch2add[/{id}]', DocJuzmatch2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('docjuzmatch2add-doc_juzmatch2-add'); // add
    $app->map(["GET","OPTIONS"], '/docjuzmatch2view[/{id}]', DocJuzmatch2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('docjuzmatch2view-doc_juzmatch2-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch2edit[/{id}]', DocJuzmatch2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('docjuzmatch2edit-doc_juzmatch2-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch2delete[/{id}]', DocJuzmatch2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('docjuzmatch2delete-doc_juzmatch2-delete'); // delete
    $app->map(["GET","OPTIONS"], '/docjuzmatch2preview', DocJuzmatch2Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('docjuzmatch2preview-doc_juzmatch2-preview'); // preview
    $app->group(
        '/doc_juzmatch2',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', DocJuzmatch2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/list-doc_juzmatch2-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', DocJuzmatch2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/add-doc_juzmatch2-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', DocJuzmatch2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/view-doc_juzmatch2-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', DocJuzmatch2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/edit-doc_juzmatch2-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', DocJuzmatch2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/delete-doc_juzmatch2-delete-2'); // delete
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', DocJuzmatch2Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('doc_juzmatch2/preview-doc_juzmatch2-preview-2'); // preview
        }
    );

    // doc_juzmatch3
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch3list[/{id}]', DocJuzmatch3Controller::class . ':list')->add(PermissionMiddleware::class)->setName('docjuzmatch3list-doc_juzmatch3-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch3add[/{id}]', DocJuzmatch3Controller::class . ':add')->add(PermissionMiddleware::class)->setName('docjuzmatch3add-doc_juzmatch3-add'); // add
    $app->map(["GET","OPTIONS"], '/docjuzmatch3view[/{id}]', DocJuzmatch3Controller::class . ':view')->add(PermissionMiddleware::class)->setName('docjuzmatch3view-doc_juzmatch3-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/docjuzmatch3edit[/{id}]', DocJuzmatch3Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('docjuzmatch3edit-doc_juzmatch3-edit'); // edit
    $app->map(["GET","OPTIONS"], '/docjuzmatch3preview', DocJuzmatch3Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('docjuzmatch3preview-doc_juzmatch3-preview'); // preview
    $app->group(
        '/doc_juzmatch3',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', DocJuzmatch3Controller::class . ':list')->add(PermissionMiddleware::class)->setName('doc_juzmatch3/list-doc_juzmatch3-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', DocJuzmatch3Controller::class . ':add')->add(PermissionMiddleware::class)->setName('doc_juzmatch3/add-doc_juzmatch3-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', DocJuzmatch3Controller::class . ':view')->add(PermissionMiddleware::class)->setName('doc_juzmatch3/view-doc_juzmatch3-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', DocJuzmatch3Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_juzmatch3/edit-doc_juzmatch3-edit-2'); // edit
            $group->map(["GET","OPTIONS"], '/' . Config("PREVIEW_ACTION") . '', DocJuzmatch3Controller::class . ':preview')->add(PermissionMiddleware::class)->setName('doc_juzmatch3/preview-doc_juzmatch3-preview-2'); // preview
        }
    );

    // doc_temp
    $app->map(["GET","POST","OPTIONS"], '/doctemplist[/{doc_temp_id}]', DocTempController::class . ':list')->add(PermissionMiddleware::class)->setName('doctemplist-doc_temp-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/doctempadd[/{doc_temp_id}]', DocTempController::class . ':add')->add(PermissionMiddleware::class)->setName('doctempadd-doc_temp-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/doctempedit[/{doc_temp_id}]', DocTempController::class . ':edit')->add(PermissionMiddleware::class)->setName('doctempedit-doc_temp-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/doctempdelete[/{doc_temp_id}]', DocTempController::class . ':delete')->add(PermissionMiddleware::class)->setName('doctempdelete-doc_temp-delete'); // delete
    $app->group(
        '/doc_temp',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{doc_temp_id}]', DocTempController::class . ':list')->add(PermissionMiddleware::class)->setName('doc_temp/list-doc_temp-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{doc_temp_id}]', DocTempController::class . ':add')->add(PermissionMiddleware::class)->setName('doc_temp/add-doc_temp-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{doc_temp_id}]', DocTempController::class . ':edit')->add(PermissionMiddleware::class)->setName('doc_temp/edit-doc_temp-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{doc_temp_id}]', DocTempController::class . ':delete')->add(PermissionMiddleware::class)->setName('doc_temp/delete-doc_temp-delete-2'); // delete
        }
    );

    // mpay_req_log
    $app->map(["GET","POST","OPTIONS"], '/mpayreqloglist[/{id}]', MpayReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('mpayreqloglist-mpay_req_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/mpayreqlogadd[/{id}]', MpayReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('mpayreqlogadd-mpay_req_log-add'); // add
    $app->map(["GET","OPTIONS"], '/mpayreqlogview[/{id}]', MpayReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('mpayreqlogview-mpay_req_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/mpayreqlogedit[/{id}]', MpayReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('mpayreqlogedit-mpay_req_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/mpayreqlogdelete[/{id}]', MpayReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('mpayreqlogdelete-mpay_req_log-delete'); // delete
    $app->group(
        '/mpay_req_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', MpayReqLogController::class . ':list')->add(PermissionMiddleware::class)->setName('mpay_req_log/list-mpay_req_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', MpayReqLogController::class . ':add')->add(PermissionMiddleware::class)->setName('mpay_req_log/add-mpay_req_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', MpayReqLogController::class . ':view')->add(PermissionMiddleware::class)->setName('mpay_req_log/view-mpay_req_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', MpayReqLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('mpay_req_log/edit-mpay_req_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', MpayReqLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('mpay_req_log/delete-mpay_req_log-delete-2'); // delete
        }
    );

    // reason_terminate_contract
    $app->map(["GET","POST","OPTIONS"], '/reasonterminatecontractlist[/{reason_id}]', ReasonTerminateContractController::class . ':list')->add(PermissionMiddleware::class)->setName('reasonterminatecontractlist-reason_terminate_contract-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/reasonterminatecontractadd[/{reason_id}]', ReasonTerminateContractController::class . ':add')->add(PermissionMiddleware::class)->setName('reasonterminatecontractadd-reason_terminate_contract-add'); // add
    $app->map(["GET","OPTIONS"], '/reasonterminatecontractview[/{reason_id}]', ReasonTerminateContractController::class . ':view')->add(PermissionMiddleware::class)->setName('reasonterminatecontractview-reason_terminate_contract-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/reasonterminatecontractedit[/{reason_id}]', ReasonTerminateContractController::class . ':edit')->add(PermissionMiddleware::class)->setName('reasonterminatecontractedit-reason_terminate_contract-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/reasonterminatecontractdelete[/{reason_id}]', ReasonTerminateContractController::class . ':delete')->add(PermissionMiddleware::class)->setName('reasonterminatecontractdelete-reason_terminate_contract-delete'); // delete
    $app->group(
        '/reason_terminate_contract',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{reason_id}]', ReasonTerminateContractController::class . ':list')->add(PermissionMiddleware::class)->setName('reason_terminate_contract/list-reason_terminate_contract-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{reason_id}]', ReasonTerminateContractController::class . ':add')->add(PermissionMiddleware::class)->setName('reason_terminate_contract/add-reason_terminate_contract-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{reason_id}]', ReasonTerminateContractController::class . ':view')->add(PermissionMiddleware::class)->setName('reason_terminate_contract/view-reason_terminate_contract-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{reason_id}]', ReasonTerminateContractController::class . ':edit')->add(PermissionMiddleware::class)->setName('reason_terminate_contract/edit-reason_terminate_contract-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{reason_id}]', ReasonTerminateContractController::class . ':delete')->add(PermissionMiddleware::class)->setName('reason_terminate_contract/delete-reason_terminate_contract-delete-2'); // delete
        }
    );

    // error
    $app->map(["GET","POST","OPTIONS"], '/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // privacy
    $app->map(["GET","POST","OPTIONS"], '/privacy', OthersController::class . ':privacy')->add(PermissionMiddleware::class)->setName('privacy');

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->map(["GET","POST","OPTIONS"], '/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->map(["GET","POST","OPTIONS"], '/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
