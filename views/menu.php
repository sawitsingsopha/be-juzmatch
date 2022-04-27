<?php

namespace PHPMaker2022\juzmatch;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(87, "mci_สินทรัพย์", $MenuLanguage->MenuPhrase("87", "MenuText"), "", -1, "", true, false, true, "fas fa-home", "", false);
$sideMenu->addMenuItem(7, "mi_asset", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "assetlist?cmd=resetall", 87, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}asset'), false, false, "fas fa-home", "", false);
$sideMenu->addMenuItem(227, "mi_asset_appointment", $MenuLanguage->MenuPhrase("227", "MenuText"), $MenuRelativePath . "assetappointmentlist", 87, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}asset_appointment'), false, false, "fas fa-door-open", "", false);
$sideMenu->addMenuItem(218, "mi_buyer_all_booking_asset", $MenuLanguage->MenuPhrase("218", "MenuText"), $MenuRelativePath . "buyerallbookingassetlist", 87, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}buyer_all_booking_asset'), false, false, "fas fa-hands-helping", "", false);
$sideMenu->addMenuItem(219, "mi_invertor_all_booking", $MenuLanguage->MenuPhrase("219", "MenuText"), $MenuRelativePath . "invertorallbookinglist", 87, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}invertor_all_booking'), false, false, "fas fa-hands-helping", "", false);
$sideMenu->addMenuItem(91, "mci_Member", $MenuLanguage->MenuPhrase("91", "MenuText"), "", -1, "", true, false, true, "fas fa-user-friends", "", false);
$sideMenu->addMenuItem(58, "mi_member", $MenuLanguage->MenuPhrase("58", "MenuText"), $MenuRelativePath . "memberlist", 91, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}member'), false, false, "fas fa-users", "", false);
$sideMenu->addMenuItem(99, "mi_buyer", $MenuLanguage->MenuPhrase("99", "MenuText"), $MenuRelativePath . "buyerlist", 91, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}buyer'), false, false, "fas fa-user", "", false);
$sideMenu->addMenuItem(98, "mi_investor", $MenuLanguage->MenuPhrase("98", "MenuText"), $MenuRelativePath . "investorlist", 91, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}investor'), false, false, "fas fa-user", "", false);
$sideMenu->addMenuItem(96, "mi_seller", $MenuLanguage->MenuPhrase("96", "MenuText"), $MenuRelativePath . "sellerlist", 91, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}seller'), false, false, "fas fa-user", "", false);
$sideMenu->addMenuItem(208, "mci_Report", $MenuLanguage->MenuPhrase("208", "MenuText"), "", -1, "", true, false, true, "fas fa-file-invoice", "", false);
$sideMenu->addMenuItem(60, "mi_member_scb", $MenuLanguage->MenuPhrase("60", "MenuText"), $MenuRelativePath . "memberscblist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}member_scb'), false, false, "fas fa-file-export", "", false);
$sideMenu->addMenuItem(61, "mi_member_scb_detail", $MenuLanguage->MenuPhrase("61", "MenuText"), $MenuRelativePath . "memberscbdetaillist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}member_scb_detail'), false, false, "fas fa-file-export", "", false);
$sideMenu->addMenuItem(236, "mi_assetReport", $MenuLanguage->MenuPhrase("236", "MenuText"), $MenuRelativePath . "assetreportlist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}assetReport'), false, false, "fas fa-file-export", "", false);
$sideMenu->addMenuItem(237, "mi_assetStockReport", $MenuLanguage->MenuPhrase("237", "MenuText"), $MenuRelativePath . "assetstockreportlist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}assetStockReport'), false, false, "fas fa-file-export", "", false);
$sideMenu->addMenuItem(238, "mi_monthlyPayment", $MenuLanguage->MenuPhrase("238", "MenuText"), $MenuRelativePath . "monthlypayment/monthlypayment", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}monthlyPayment.php'), false, false, "fas fa-file-export", "", false);
$sideMenu->addMenuItem(239, "mi_number_deals_available", $MenuLanguage->MenuPhrase("239", "MenuText"), $MenuRelativePath . "numberdealsavailablelist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}number_deals_available'), false, false, "", "", false);
$sideMenu->addMenuItem(240, "mi_number_of_accrued", $MenuLanguage->MenuPhrase("240", "MenuText"), $MenuRelativePath . "numberofaccruedlist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}number_of_accrued'), false, false, "", "", false);
$sideMenu->addMenuItem(241, "mi_number_of_unpaid_units", $MenuLanguage->MenuPhrase("241", "MenuText"), $MenuRelativePath . "numberofunpaidunitslist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}number_of_unpaid_units'), false, false, "", "", false);
$sideMenu->addMenuItem(242, "mi_outstanding_amount", $MenuLanguage->MenuPhrase("242", "MenuText"), $MenuRelativePath . "outstandingamountlist", 208, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}outstanding_amount'), false, false, "", "", false);
$sideMenu->addMenuItem(86, "mci_Juz_Highlight", $MenuLanguage->MenuPhrase("86", "MenuText"), "", -1, "", true, false, true, "far fa-newspaper", "", false);
$sideMenu->addMenuItem(5, "mi_article_banner", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "articlebannerlist", 86, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}article_banner'), false, false, "far fa-image", "", false);
$sideMenu->addMenuItem(6, "mi_article_category", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "articlecategorylist", 86, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}article_category'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(4, "mi_article", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "articlelist", 86, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}article'), false, false, "far fa-newspaper", "", false);
$sideMenu->addMenuItem(83, "mci_User_Management", $MenuLanguage->MenuPhrase("83", "MenuText"), "", -1, "", true, false, true, "fas fa-user-cog", "", false);
$sideMenu->addMenuItem(81, "mi_userlevels", $MenuLanguage->MenuPhrase("81", "MenuText"), $MenuRelativePath . "userlevelslist", 83, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}userlevels'), false, false, "fas fa-users-cog", "", false);
$sideMenu->addMenuItem(79, "mi_users", $MenuLanguage->MenuPhrase("79", "MenuText"), $MenuRelativePath . "userslist", 83, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}users'), false, false, "fas fa-user-cog", "", false);
$sideMenu->addMenuItem(84, "mci_Setting", $MenuLanguage->MenuPhrase("84", "MenuText"), "", -1, "", true, false, true, "fas fa-cogs", "", false);
$sideMenu->addMenuItem(82, "mi_audittrail", $MenuLanguage->MenuPhrase("82", "MenuText"), $MenuRelativePath . "audittraillist", 84, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}audittrail'), false, false, "fas fa-history", "", false);
$sideMenu->addMenuItem(102, "mi_web_config", $MenuLanguage->MenuPhrase("102", "MenuText"), $MenuRelativePath . "webconfiglist", 84, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}web_config'), false, false, "fas fa-cog", "", false);
$sideMenu->addMenuItem(92, "mi_home_popup", $MenuLanguage->MenuPhrase("92", "MenuText"), $MenuRelativePath . "homepopuplist", 84, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}home_popup'), false, false, "far fa-images", "", false);
$sideMenu->addMenuItem(85, "mci_Master_Data", $MenuLanguage->MenuPhrase("85", "MenuText"), "", -1, "", true, false, true, "fas fa-database", "", false);
$sideMenu->addMenuItem(32, "mi_category", $MenuLanguage->MenuPhrase("32", "MenuText"), $MenuRelativePath . "categorylist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}category'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(23, "mi_brand", $MenuLanguage->MenuPhrase("23", "MenuText"), $MenuRelativePath . "brandlist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}brand'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(56, "mi_master_facilities_group", $MenuLanguage->MenuPhrase("56", "MenuText"), $MenuRelativePath . "masterfacilitiesgrouplist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}master_facilities_group'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(55, "mi_master_facilities", $MenuLanguage->MenuPhrase("55", "MenuText"), $MenuRelativePath . "masterfacilitieslist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}master_facilities'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(57, "mi_master_invertor_calculator", $MenuLanguage->MenuPhrase("57", "MenuText"), $MenuRelativePath . "masterinvertorcalculatorlist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}master_invertor_calculator'), false, false, "fas fa-list", "", false);
$sideMenu->addMenuItem(260, "mi_doc_temp", $MenuLanguage->MenuPhrase("260", "MenuText"), $MenuRelativePath . "doctemplist", 85, "", AllowListMenu('{92B999EB-369F-4874-8848-2BC343EBF36E}doc_temp'), false, false, "fas fa-list", "", false);
echo $sideMenu->toScript();
