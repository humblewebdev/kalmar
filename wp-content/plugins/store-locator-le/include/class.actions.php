<?php

/**
 * Store Locator Plus action hooks.
 *
 * The methods in here are normally called from an action hook that is
 * called via the WordPress action stack.
 *
 * @package StoreLocatorPlus\Actions
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2012-2013 Charleston Software Associates, LLC
 */
class SLPlus_Actions {

    //----------------------------------
    // Properties
    //----------------------------------

    /**
     * Has the getCompoundOption deprecation notice been shown already?
     *
     * @var boolean $depnotice_getCompoundOption
     */
    private  $depnotice_getCompoundOption = false;

    /**
     * The SLPlus plugin object.
     *
     * @var SLPlus $plugin
     */
    public $plugin = null;

    /**
     * True if admin init already run.
     * 
     * @var boolean
     */
    public $initialized = false;

    //----------------------------------
    // Methods
    //----------------------------------

    function SLPlus_Actions() {
        add_action( "load-post.php"     , array( $this, 'action_AddToPageHelp' ), 20 );
        add_action( "load-post-new.php" , array( $this, 'action_AddToPageHelp' ), 20 );
    }

    /**
     * Set the plugin property to point to the primary plugin object.
     *
     * Returns false if we can't get to the main plugin object.
     *
     * @global wpCSL_plugin__slplus $slplus_plugin
     * @return type boolean true if plugin property is valid
     */
    function set_Plugin() {
        if (!isset($this->plugin) || ($this->plugin == null)) {
            global $slplus_plugin;
            $this->plugin = $slplus_plugin;
        }
        return (isset($this->plugin) && ($this->plugin != null));
    }

    /**
     * Attach and instantiated AdminUI object to the main plugin object.
     *
     * @return boolean - true unless the main plugin is not found
     */
    function attachAdminUI() {
        if (!$this->set_Plugin()) { return false; }
        if (!isset($this->plugin->AdminUI) || !is_object($this->plugin->AdminUI)) {
            require_once(SLPLUS_PLUGINDIR . '/include/class.adminui.php');
            $this->plugin->AdminUI = new SLPlus_AdminUI();     // Lets invoke this and make it an object
        }
        return true;
    }

    /**
     * method: admin_init()
     *
     * Called when the WordPress admin_init action is processed.
     *
     * Builds the interface elements used by WPCSL-generic for the admin interface.
     *
     */
    function admin_init() {
        if (!$this->set_Plugin()) { return; }

        // Already been here?  Get out.
        if ($this->initialized)  { return; }            
        $this->initialized = true;

        // Update system hook
        // Premium add-ons can use the admin_init hook to utilize this.
        //
        require_once(SLPLUS_PLUGINDIR . '/include/class.updates.php');

        // Activation Helpers
        // Updates are handled via WPCSL via namespace style call
        //
        require_once(SLPLUS_PLUGINDIR . '/include/class.activation.php');
        $this->plugin->Activate = new SLPlus_Activate();
        register_activation_hook( __FILE__, array($this->plugin->Activate,'update')); // WP built-in activation call

        // If we are on an SLP controlled admin page
        //
        if ($this->plugin->check_isOurAdminPage()) {

            // Admin UI Helpers
            //
            $this->attachAdminUI();
            add_action('admin_enqueue_scripts',array($this->plugin->AdminUI,'enqueue_admin_stylesheet'));
            $this->plugin->AdminUI->build_basic_admin_settings();

            // Action hook for 3rd party plugins
            //
            do_action('slp_admin_init_complete');
        }
    }

    /**
     * Add content tab help to the post and post-new pages.
     */
    function action_AddToPageHelp() {
        get_current_screen()->add_help_tab(
            array(
                'id' => 'slp_help_tab',
                'title' => __('SLP Hints','csa-slplus'),
                'content' => 
                    '<p>'.
                    sprintf(
                        __('Store Locator Plus documentation can be found online at <a href="%s" target="csa">%s</a>.<br/>','csa-slplus'),
                        'http://www.StoreLocatorPlus.com/support/documentation/store-locator-plus/',
                        'StoreLocatorPlus.com/support/documentation/'
                        ).
                    sprintf(
                        __('View the <a href="%s" target="csa">[slplus] shortcode documentation</a>.','csa-slplus'),
                        'http://www.StoreLocatorPlus.com/support/documentation/store-locator-plus/shortcodes/'
                        ).
                    '</p>'

            )
        );
    }

