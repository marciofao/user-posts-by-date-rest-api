<?php
/*
 * Plugin Name:       User and posts Rest Endpoints
 * Description:       Provides information of users and its posts amount in a date rage using the endpoint: wp-json/users/v1/user-listing?range=
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Márcio Fão
 * Author URI:        https://marciofao.github.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpre
 * Domain Path:       /languages
 */

class WpreUsers {

	public function __construct() {

		add_action('rest_api_init', array($this, 'register_routes'));
	}

	/**
	 * Register REST Endpoint
	 */

	public function register_routes() {
		$version = '1';
		$namespace = 'users/v' . $version;
		$base = 'user-listing';
		register_rest_route($namespace, '/' . $base, array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => array($this, 'get_items'),
				'args' => array('')
			)
		));
	}

	public function get_items(WP_REST_Request $request) {

		$request['range'] ? $range = $request['range'] : $range = '';

		if (!$range) {
			return new WP_REST_Response("range is Required", 300);
		}

		$userlist = get_users();


		$data = array();
		foreach ($userlist as $user) {

			$user_data = array(
				"id" => $user->data->ID,
				"email" => $user->data->user_email,
				"posts" => $this->get_posts_number_by_author_range($user->data->ID, $range)
			);


			if ($user_data["posts"]) $data[] = $user_data;
		}

		return new WP_REST_Response($data, 200);
	}

	public function get_posts_number_by_author_range($author_id, $range) {
		$range = explode('-', $range);
		$args = array(
			'date_query' => array(
				array(
					'after'  => array(
						'year'   => substr($range[0], 0, 4),
						'month'  => substr($range[0], 4, 2),
						'day'    => substr($range[0], 6, 2),
					),
					'before'     => array(
						'year'   => substr($range[1], 0, 4),
						'month'  => substr($range[1], 4, 2),
						'day'    => substr($range[1], 6, 2),
					),
					'inclusive' => true,
				),
			),
			"author" => $author_id
		);
		$query = new WP_Query($args);

		return sizeof($query->posts);
	}
}

$ccusers = new WpreUsers();
