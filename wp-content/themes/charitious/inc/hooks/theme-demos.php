<?php

function agmycoo_fw_ext_backups_demos( $demos ) {
	$demo_content_installer	 = 'https://wp.xpeedstudio.com/demo-content/charitious';
	$demos_array			 = array(
		'demo'			 => array(
			'title'			 => esc_html__( 'Import Demo', 'charitious' ),
			'screenshot'	 => esc_url( $demo_content_installer ) . '/default/screenshot.png',
			'preview_link'	 => esc_url( 'https://xpeedstudio.com/wp/charitious/' ),
		),
		
	);
	$download_url			 = esc_url( $demo_content_installer ) . '/manifest.php';
	foreach ( $demos_array as $id => $data ) {
		$demo						 = new FW_Ext_Backups_Demo( $id, 'piecemeal', array(
			'url'		 => $download_url,
			'file_id'	 => $id,
		) );
		$demo->set_title( $data[ 'title' ] );
		$demo->set_screenshot( $data[ 'screenshot' ] );
		$demo->set_preview_link( $data[ 'preview_link' ] );
		$demos[ $demo->get_id() ]	 = $demo;
		unset( $demo );
	}
	return $demos;
}


add_filter( 'fw:ext:backups-demo:demos', 'agmycoo_fw_ext_backups_demos' );