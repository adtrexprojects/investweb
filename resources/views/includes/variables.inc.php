<?php
     //defining site-wide variables
    if ( $dir_level == 0 ){
    	$home_dir = "";
        $sidebar_dir = "../";
    }else if ( $dir_level == 1 ){
    	$home_dir = "../";
        $sidebar_dir = "../../";
    }else if ( $dir_level == 2 ){
    	$home_dir = "../../";
        $sidebar_dir = "../../../";
    }else if ( $dir_level == 3 ){
    	$home_dir = "../../../";
        $sidebar_dir = "../../../../";
    }

    //varibles to determine active sidebar menus/submenus
    $teachers_active = "";
    $teachers_overview_active = "";
    $site_content_active = "";
    $edit_content_active = "";

    $profile_active="";
    $carts_active="";
    $history_active="";
    $shopping_content_active="";
    $notify_active="";
    $change_pass="";

    $file_content_active="";
    $home_active = "";
    $templates_active = "";
    
  
	
    $dashboard_active="";
    $dashboard2_active="";
    $home_active="";
    $owner_profile_active="";
    $store_settings_active="";
    $payments_active="";
    $shipping_active="";
    $tax_active="";
    $currencies_active="";
    $point_of_sale_active="";
    $accounting_active="";
    $getting_started_active="";
	$analytics_orders_active="";
    $overview_active="";
    $add_new_order_active="";
    $export_import_active="";
    $gift_certificate_active="";
    $shipments_active="";
    $catalog_active="";
    $overview_active="";
    $add_new_product_active="";
    $export_import_active="";
    $product_category_active="";
    $product_option_active="";
    $product_filtering_active="";
    $product_reviews_active="";
    $brands_active="";
    $clients_active="";
    $orders_active="";
    $account_settings_active="";
    $overview_active  = "";
    $add_new_client_active = "";
    $export_import_active = "";
    $client_group_active = "";
    $marketting_active = "";
    $banners_active = "";
    $coupon_codes_active = "";
    $cart_level_active = "";
    $notification_active = "";
    $google_adword_active = "";
    $email_marketing_active = "";
    $gift_certificates_active = "";
    $analytics_active = "";
    $overview_active = "";
    $insights_active = "";
    $real_time_active = "";
    $merchandising_active = "";
    $marketing_active = "";
    $orders_active = "";
    $customers_active = "";
    $purchase_funnel_active = "";
    $advanced_cart_active = "";
    $abandoned_cart_recovery_active = "";
    $in_store_search_active = "";
    $channel_manager_active = "";
    $gift_wrapping_active="";
    $users_active = "";
    $users_active = "";
    $facebook_active= "";
    $pinterest_active= "";
    $buy_buttons_active= "";
    $app_active= "";
    $market_place_active= "";
    $my_apps_active= "";
    $advanced_settings_active= "";
    $web_analytics_active= "";
    $checkout_active= "";
    $inventory_active= "";
    $order_active= "";
    $order_notification_active= "";
    $returns_active= "";
    $stores_all_active= "";
    $live_chat_active= "";
    $account_signup_form_active= "";
    $affilliate_conversion_active= "";
    $server_settings_active= "";
    $domain_name_active= "";
    $redirect_active= "";
    $email_records_active= "";
    $ssl_certificates_active= "";
    $store_logs_active= "";
    $file_access_active= "";
    $account_setings_active= "";
    $users_active= "";
    $update_profile_active= "";
    $change_password_active= "";
    $account_summary_active= "";
    $invoices_active= "";
    $upgrade_account_active="";
    $account_details_active= "";
    $logout_active= "";
?>
