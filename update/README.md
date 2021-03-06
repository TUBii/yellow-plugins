Update plugin 0.7.22
===================
Keep your website up to date.

<p align="center"><img src="update-screenshot.png?raw=true" alt="Screenshot"></p>

## How to install plugin

1. [Download and install Datenstrom Yellow](https://github.com/datenstrom/yellow/).
2. [Download plugin](https://github.com/datenstrom/yellow-plugins/raw/master/zip/update.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `update.zip` into your `system/plugins` folder.

Do not delete the [plugin files](update.ini), they are always required.

## How to update a website

The first option is to update your website in a [web browser](https://github.com/datenstrom/yellow-plugins/tree/master/edit). Log in with your user account. Go to the settings and check for updates. Your website will show when updates are available. Only the webmaster can update the website. The webmaster's email is defined in file `system/config/config.ini`.

The second option is to update your website at the [command line](https://github.com/datenstrom/yellow-plugins/tree/master/command). Open a terminal window. Go to your installation folder, where the `yellow.php` is. Type `php yellow.php update`, you can add an optional feature and force the update if necessary. Deleted files can be found in the `system/trash` folder. See example below.

## How to add more features

You can download [plugins](https://developers.datenstrom.se/plugins/) and [themes](https://developers.datenstrom.se/themes/), copy files to your web hosting. You can also add more features at the [command line](https://github.com/datenstrom/yellow-plugins/tree/master/command). Open a terminal window. Go to your installation folder, where the `yellow.php` is. Type `php yellow.php install` followed by a feature. Multiple features can be installed at once. See example below.

The plugin uses the [cURL library](https://github.com/curl/curl) by Daniel Stenberg to download files.

## Example

Updating website at the command line:
 
`php yellow.php update`  
`php yellow.php update YellowCore`  
`php yellow.php update YellowCore force`  

Adding website features at the command line:

`php yellow.php install`  
`php yellow.php install YellowGallery YellowSearch YellowSitemap`  
`php yellow.php uninstall YellowGallery YellowSearch YellowSitemap `  

## Developer

Datenstrom. [Get support](https://developers.datenstrom.se/help/support).