    /**
     * Add the Store Locator panel to the admin sidebar.
     *
     */
    function admin_menu() {
        if (!$this->set_Plugin()) { return; }

        if (current_user_can('manage_slp')) {
            $this->attachAdminUI();
            do_action('slp_admin_menu_starting');

            // The main hook for the menu
            //
            add_menu_page(
                $this->plugin->name,
                $this->plugin->name,
                'manage_slp',
                $this->plugin->prefix,
                array($this->plugin->AdminUI,'renderPage_GeneralSettings'),
                SLPLUS_PLUGINURL . '/images/icon_from_jpg_16x16.png'
                );

            // Default menu items
            //
            $menuItems = array(
                array(
                    'label'             => __('Info','csa-slplus'),
                    'slug'              => 'slp_info',
                    'class'             => $this->plugin->AdminUI,
                    'function'          => 'renderPage_Info'
                ),
                array(
                    'label'             => __('Locations','csa-slplus'),
                    'slug'              => 'slp_manage_locations',
                    'class'             => $this->plugin->AdminUI,
                    'function'          => 'renderPage_Locations'
                ),
                array(
                    'label'             => __('User Experience','csa-slplus'),
                    'slug'              => 'slp_map_settings',
                    'class'             => $this->plugin->AdminUI,
                    'function'          => 'renderPage_MapSettings'
                ),
                array(
                    'label'             => __('General Settings','csa-slplus'),
                    'slug'              => 'slp_general_settings',
                    'class'             => $this->plugin->AdminUI,
                    'function'          => 'renderPage_GeneralSettings'
                ),
            );

            // Third party plugin add-ons
            //
            $menuItems = apply_filters('slp_menu_items', $menuItems);

            // Attach Menu Items To Sidebar and Top Nav
            //
            foreach ($menuItems as $menuItem) {

                // Sidebar connect...
                //

                // Using class names (or objects)
                //
                if (isset($menuItem['class'])) {
                    add_submenu_page(
                        $this->plugin->prefix,
                        $menuItem['label'],
                        $menuItem['label'],
                        'manage_slp',
                        $menuItem['slug'],
                        array($menuItem['class'],$menuItem['function'])
                        );

                // Full URL or plain function name
                //
                } else {
                    add_submenu_page(
                        $this->plugin->prefix,
                        $menuItem['label'],
                        $menuItem['label'],
                        'manage_slp',
                        $menuItem['url']
                        );
                }
            }

            // Remove the duplicate menu entry
            //
            remove_submenu_page($this->plugin->prefix, $this->plugin->prefix);

            $this->plugin->debugMP('slp.main','msg','SLP admin_menu() action complete.');
        }
    }


    /**
     * Create a Map Settings Debug My Plugin panel.
     *
     * @return null
     */
    function create_DMPPanels() {
        if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
        if (class_exists('DMPPanelSLPMain') == false) {
            require_once(SLPLUS_PLUGINDIR.'include/class.dmppanels.php');
        }
        $GLOBALS['DebugMyPlugin']->panels['slp.main']           = new DMPPanelSLPMain();
        $GLOBALS['DebugMyPlugin']->panels['slp.location']       = new DMPPanelSLPMapLocation();
        $GLOBALS['DebugMyPlugin']->panels['slp.mapsettings']    = new DMPPanelSLPMapSettings();
        $GLOBALS['DebugMyPlugin']->panels['slp.managelocs']     = new DMPPanelSLPManageLocations();
    }

