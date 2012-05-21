<?php

/*
Plugin Name: Email Author On Publish
Description: Emails author when pending post is published.
Author: Coen Jacobs
Author URI: http://coenjacobs.me
*/

add_action( 'pending_to_publish', 'cj_notify_on_pending_to_publish' );

function cj_notify_on_pending_to_publish( $post_id ) {
    global $post;

    if ( $post->post_author != get_current_user_id() ) {
    	$author = new WP_User( $post->post_author );

    	$email_data = array(
    		'to'      => $author->user_email,
    		'subject' => sprintf( __( 'Your post on %1$s has been published!', 'email_author_on_publish' ), get_bloginfo('name') ),
    		'message' => sprintf( __( 'Your post %1$s on %2$s has been published: %3$s', 'email_author_on_publish' ), $post->post_title, get_bloginfo( 'name' ), get_permalink( $post->ID ) ),
    	);

    	wp_mail( $email_data['to'], $email_data['subject'], $email_data['message'] );
    }
}

?>