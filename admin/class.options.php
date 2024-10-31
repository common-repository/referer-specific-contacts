<?php
class Referer_Specific_Contact_Admin
{
    private $options;
    
    private $_sections;
    
    private $_section_fields;
    
    private $_menu_slug = 'referer-specific-contact';

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page()
    {
        add_options_page(
            'Referer Specific Contact',
            'Referer Specific Contact',
            'manage_options',
            $this->_menu_slug,
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page()
    {
        $this->options = get_option( 'referer_specific_contact_options' );
        include dirname(REFERER_SPECIFIC_CONTCT_FILE) . '/admin/options.php';
    }

    public function page_init()
    {
        register_setting(
            'referer_specific_contact_option_group',
            'referer_specific_contact_options',
            array( $this, 'sanitize' )
        );
        
        $this->_initialize_sections();
        $this->_initialize_section_fields();
        $this->_add_sections();
    }
    
    public function sanitize( $input )
    {
        return $input;
    }
    
    private function _initialize_sections()
    {
        $this->_sections = array(
            array(
                'id'        => 'default',
                'title'     => 'Default Contact Details'
            ),
            array(
                'id'        => 'google_search',
                'title'     => 'Google Search'
            ),
            array(
                'id'        => 'ppc',
                'title'     => 'Google Ads'
            ),
            array(
                'id'        => 'social_media',
                'title'     => 'Social Media'
            )
        );
    }
    
    private function _initialize_section_fields()
    {
        $this->_section_fields  = array(
            array(
                'id'    => 'phone',
                'title' => 'Phone'
            ),
            
            array(
                'id'    => 'email',
                'title' => 'Email'
            )
        );
    }
    
    private function _add_sections()
    {
        foreach ($this->_sections as  $section) {
            
            add_settings_section(
                $section['id'],
                $section['title'],
                array( $this, 'print_section_info' ),
                $this->_menu_slug
            );
            
            $this->_add_section_fields($section['id']);
        }
    }
    
    public function print_section_info($arg)
    {
        if (!empty($arg['id'])) {
            
            $info = '';
            
            switch ($arg['id']) {
                case 'default':
                    $info   = 'Default contact details';
                    break;
                
                case 'google_search':
                    $info   = 'Contact details for Google search users';
                    break;
                
                case 'ppc':
                    $info   = 'Contact details for Google Ad users';
                    break;
                
                case 'social_media':
                    $info   = 'Contact details for social media users';
                    break;
                
            }
            
            echo $info;
        }
    }
    
    private function _add_section_fields($section_id)
    {
        foreach ($this->_section_fields as $field) {
            add_settings_field(
                $field['id'],
                $field['title'],
                array( $this, 'print_section_field' ),
                $this->_menu_slug,
                $section_id,
                array(
                    'section_id'    => $section_id,
                    'field_id'      => $field['id']
                )
            );
        }
    }
    
    public function print_section_field($field)
    {
        printf(
            '<input type="text" id="%1$s_%2$s" name="referer_specific_contact_options[%1$s][%2$s]" value="%3$s" />',
            $field['section_id'],
            $field['field_id'],
            isset( $this->options[$field['section_id']][$field['field_id']] ) ? esc_attr( $this->options[$field['section_id']][$field['field_id']]) : ''
        );
        
    }
}

$referer_specific_contact_admin = new Referer_Specific_Contact_Admin();