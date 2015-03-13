<?php
/*
Plugin Name: Wufoo Shortcode Plugin
Description: Enables shortcode to embed Wufoo forms. Usage: <code>[wufoo username="chriscoyier" formhash="x7w3w3" autoresize="true" height="458" header="show" ssl="true"]</code>. This code is available to copy and paste directly from the Wufoo Code Manager.
Version: 1.42
License: GPL
Author: Chris Coyier / Wufoo
Author URI: http://wufoo.com
*/

function createWufooEmbedJS( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'username'   => '',
		'formhash'   => '',
		'autoresize' => true,
		'height'     => '500',
		'header'     => 'show',
		'ssl'        => '',
		'defaultv'   => '',
		'entsource'  => 'wordpress',
	), $atts );

	$username   = $atts['username'];
	$formhash   = $atts['formhash'];
	$autoresize = $atts['autoresize'];
	$height     = (int) $atts['height'];
	$header     = $atts['header'];
	$ssl        = $atts['ssl'];
	$defaultv   = $atts['defaultv'];
	$entsource  = $atts['entsource'];

	if ( ! $username || ! $formhash ) {

		$error = "
		<div style='border: 20px solid red; border-radius: 40px; padding: 40px; margin: 50px 0 70px;'>
			<h3>Uh oh!</h3>
			<p style='margin: 0;'>Something is wrong with your Wufoo shortcode. If you copy and paste it from the <a href='http://wufoo.com/docs/code-manager/'>Wufoo Code Manager</a>, you should be golden.</p>
		</div>";

		return $error;

	} else {

		$form_url = "http://$username.wufoo.com/forms/$formhash";

		$JSEmbed =  "<div id='wufoo-". esc_attr( $formhash ) ."'>\n";
		$JSEmbed .= "Fill out my <a href='". esc_url( $form_url ) ."'>online form</a>.\n";
		$JSEmbed .=  "</div>\n";

		$JSEmbed .= "<script type='text/javascript'>var ". esc_js( $formhash ) .";(function(d, t) {\n";
		$JSEmbed .= "var s = d.createElement(t), options = {\n";
		$JSEmbed .= "'userName'      : '". esc_js( $username ) ."',  \n";
		$JSEmbed .= "'formHash'      : '". esc_js( $formhash ) ."',  \n";
		$JSEmbed .= "'autoResize'    : ". esc_js( $autoresize ) .",  \n";
		$JSEmbed .= "'height'        : '". esc_js( $height ) ."',    \n";
		$JSEmbed .= "'async'         : true,                         \n";
		$JSEmbed .= "'header'        : '". esc_js( $header ) ."',    \n";
		$JSEmbed .= "'host'          : 'wufoo.com',                  \n";
		$JSEmbed .= "'entSource'     : '". esc_js( $entsource ) ."', \n";
		$JSEmbed .= "'defaultValues' : '". esc_js( $defaultv ) ."'   \n";

		// Only output SSL value if passes as param
		// Gratis and Ad Hoc plans don't show that param (don't offer SSL)
		if ( $ssl ) {
			$JSEmbed .= ",'ssl'          : ". esc_js( $ssl ) ."      \n";
		}
		$JSEmbed .= "};\n";

		$JSEmbed .= "s.src = ('https:' == d.location.protocol ? 'https://' : 'http://') + 'wufoo.com/scripts/embed/form.js';\n";
		$JSEmbed .= "s.onload = s.onreadystatechange = function() {\n";
		$JSEmbed .= "var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;\n";
		$JSEmbed .= "try { ". esc_attr( $formhash ) ." = new WufooForm();". esc_attr( $formhash ) .".initialize(options);". esc_attr( $formhash ) .".display(); } catch (e) {}}\n";
		$JSEmbed .= "var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);\n";
		$JSEmbed .= "})(document, 'script');</script>";

		/**
		 * iframe embed, loaded inside <noscript> tags
		 */
		$iframe_url = 'https://'. $username .'.wufoo.com/embed/'. $formhash . '/';
		if ( isset( $defaultv ) && '' !== $defaultv ) {
			$iframe_url .= "def/$defaultv&entsource=wordpress";
		} else {
			$iframe_url .= "def/entsource=wordpress";
		}
		$iframe_embed = '<iframe ';
		$iframe_embed .= 'height="'. (int) $height .'" ';
		$iframe_embed .= 'allowTransparency="true" frameborder="0" scrolling="no" style="width:100%;border:none;" ';
		$iframe_embed .= 'src="' . esc_url( $iframe_url ) .'">';

		$embed_url = 'https://'. $username .'.wufoo.com/forms/'. $formhash .'/';
		if ( isset( $defaultv ) && '' !== $defaultv ) {
			$embed_url .= "def/$defaultv&entsource=wordpress";
		} else {
			$embed_url .= "def/entsource=wordpress";
		}
		$iframe_embed .= '<a href="'. esc_url( $embed_url ) .'" rel="nofollow">Fill out my Wufoo form!</a>';
		$iframe_embed .= '</iframe>';

		/**
		 * Return embed in JS and iframe
		 */
		return "$JSEmbed <noscript> $iframe_embed </noscript>";

	}
}
add_shortcode( 'wufoo', 'createWufooEmbedJS' );
