<?php

namespace PHPMaker2022\juzmatch;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "address" => \DI\create(Address::class),
    "amphur" => \DI\create(Amphur::class),
    "appointment" => \DI\create(Appointment::class),
    "article" => \DI\create(Article::class),
    "article_banner" => \DI\create(ArticleBanner::class),
    "article_category" => \DI\create(ArticleCategory::class),
    "asset" => \DI\create(Asset::class),
    "asset_attribute" => \DI\create(AssetAttribute::class),
    "asset_banner" => \DI\create(AssetBanner::class),
    "asset_category" => \DI\create(AssetCategory::class),
    "asset_config_schedule" => \DI\create(AssetConfigSchedule::class),
    "asset_facilities" => \DI\create(AssetFacilities::class),
    "asset_favorite" => \DI\create(AssetFavorite::class),
    "asset_interested" => \DI\create(AssetInterested::class),
    "asset_pros" => \DI\create(AssetPros::class),
    "asset_pros_detail" => \DI\create(AssetProsDetail::class),
    "asset_schedule" => \DI\create(AssetSchedule::class),
    "asset_view2" => \DI\create(AssetView2::class),
    "asset_warning" => \DI\create(AssetWarning::class),
    "audittrail" => \DI\create(Audittrail::class),
    "brand" => \DI\create(Brand::class),
    "buy_save_location_search" => \DI\create(BuySaveLocationSearch::class),
    "buyer_asset_ready_buy" => \DI\create(BuyerAssetReadyBuy::class),
    "buyer_asset_rent" => \DI\create(BuyerAssetRent::class),
    "buyer_asset_schedule" => \DI\create(BuyerAssetSchedule::class),
    "buyer" => \DI\create(Buyer::class),
    "buyer_asset" => \DI\create(BuyerAsset::class),
    "buyer_booking_asset" => \DI\create(BuyerBookingAsset::class),
    "buyer_config_asset_schedule" => \DI\create(BuyerConfigAssetSchedule::class),
    "buyer_save_buy_asset" => \DI\create(BuyerSaveBuyAsset::class),
    "buyer_verify" => \DI\create(BuyerVerify::class),
    "category" => \DI\create(Category::class),
    "districts" => \DI\create(Districts::class),
    "home_popup" => \DI\create(HomePopup::class),
    "invertor_asset_schedule" => \DI\create(InvertorAssetSchedule::class),
    "invertor_booking" => \DI\create(InvertorBooking::class),
    "juzcalculator" => \DI\create(Juzcalculator::class),
    "juzcalculator_income" => \DI\create(JuzcalculatorIncome::class),
    "juzcalculator_outcome" => \DI\create(JuzcalculatorOutcome::class),
    "master_buyer_calculator" => \DI\create(MasterBuyerCalculator::class),
    "master_config" => \DI\create(MasterConfig::class),
    "investor" => \DI\create(Investor::class),
    "master_facilities" => \DI\create(MasterFacilities::class),
    "master_facilities_group" => \DI\create(MasterFacilitiesGroup::class),
    "master_invertor_calculator" => \DI\create(MasterInvertorCalculator::class),
    "member" => \DI\create(Member::class),
    "notification" => \DI\create(Notification::class),
    "payment_inverter_booking" => \DI\create(PaymentInverterBooking::class),
    "plan_loan" => \DI\create(PlanLoan::class),
    "province" => \DI\create(Province::class),
    "sale_asset" => \DI\create(SaleAsset::class),
    "save_interest" => \DI\create(SaveInterest::class),
    "save_log_search_nonmember" => \DI\create(SaveLogSearchNonmember::class),
    "save_search" => \DI\create(SaveSearch::class),
    "seller_verify" => \DI\create(SellerVerify::class),
    "setting_lang" => \DI\create(SettingLang::class),
    "subdistrict" => \DI\create(Subdistrict::class),
    "subscriptions" => \DI\create(Subscriptions::class),
    "todo_list" => \DI\create(TodoList::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "users" => \DI\create(Users::class),
    "attribute" => \DI\create(Attribute::class),
    "attribute_category" => \DI\create(AttributeCategory::class),
    "attribute_detail" => \DI\create(AttributeDetail::class),
    "check_login" => \DI\create(CheckLogin::class),
    "error_log" => \DI\create(ErrorLog::class),
    "log_buyer_asset_ready_buy" => \DI\create(LogBuyerAssetReadyBuy::class),
    "log_buyer_asset_rent" => \DI\create(LogBuyerAssetRent::class),
    "log_buyer_asset_schedule" => \DI\create(LogBuyerAssetSchedule::class),
    "log_buyer_booking_asset" => \DI\create(LogBuyerBookingAsset::class),
    "log_login" => \DI\create(LogLogin::class),
    "log_member" => \DI\create(LogMember::class),
    "log_payment_inverter_booking" => \DI\create(LogPaymentInverterBooking::class),
    "log_search" => \DI\create(LogSearch::class),
    "log_view_article" => \DI\create(LogViewArticle::class),
    "log_visit_asset" => \DI\create(LogVisitAsset::class),
    "master_asset_icon_pros" => \DI\create(MasterAssetIconPros::class),
    "master_asset_interested" => \DI\create(MasterAssetInterested::class),
    "master_calculator" => \DI\create(MasterCalculator::class),
    "pipedrive_req_log" => \DI\create(PipedriveReqLog::class),
    "seller" => \DI\create(Seller::class),
    "seller_appointment" => \DI\create(SellerAppointment::class),
    "member_otp" => \DI\create(MemberOtp::class),
    "member_scb" => \DI\create(MemberScb::class),
    "member_scb_detail" => \DI\create(MemberScbDetail::class),
    "run_number_asset_buyer" => \DI\create(RunNumberAssetBuyer::class),
    "run_number_asset_juzmatch" => \DI\create(RunNumberAssetJuzmatch::class),
    "run_number_asset_seller" => \DI\create(RunNumberAssetSeller::class),
    "run_number_member" => \DI\create(RunNumberMember::class),
    "save_webhook" => \DI\create(SaveWebhook::class),
    "inverter_asset" => \DI\create(InverterAsset::class),
    "web_config" => \DI\create(WebConfig::class),
    "investor_verify" => \DI\create(InvestorVerify::class),
    "dashboard2" => \DI\create(Dashboard2::class),
    "investorReceiveMonthly" => \DI\create(InvestorReceiveMonthly::class),
    "buyerPaymentMonthly" => \DI\create(BuyerPaymentMonthly::class),
    "buyer_all_booking_asset" => \DI\create(BuyerAllBookingAsset::class),
    "invertor_all_booking" => \DI\create(InvertorAllBooking::class),
    "buyer_all_asset_rent" => \DI\create(BuyerAllAssetRent::class),
    "log_notification" => \DI\create(LogNotification::class),
    "log_send_email" => \DI\create(LogSendEmail::class),
    "all_asset_config_schedule" => \DI\create(AllAssetConfigSchedule::class),
    "all_asset_schedule" => \DI\create(AllAssetSchedule::class),
    "all_buyer_config_asset_schedule" => \DI\create(AllBuyerConfigAssetSchedule::class),
    "all_buyer_asset_schedule" => \DI\create(AllBuyerAssetSchedule::class),
    "asset_appointment" => \DI\create(AssetAppointment::class),
    "asset_address" => \DI\create(AssetAddress::class),
    "log_member_scb" => \DI\create(LogMemberScb::class),
    "member_scb_detail_log" => \DI\create(MemberScbDetailLog::class),
    "peak_contact" => \DI\create(PeakContact::class),
    "peak_product" => \DI\create(PeakProduct::class),
    "peak_receipt" => \DI\create(PeakReceipt::class),
    "peak_receipt_product" => \DI\create(PeakReceiptProduct::class),
    "peak_req_log" => \DI\create(PeakReqLog::class),
    "assetReport" => \DI\create(AssetReport::class),
    "assetStockReport" => \DI\create(AssetStockReport::class),
    "monthlyPayment" => \DI\create(MonthlyPayment::class),
    "number_deals_available" => \DI\create(NumberDealsAvailable::class),
    "number_of_accrued" => \DI\create(NumberOfAccrued::class),
    "number_of_unpaid_units" => \DI\create(NumberOfUnpaidUnits::class),
    "outstanding_amount" => \DI\create(OutstandingAmount::class),
    "log_2c2p" => \DI\create(Log2c2p::class),
    "log_test_payment" => \DI\create(LogTestPayment::class),
    "log_cronjob" => \DI\create(LogCronjob::class),
    "peak_expense" => \DI\create(PeakExpense::class),
    "peak_expense_item" => \DI\create(PeakExpenseItem::class),
    "cancelTheLease" => \DI\create(CancelTheLease::class),
    "scb_req_log" => \DI\create(ScbReqLog::class),
    "creden_log" => \DI\create(CredenLog::class),
    "doc_creden" => \DI\create(DocCreden::class),
    "doc_creden_log" => \DI\create(DocCredenLog::class),
    "doc_creden_running" => \DI\create(DocCredenRunning::class),
    "doc_creden_signer" => \DI\create(DocCredenSigner::class),
    "doc_juzmatch1" => \DI\create(DocJuzmatch1::class),
    "doc_juzmatch2" => \DI\create(DocJuzmatch2::class),
    "doc_juzmatch3" => \DI\create(DocJuzmatch3::class),
    "doc_temp" => \DI\create(DocTemp::class),
    "mpay_req_log" => \DI\create(MpayReqLog::class),
    "reason_terminate_contract" => \DI\create(ReasonTerminateContract::class),
    "downloadFileFromCloud" => \DI\create(DownloadFileFromCloud::class),

    // User table
    "usertable" => \DI\get("users"),
];
