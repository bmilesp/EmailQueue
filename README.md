
# Email Queue Plugin

Queue, Throttle, and Send-In-the-Future emails, and many other great features

Based off of the CakeDC Email Queue

# Requirements

CakePHP => 2.1

---

# Installation


_[Using [Composer](http://getcomposer.org/)]_

[View on Packagist](https://packagist.org/packages/bmilesp/email_queue), and copy the json snippet for the latest version into your project's `composer.json`. Eg, v. dev-master would look like this:

```javascript
{
	"require": {
		"bmilesp/email_queue": "dev-master"
	}
}
```


# Enable plugin

Add following lines in yout app/Config/bootstrap.php file

	CakePlugin::load('EmailQueue', array('bootstrap' => true));

# Usage
