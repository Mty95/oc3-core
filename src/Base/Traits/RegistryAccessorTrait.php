<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Traits;

use Cache;
use Config;
use Db;
use Document;
use Encryption;
use Image;
use Language;
use Loader;
use Log;
use Mail;
use ModelAccountActivity;
use ModelAccountAddress;
use ModelAccountApi;
use ModelAccountCustomer;
use ModelAccountCustomerGroup;
use ModelAccountCustomField;
use ModelAccountDownload;
use ModelAccountOrder;
use ModelAccountRecurring;
use ModelAccountReturn;
use ModelAccountReward;
use ModelAccountSearch;
use ModelAccountTransaction;
use ModelAccountWishlist;
use ModelCatalogAttribute;
use ModelCatalogAttributeGroup;
use ModelCatalogCategory;
use ModelCatalogDownload;
use ModelCatalogFilter;
use ModelCatalogInformation;
use ModelCatalogManufacturer;
use ModelCatalogOption;
use ModelCatalogProduct;
use ModelCatalogRecurring;
use ModelCatalogReview;
use ModelCheckoutMarketing;
use ModelCheckoutOrder;
use ModelCheckoutRecurring;
use ModelCustomerCustomer;
use ModelCustomerCustomerApproval;
use ModelCustomerCustomerGroup;
use ModelCustomerCustomField;
use ModelDesignBanner;
use ModelDesignLayout;
use ModelDesignSeoUrl;
use ModelDesignTheme;
use ModelDesignTranslation;
use ModelLocalisationCountry;
use ModelLocalisationCurrency;
use ModelLocalisationGeoZone;
use ModelLocalisationLanguage;
use ModelLocalisationLengthClass;
use ModelLocalisationLocation;
use ModelLocalisationOrderStatus;
use ModelLocalisationReturnAction;
use ModelLocalisationReturnReason;
use ModelLocalisationReturnStatus;
use ModelLocalisationStockStatus;
use ModelLocalisationTaxClass;
use ModelLocalisationTaxRate;
use ModelLocalisationWeightClass;
use ModelLocalisationZone;
use ModelMarketingCoupon;
use ModelMarketingMarketing;
use ModelReportOnline;
use ModelReportStatistics;
use ModelSaleOrder;
use ModelSaleRecurring;
use ModelSaleReturn;
use ModelSaleVoucher;
use ModelSaleVoucherTheme;
use ModelSettingApi;
use ModelSettingEvent;
use ModelSettingExtension;
use ModelSettingModification;
use ModelSettingModule;
use ModelSettingSetting;
use ModelSettingStore;
use ModelToolBackup;
use ModelToolImage;
use ModelToolOnline;
use ModelToolUpload;
use ModelUserApi;
use ModelUserUser;
use ModelUserUserGroup;
use Openbay;
use Pagination;
use Registry;
use Request;
use Response;
use Session;
use Squareup;
use Template;
use Url;