    /**
     * Called when the WordPress init action is processed.
     */
    function init() {
        if (!$this->set_Plugin()) { return; }
        add_filter('codestyling_localization_excludedirs',array($this,'filter_CodeStylingSkipTheseDirs'));
        load_plugin_textdomain('csa-slplus', false, plugin_basename(dirname(SLPLUS_PLUGINDIR.'store-locator-le.php')) . '/languages');

        // Fire the SLP init starting trigger
        //
        do_action('slp_init_starting', $this);

        // Do not texturize our shortcodes
        //
        add_filter('no_texturize_shortcodes',array('SLPlus_UI','no_texturize_shortcodes'));

        /**
         * Register the store taxonomy & page type.
         *
         * This is used in multiple add-on packs.
         *
         */
        if (!taxonomy_exists('stores')) {
            // Store Page Labels
            //
            $storepage_labels =
                apply_filters(
                    'slp_storepage_labels',
                    array(
                        'name'              => __( 'Store Pages','csa-slplus' ),
                        'singular_name'     => __( 'Store Page', 'csa-slplus' ),
                        'add_new'           => __('Add New Store Page', 'csa-slplus'),
                    )
                );

            $storepage_features =
                apply_filters(
                    'slp_storepage_features',
                    array(
                        'title',
                        'editor',
                        'author',
                        'excerpt',
                        'trackback',
                        'thumbnail',
                        'comments',
                        'revisions',
                        'custom-fields',
                        'page-attributes',
                        'post-formats'
                    )
                );

            $storepage_attributes =
                apply_filters(
                    'slp_storepage_attributes',
                    array(
                        'labels'            => $storepage_labels,
                        'public'            => false,
                        'has_archive'       => true,
                        'description'       => __('Store Locator Plus location pages.','csa-slplus'),
                        'menu_postion'      => 20,
                        'menu_icon'         => SLPLUS_PLUGINURL . '/images/icon_from_jpg_16x16.png',
                        'show_in_menu'      => current_user_can('manage_slp'),
                        'capability_type'   => 'page',
                        'supports'          => $storepage_features,
                    )
                );

            // Register Store Pages Custom Type
            register_post_type(SLPlus::locationPostType,$storepage_attributes);

            register_taxonomy(
                    'stores',
                    'store_page',
                    array (
                        'hierarchical'  => true,
                        'labels'        =>
                            array(
                                    'menu_name' => __('Categories','csa-slplus'),
                                    'name'      => __('Store Categories','csa-slplus'),
                                 )
                        )
                );
        }

        // Fire the SLP initialized trigger
        //
        add_action('wp_enqueue_scripts',array($this,'wp_enqueue_scripts'));
        do_action('slp_init_complete', $this);

        // Update the broadcast URL with the registered plugins
        // registered plugins are expected to tell us they are here using
        // slp_init_complete
        //
        $this->plugin->broadcast_url = $this->plugin->broadcast_url . '&' . $this->plugin->create_addon_query();
        $this->plugin->settings->broadcast_url = $this->plugin->broadcast_url;
    }

    /**
     * Tell CodeStyling Localization to skip these directories...
     *
     * @param string[] $dirs
     */
    function filter_CodeStylingSkipTheseDirs($dirs) {
        if ($_POST['textdomain'] !== 'csa-slplus') { return dirs; }
        return array_merge(
                $dirs,
                array(
                    SLPLUS_PLUGINDIR . '.git',
                    SLPLUS_PLUGINDIR . 'css',
                    SLPLUS_PLUGINDIR . 'languages',
                    SLPLUS_PLUGINDIR . 'nbproject',
                    SLPLUS_PLUGINDIR . 'images',
                    SLPLUS_PLUGINDIR . 'WPCSL-generic/.git',
                    SLPLUS_PLUGINDIR . 'WPCSL-generic/base',
                    SLPLUS_PLUGINDIR . 'WPCSL-generic/build',
                )
            );
    }

