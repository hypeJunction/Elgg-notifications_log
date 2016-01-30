<?php

/**
 * Notification editor
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'notifications_log_init');

/**
 * Initialize the plugin
 * @return void
 */
function notifications_log_init() {
	elgg_register_plugin_hook_handler('send', 'all', 'notifications_log_sent_message', 1000);
}

/**
 * Logs the notification sent
 *
 * @param string $hook   "send"
 * @param string $type   "all"
 * @param mixed  $return Result
 * @param array  $params Hook params
 * @return mixed
 */
function notifications_log_sent_message($hook, $type, $return, $params) {

	list($hook_type, $method) = explode(':', $type);
	if ($hook_type != 'notification') {
		return;
	}

	$notification = elgg_extract('notification', $params);

	$recipient = $notification->getRecipient();
	$sender = $notification->getSender();

	$content = array(
		'status' => $return === false ? 'failed' : 'sent',
		'subject' => $notification->subject,
		'summary' => $notification->summary,
		'body' => $notification->body,
	);
	$description = 'instant';
	
	$event = elgg_extract('event', $params);
	if ($event) {
		$action = $event->getAction();
		$actor = $event->getActor();
		$object = $event->getObject();
		$event_data = array(
			'action' => $action,
			'object' => is_callable(array($object, 'toObject')) ? $object->toObject() : array(
				'guid' => $object->guid,
				'id' => $object->id,
					),
			'actor' => is_callable(array($actor, 'toObject')) ? $actor->toObject() : array('guid' => $event->getActorGUID()),
		);

		$content = array_merge($content, $event_data);
		$description = str_replace(':', '_', $event->getDescription());
	}

	$name = implode('_', array(
		$method,
		"TO-$recipient->guid",
		"FROM-$sender->guid",
		$description,
		time(),
	));


	$dirname = elgg_get_config('dataroot') . '/notifications_log/';
	if (!is_dir($dirname)) {
		mkdir($dirname, 0700, true);
	}

	$filename = "{$dirname}{$name}.json";
	file_put_contents($filename, json_encode($content));
}
