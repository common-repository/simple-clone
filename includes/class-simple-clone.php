<?php
class Simple_Clone {

    public function run() {
        // hook into admin menu
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

        // hook into the post list actions
        add_filter( 'post_row_actions', array( $this, 'add_clone_link' ), 10, 2 );
        add_filter( 'page_row_actions', array( $this, 'add_clone_link' ), 10, 2 );

        // handle cloning
        add_action( 'admin_action_simple_clone_post', array( $this, 'clone_post' ) );
    }

    public function add_admin_menu() {
        // add an admin menu if necessary
    }

    public function add_clone_link( $actions, $post ) {
        // sanitize post ID before using it in URL
        $post_id = absint( $post->ID );
    
        // generate nonce-protected URL for cloning
        $actions['clone'] = '<a href="' . wp_nonce_url( 'admin.php?action=simple_clone_post&post=' . $post_id, 'simple_clone_post_' . $post_id ) . '">Clone</a>';
        
        return $actions;
    }
    

    public function clone_post() {
        // security check
        if ( ! isset( $_GET['post'] ) || ! isset( $_GET['_wpnonce'] ) ) {
            return;
        }
    
        // unslash and sanitize the nonce
        $nonce = sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) );
    
        // unslash and sanitize the post ID
        $post_id = absint( wp_unslash( $_GET['post'] ) );
    
        // verify the nonce
        if ( ! wp_verify_nonce( $nonce, 'simple_clone_post_' . $post_id ) ) {
            return;
        }
    
        // ensure post ID is valid
        if ( ! $post_id ) {
            return;
        }
    
        // get the original post
        $post = get_post( $post_id );
    
        if ( $post ) {
            // create a new post as a clone
            $new_post = array(
                'post_title'    => $post->post_title . ' (Clone)',
                'post_content'  => $post->post_content,
                'post_status'   => 'draft',
                'post_type'     => $post->post_type,
                'post_author'   => $post->post_author,
            );
    
            // insert the cloned post
            $new_post_id = wp_insert_post( $new_post );
    
            // check for errors during post insertion
            if ( is_wp_error( $new_post_id ) ) {
                return;
            }
    
            // copy post meta data from the original post
            $post_meta = get_post_meta( $post_id );
            foreach ( $post_meta as $key => $value ) {
                foreach ( $value as $meta_value ) {
                    add_post_meta( $new_post_id, $key, maybe_unserialize( $meta_value ) );
                }
            }
    
            // redirect to the edit screen for the new post
            wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
            exit;
        }
    }
    
    
}