/**
 * @property string $id
 * @property array $children
 * @property array $data
 * @property string $output
 * @property Loader $load
 * @property ModelAccountActivity $model_account_activity
 * @property ModelAccountAddress $model_account_address
 * @property ModelAccountApi $model_account_api
 * @property ModelAccountCustomField $model_account_custom_field
 * @property ModelAccountCustomer $model_account_customer
 * @property ModelAccountCustomerGroup $model_account_customer_group
 * @property ModelAccountDownload $model_account_download
 * @property ModelAccountOrder $model_account_order
 * @property ModelAccountRecurring $model_account_recurring
 * @property ModelAccountReturn $model_account_return
 * @property ModelAccountReward $model_account_reward
 * @property ModelAccountSearch $model_account_search
 * @property ModelAccountTransaction $model_account_transaction
 * @property ModelAccountWishlist $model_account_wishlist
 * @property ModelCatalogCategory $model_catalog_category
 * @property ModelCatalogInformation $model_catalog_information
 * @property ModelCatalogManufacturer $model_catalog_manufacturer
 * @property ModelCatalogProduct $model_catalog_product
 * @property ModelCatalogReview $model_catalog_review
 * @property ModelCheckoutMarketing $model_checkout_marketing
 * @property ModelCheckoutOrder $model_checkout_order
 * @property ModelCheckoutRecurring $model_checkout_recurring
 * @property ModelDesignBanner $model_design_banner
 * @property ModelDesignLayout $model_design_layout
 * @property ModelDesignTheme $model_design_theme
 * @property ModelDesignTranslation $model_design_translation
 * @property ModelLocalisationCountry $model_localisation_country
 * @property ModelLocalisationCurrency $model_localisation_currency
 * @property ModelLocalisationLanguage $model_localisation_language
 * @property ModelLocalisationLocation $model_localisation_location
 * @property ModelLocalisationOrderStatus $model_localisation_order_status
 * @property ModelLocalisationReturnReason $model_localisation_return_reason
 * @property ModelLocalisationZone $model_localisation_zone
 * @property ModelReportStatistics $model_report_statistics
 * @property ModelSettingApi $model_setting_api
 * @property ModelSettingEvent $model_setting_event
 * @property ModelSettingExtension $model_setting_extension
 * @property ModelSettingModule $model_setting_module
 * @property ModelSettingSetting $model_setting_setting
 * @property ModelSettingStore $model_setting_store
 * @property ModelToolImage $model_tool_image
 * @property ModelToolOnline $model_tool_online
 * @property ModelToolUpload $model_tool_upload
 * @property ModelCatalogAttribute $model_catalog_attribute
 * @property ModelCatalogAttributeGroup $model_catalog_attribute_group
 * @property ModelCatalogDownload $model_catalog_download
 * @property ModelCatalogFilter $model_catalog_filter
 * @property ModelCatalogOption $model_catalog_option
 * @property ModelCatalogRecurring $model_catalog_recurring
 * @property ModelCustomerCustomField $model_customer_custom_field
 * @property ModelCustomerCustomer $model_customer_customer
 * @property ModelCustomerCustomerApproval $model_customer_customer_approval
 * @property ModelCustomerCustomerGroup $model_customer_customer_group
 * @property ModelDesignSeoUrl $model_design_seo_url
 * @property ModelLocalisationGeoZone $model_localisation_geo_zone
 * @property ModelLocalisationLengthClass $model_localisation_length_class
 * @property ModelLocalisationReturnAction $model_localisation_return_action
 * @property ModelLocalisationReturnStatus $model_localisation_return_status
 * @property ModelLocalisationStockStatus $model_localisation_stock_status
 * @property ModelLocalisationTaxClass $model_localisation_tax_class
 * @property ModelLocalisationTaxRate $model_localisation_tax_rate
 * @property ModelLocalisationWeightClass $model_localisation_weight_class
 * @property ModelMarketingCoupon $model_marketing_coupon
 * @property ModelMarketingMarketing $model_marketing_marketing
 * @property ModelReportOnline $model_report_online
 * @property ModelSaleOrder $model_sale_order
 * @property ModelSaleRecurring $model_sale_recurring
 * @property ModelSaleReturn $model_sale_return
 * @property ModelSaleVoucher $model_sale_voucher
 * @property ModelSaleVoucherTheme $model_sale_voucher_theme
 * @property ModelSettingModification $model_setting_modification
 * @property ModelToolBackup $model_tool_backup
 * @property ModelUserApi $model_user_api
 * @property ModelUserUser $model_user_user
 * @property ModelUserUserGroup $model_user_user_group
 * @property Cache $cache
 * @property Config $config
 * @property Db $db
 * @property Document $document
 * @property Encryption $encryption
 * @property Image $image
 * @property Language $language
 * @property Log $log
 * @property Mail $mail
 * @property Openbay $openbay
 * @property Pagination $pagination
 * @property Request $request
 * @property Response $response
 * @property Session $session
 * @property Squareup $squareup
 * @property Template $template
 * @property Url $url
 *
 * Trait GetterSetterRegistryTrait
 * @package Mty95\Core\Base\Traits
 */
trait RegistryAccessorTrait
{
    public function __get($key)
    {
        return $this->registry->get($key);
    }

    public function __set($key, $value)
    {
        $this->registry->set($key, $value);
    }
}