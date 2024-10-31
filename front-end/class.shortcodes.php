<?php

class Referer_Specific_Contact_Shortcodes
{
    private $_referrer;
    
    public function __construct()
    {
        add_shortcode( 'referer-contact-phone', array($this, 'phone') );
        add_shortcode( 'referer-contact-email', array($this, 'email') );
    }
    
    public function phone()
    {
        $this->_get_referrer();
        
        return $this->_print_contact_details('phone');
    }
    
    public function email()
    {
        $this->_get_referrer();
        
        return $this->_print_contact_details('email');
    }
    
    private function _get_referrer()
    {
        if (null === $this->_referrer) {
            if (empty($_SESSION['referer-specific-contact-referer'])) {
                $this->_save_referrer();
            }
            
            $this->_referrer = $_SESSION['referer-specific-contact-referer'];
        }
    }
    
    private function _save_referrer()
    {
        $referrer_url   = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $referrer       = 'default';
        
        $social_medias  = array('facebook.', 'twitter.', 't.co');
        
        if ($referrer_url != null) {
            
            if (strpos($referrer_url, 'google.') !==  false) {
                $referrer   = 'google_search';
            }
            
            if (strpos($referrer_url, 'googleadservices.') !==  false) {
                $referrer   = 'ppc';
            }
            
            foreach ($social_medias as $social_media) {
                if (strpos($referrer_url, $social_media) !==  false) {
                    $referrer   = 'social_media';
                    break;
                }
            }
        }
        
        if ($referrer != '') {
            $_SESSION['referer-specific-contact-referer'] = $referrer;
        }
    }
    
    private function _print_contact_details($key)
    {
        $contact_details    = '';
        $options            = get_option( 'referer_specific_contact_options' );
        
        if (!empty($options[$this->_referrer][$key])) {
            $contact_details = $options[$this->_referrer][$key];
        }
        
        if ($contact_details == '') {
            if (!empty($options['default'][$key])) {
                $contact_details = $options['default'][$key];
            }
        }
        
        return $contact_details;
    }
}

$referer_specific_contact_shortcodes = new Referer_Specific_Contact_Shortcodes();