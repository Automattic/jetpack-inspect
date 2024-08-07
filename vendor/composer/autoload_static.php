<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2662d159b2161b86f56c5059a9d397af_inspectⓥ0_1_0_alpha
{
    public static $files = array (
        '3773ef3f09c37da5478d578e32b03a4b' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-assets/actions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Automattic\\Jetpack_Inspect\\' => 27,
            'Automattic\\Jetpack\\Packages\\' => 28,
            'Automattic\\Jetpack\\Autoloader\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Automattic\\Jetpack_Inspect\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Automattic\\Jetpack\\Packages\\' => 
        array (
            0 => __DIR__ . '/../..' . '/packages',
        ),
        'Automattic\\Jetpack\\Autoloader\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src',
        ),
    );

    public static $classMap = array (
        'Automattic\\Jetpack\\A8c_Mc_Stats' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-a8c-mc-stats/src/class-a8c-mc-stats.php',
        'Automattic\\Jetpack\\Admin_UI\\Admin_Menu' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-admin-ui/src/class-admin-menu.php',
        'Automattic\\Jetpack\\Assets' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-assets/src/class-assets.php',
        'Automattic\\Jetpack\\Assets\\Semver' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-assets/src/class-semver.php',
        'Automattic\\Jetpack\\Autoloader\\AutoloadFileWriter' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/AutoloadFileWriter.php',
        'Automattic\\Jetpack\\Autoloader\\AutoloadGenerator' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/AutoloadGenerator.php',
        'Automattic\\Jetpack\\Autoloader\\AutoloadProcessor' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/AutoloadProcessor.php',
        'Automattic\\Jetpack\\Autoloader\\CustomAutoloaderPlugin' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/CustomAutoloaderPlugin.php',
        'Automattic\\Jetpack\\Autoloader\\ManifestGenerator' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/ManifestGenerator.php',
        'Automattic\\Jetpack\\Composer\\Manager' => __DIR__ . '/..' . '/automattic/jetpack-composer-plugin/src/class-manager.php',
        'Automattic\\Jetpack\\Composer\\Plugin' => __DIR__ . '/..' . '/automattic/jetpack-composer-plugin/src/class-plugin.php',
        'Automattic\\Jetpack\\Config' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-config/src/class-config.php',
        'Automattic\\Jetpack\\Connection\\Authorize_Json_Api' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-authorize-json-api.php',
        'Automattic\\Jetpack\\Connection\\Client' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-client.php',
        'Automattic\\Jetpack\\Connection\\Connection_Notice' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-connection-notice.php',
        'Automattic\\Jetpack\\Connection\\Error_Handler' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-error-handler.php',
        'Automattic\\Jetpack\\Connection\\Initial_State' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-initial-state.php',
        'Automattic\\Jetpack\\Connection\\Manager' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-manager.php',
        'Automattic\\Jetpack\\Connection\\Manager_Interface' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/interface-manager.php',
        'Automattic\\Jetpack\\Connection\\Nonce_Handler' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-nonce-handler.php',
        'Automattic\\Jetpack\\Connection\\Package_Version' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-package-version.php',
        'Automattic\\Jetpack\\Connection\\Package_Version_Tracker' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-package-version-tracker.php',
        'Automattic\\Jetpack\\Connection\\Plugin' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-plugin.php',
        'Automattic\\Jetpack\\Connection\\Plugin_Storage' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-plugin-storage.php',
        'Automattic\\Jetpack\\Connection\\REST_Connector' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-rest-connector.php',
        'Automattic\\Jetpack\\Connection\\Rest_Authentication' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-rest-authentication.php',
        'Automattic\\Jetpack\\Connection\\SSO' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/sso/class-sso.php',
        'Automattic\\Jetpack\\Connection\\SSO\\Force_2FA' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/sso/class-force-2fa.php',
        'Automattic\\Jetpack\\Connection\\SSO\\Helpers' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/sso/class-helpers.php',
        'Automattic\\Jetpack\\Connection\\SSO\\Notices' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/sso/class-notices.php',
        'Automattic\\Jetpack\\Connection\\SSO\\User_Admin' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/sso/class-user-admin.php',
        'Automattic\\Jetpack\\Connection\\Secrets' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-secrets.php',
        'Automattic\\Jetpack\\Connection\\Server_Sandbox' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-server-sandbox.php',
        'Automattic\\Jetpack\\Connection\\Tokens' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-tokens.php',
        'Automattic\\Jetpack\\Connection\\Tokens_Locks' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-tokens-locks.php',
        'Automattic\\Jetpack\\Connection\\Urls' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-urls.php',
        'Automattic\\Jetpack\\Connection\\Utils' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-utils.php',
        'Automattic\\Jetpack\\Connection\\Webhooks' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-webhooks.php',
        'Automattic\\Jetpack\\Connection\\Webhooks\\Authorize_Redirect' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/webhooks/class-authorize-redirect.php',
        'Automattic\\Jetpack\\Connection\\XMLRPC_Async_Call' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-xmlrpc-async-call.php',
        'Automattic\\Jetpack\\Connection\\XMLRPC_Connector' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-xmlrpc-connector.php',
        'Automattic\\Jetpack\\Constants' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-constants/src/class-constants.php',
        'Automattic\\Jetpack\\CookieState' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-cookiestate.php',
        'Automattic\\Jetpack\\Errors' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-errors.php',
        'Automattic\\Jetpack\\Files' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-files.php',
        'Automattic\\Jetpack\\Heartbeat' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-heartbeat.php',
        'Automattic\\Jetpack\\IdentityCrisis\\Exception' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/identity-crisis/class-exception.php',
        'Automattic\\Jetpack\\IdentityCrisis\\REST_Endpoints' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/identity-crisis/class-rest-endpoints.php',
        'Automattic\\Jetpack\\IdentityCrisis\\UI' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/identity-crisis/class-ui.php',
        'Automattic\\Jetpack\\IdentityCrisis\\URL_Secret' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/identity-crisis/class-url-secret.php',
        'Automattic\\Jetpack\\Identity_Crisis' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/identity-crisis/class-identity-crisis.php',
        'Automattic\\Jetpack\\Modules' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-modules.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Async_Option' => __DIR__ . '/../..' . '/packages/Async_Option/Async_Option.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Async_Option_Template' => __DIR__ . '/../..' . '/packages/Async_Option/Async_Option_Template.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Async_Options' => __DIR__ . '/../..' . '/packages/Async_Option/Async_Options.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Authenticated_Nonce' => __DIR__ . '/../..' . '/packages/Async_Option/Authenticated_Nonce.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Endpoint' => __DIR__ . '/../..' . '/packages/Async_Option/Endpoint.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Registry' => __DIR__ . '/../..' . '/packages/Async_Option/Registry.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Storage\\Storage' => __DIR__ . '/../..' . '/packages/Async_Option/Storage/Storage.php',
        'Automattic\\Jetpack\\Packages\\Async_Option\\Storage\\WP_Option' => __DIR__ . '/../..' . '/packages/Async_Option/Storage/WP_Option.php',
        'Automattic\\Jetpack\\Partner' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-partner.php',
        'Automattic\\Jetpack\\Partner_Coupon' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-partner-coupon.php',
        'Automattic\\Jetpack\\Paths' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-paths.php',
        'Automattic\\Jetpack\\Redirect' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-redirect/src/class-redirect.php',
        'Automattic\\Jetpack\\Roles' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-roles/src/class-roles.php',
        'Automattic\\Jetpack\\Script_Data' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-assets/src/class-script-data.php',
        'Automattic\\Jetpack\\Status' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-status.php',
        'Automattic\\Jetpack\\Status\\Cache' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-cache.php',
        'Automattic\\Jetpack\\Status\\Host' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-host.php',
        'Automattic\\Jetpack\\Status\\Visitor' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-status/src/class-visitor.php',
        'Automattic\\Jetpack\\Terms_Of_Service' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-terms-of-service.php',
        'Automattic\\Jetpack\\Tracking' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/src/class-tracking.php',
        'Automattic\\Jetpack_Inspect\\Admin_Page' => __DIR__ . '/../..' . '/app/Admin_Page.php',
        'Automattic\\Jetpack_Inspect\\Log' => __DIR__ . '/../..' . '/app/Log.php',
        'Automattic\\Jetpack_Inspect\\Monitor' => __DIR__ . '/../..' . '/app/Monitor.php',
        'Automattic\\Jetpack_Inspect\\Monitor\\Incoming_REST_API' => __DIR__ . '/../..' . '/app/Monitor/Incoming_REST_API.php',
        'Automattic\\Jetpack_Inspect\\Monitor\\Observable' => __DIR__ . '/../..' . '/app/Monitor/Observable.php',
        'Automattic\\Jetpack_Inspect\\Monitor\\Outgoing' => __DIR__ . '/../..' . '/app/Monitor/Outgoing.php',
        'Automattic\\Jetpack_Inspect\\Monitors' => __DIR__ . '/../..' . '/app/Monitors.php',
        'Automattic\\Jetpack_Inspect\\Options\\Monitor_Status' => __DIR__ . '/../..' . '/app/Options/Monitor_Status.php',
        'Automattic\\Jetpack_Inspect\\Options\\Observer_Settings' => __DIR__ . '/../..' . '/app/Options/Observer_Settings.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Contracts\\Endpoint' => __DIR__ . '/../..' . '/app/REST_API/Contracts/Endpoint.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Contracts\\Has_Endpoints' => __DIR__ . '/../..' . '/app/REST_API/Contracts/Has_Endpoints.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Contracts\\Permission' => __DIR__ . '/../..' . '/app/REST_API/Contracts/Permission.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Endpoints\\Clear' => __DIR__ . '/../..' . '/app/REST_API/Endpoints/Clear.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Endpoints\\Latest' => __DIR__ . '/../..' . '/app/REST_API/Endpoints/Latest.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Endpoints\\Send_Request' => __DIR__ . '/../..' . '/app/REST_API/Endpoints/Send_Request.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Endpoints\\Test_Request' => __DIR__ . '/../..' . '/app/REST_API/Endpoints/Test_Request.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Permissions\\Current_User_Admin' => __DIR__ . '/../..' . '/app/REST_API/Permissions/Current_User_Admin.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Permissions\\Nonce' => __DIR__ . '/../..' . '/app/REST_API/Permissions/Nonce.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\REST_API' => __DIR__ . '/../..' . '/app/REST_API/REST_API.php',
        'Automattic\\Jetpack_Inspect\\REST_API\\Route' => __DIR__ . '/../..' . '/app/REST_API/Route.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Jetpack_IXR_Client' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-ixr-client.php',
        'Jetpack_IXR_ClientMulticall' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-ixr-clientmulticall.php',
        'Jetpack_Options' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-options.php',
        'Jetpack_Signature' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-signature.php',
        'Jetpack_Tracks_Client' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-tracks-client.php',
        'Jetpack_Tracks_Event' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-tracks-event.php',
        'Jetpack_XMLRPC_Server' => __DIR__ . '/../..' . '/jetpack_vendor/automattic/jetpack-connection/legacy/class-jetpack-xmlrpc-server.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2662d159b2161b86f56c5059a9d397af_inspectⓥ0_1_0_alpha::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2662d159b2161b86f56c5059a9d397af_inspectⓥ0_1_0_alpha::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2662d159b2161b86f56c5059a9d397af_inspectⓥ0_1_0_alpha::$classMap;

        }, null, ClassLoader::class);
    }
}