    /**
     * This is called whenever the WordPress wp_enqueue_scripts action is called.
     */
    function wp_enqueue_scripts() {
        $this->plugin->debugMP('slp.main','msg','SLPlus_Actions:'.__FUNCTION__);
        $force_load = $this->plugin->settings->get_item('force_load_js',true);

        //------------------------
        // Register our scripts for later enqueue when needed
        //
        if (get_option(SLPLUS_PREFIX.'-no_google_js','off') != 'on') {
            $dbAPIKey = trim(get_option(SLPLUS_PREFIX.'-api_key',''));
            $api_key  = (empty($dbAPIKey)?'':'&key='.$dbAPIKey);
            $language = '&language='.$this->plugin->helper->getData('map_language','get_item',null,'en');
            wp_enqueue_script(
                    'google_maps',
                    'http'.(is_ssl()?'s':'').'://'.get_option('sl_google_map_domain','maps.google.com').'/maps/api/js?sensor=false' . $api_key . $language,
                    array(),
                    SLPLUS_VERSION,
                    !$force_load
                    );
        }

        $sslURL =
            (is_ssl()?
            preg_replace('/http:/','https:',SLPLUS_PLUGINURL) :
            SLPLUS_PLUGINURL
            );
        wp_enqueue_script(
                'csl_script',
                $sslURL.'/js/slp.js',
                array('jquery'),
                SLPLUS_VERSION,
                !$force_load
        );
        $this->plugin->UI->localizeSLPScript();
    }     


    /**
     * This is called whenever the WordPress shutdown action is called.
     */
    function wp_footer() {
        SLPlus_Actions::ManageTheScripts();
    }


    /**
     * Called when the <head> tags are rendered.
     */
    function wp_head() {
        if (!isset($this->plugin)               ) { return; }
        if (!isset($this->plugin->settings)     ) { return; }
        if (!is_object($this->plugin->settings) ) { return; }
        $this->plugin->loadPluginData();

        echo '<!-- SLP Custom CSS -->'."\n".'<style type="text/css">'."\n" .

                    // Map
                    "div#sl_div div#map {\n".
                        "width:{$this->plugin->data['sl_map_width']}{$this->plugin->data['sl_map_width_units']};\n" .
                        "height:{$this->plugin->data['sl_map_height']}{$this->plugin->data['sl_map_height_units']};\n" .
                    "}\n" .

                    // Tagline
                    "div#sl_div div#slp_tagline {\n".
                        "width:{$this->plugin->data['sl_map_width']}{$this->plugin->data['sl_map_width_units']};\n" .
                    "}\n" .

                    // FILTER: slp_ui_headers
                    //
                    apply_filters('slp_ui_headers','') .

             '</style>'."\n\n";
    }

    /**
     * This is called whenever the WordPress shutdown action is called.
     */
    function shutdown() {
        // Safety for themes not using wp_footer
        SLPlus_Actions::ManageTheScripts();
    }

    /**
     * Unload The SLP Scripts If No Shortcode
     */
    function ManageTheScripts() {
        if (!defined('SLPLUS_SCRIPTS_MANAGED') || !SLPLUS_SCRIPTS_MANAGED) {

            // If no shortcode rendered, remove scripts
            //
            if (!defined('SLPLUS_SHORTCODE_RENDERED') || !SLPLUS_SHORTCODE_RENDERED) {
                wp_dequeue_script('google_maps');
                wp_deregister_script('google_maps');
                wp_dequeue_script('csl_script');
                wp_deregister_script('csl_script');
            }
            define('SLPLUS_SCRIPTS_MANAGED',true);
        }
    }


     //------------------------------------------------------------------------
     // DEPRECATED
     //------------------------------------------------------------------------

     /**
      * Do not use, deprecated.
      *
      * @deprecated 4.0
      */
     function getCompoundOption() {
        if (!$this->depnotice_getCompoundOption) {
            $this->plugin->notifications->add_notice(9,$this->plugin->createstring_Deprecated(__FUNCTION__));
            $this->plugin->notifications->display();
            $this->depnotice_getCompoundOption = true;
        }
     }

}

// These dogs are loaded up way before this class is instantiated.
//
add_action("load-post",array('SLPlus_Actions','init'));
add_action("load-post-new",array('SLPlus_Actions','init'));

