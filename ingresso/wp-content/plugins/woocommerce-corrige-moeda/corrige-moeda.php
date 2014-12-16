<?php 
/*
Plugin Name: WooCommerce Corrige moeda
Plugin URI: http://vibemidia.com/woocommerce
Description: Corrige a moeda de exibição do WooCommerce de $ 20,00 e para R$ 20,00 deixando a moeda no padrão monetário brasileiro.
Version: 1.1
Author: John-Henrique <john@midianegocios.com.br>
Author URI: http://vibemidia.com
License: GPLv2
Requires at least: 3.0
Tested up to: 3.3.1
*/
/*
 *      Copyright 2012 John-Henrique <john@midianegocios.com.br>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
add_action('plugins_loaded', 'corrige_moeda', 0);
add_filter('woocommerce_currency_symbol', 'corrige_moeda' );
function corrige_moeda(){return 'R&#36;';}
?>