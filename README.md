Notification Logger for Elgg
============================
![Elgg 2.0](https://img.shields.io/badge/Elgg-2.0.x-orange.svg?style=flat-square)

## Features

 * Logs all notifications as json to dataroot

## Example Log File

```json
// notifications_log/email_TO-52_FROM-39_publish_object_blog_1454078136.json
{
	"status": "failed",
	"subject": "New blog post Summer",
	"summary": "New blog post <a href=\"http:\/\/example.dev\/blog\/view\/638\/summer\">Summer<\/a>",
	"body": "<p><a href=\"http:\/\/example.dev\/profile\/ismayil.khayredinov\">Ismayil Khayredinov<\/a>&nbsp;published a new blog post&nbsp;<a href=\"http:\/\/example.dev\/blog\/view\/638\/summer\"><\/a><\/p>\r\n\r\n<p>This is a blog about Summer<\/p>\r\n\r\n<a class=\"elgg-button elgg-button-action\" href=\"http:\/\/example.dev\/blog\/view\/638\/summer\">View<\/a>",
	"action": "publish",
	"object": {
		"guid": 638,
		"type": "object",
		"subtype": "blog"
	},
	"actor": {
		"guid": 39
	}
}
```