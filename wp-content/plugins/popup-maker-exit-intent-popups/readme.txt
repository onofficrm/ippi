=== Popup Maker - Exit Intent Popups ===
Contributors: danieliser, wppopupmaker
Author URI: https://wppopupmaker.com/
Plugin URI: https://wppopupmaker.com/extensions/exit-intent-popups/
Tags:
Requires at least: 3.4
Tested up to: 5.3
Stable tag: 1.4.0

Exit Intent opens a popup when users attempt to leave your site.

== Description ==
Exit Intent opens a popup when users attempt to leave your site.

== Changelog ==

= v1.4.0 - 12/05/2019 =
* Feature: Added multiple new exit intent methods for all devices.
  *  Mouse Leave - Traditional exit intent that detects mouse movements towards the close button, address bar or back button.
  *  Lost Browser Focus - When the user switches tabs, apps, or clicks anywhere outside of the current page.
  *  Back Button - Detects users clicking the back button and shows a popup.
  *  Link Click - Detects when users are intending to click a targeted link and triggers a popup.
  *  Time Delay (mobile fallback) - A simple time delay fallback for mobile devices.
  *  Mobile Scroll - Detects when users scroll down partially on the page then quickly back up showing their intent to leave.

= v1.3.1 - 08/24/2018 =
* Fix: Corrected activation routine issues that could prevent version number storage.

= v1.3.0 - 03/12/2018 =
* Updated for full Popup Maker v1.7 support.
  * Leveraged the new AssetCache reducing the need to load an extra JS file for this extension.
  * Autoloader
  * Upgrade routines.
* Fix: Added check to make sure FireFox select fields don't trigger the exit trigger.

= v1.2.1 - 09/01/2017 =
* Fix: Bug with certain Advanced Targeting Conditions.

= v1.2 - 03/21/2016 =
* Feature: Added (v1.4) trigger **Exit Intent**.
* Feature: Added (v1.4) trigger **Exit Prevention**.
* Improvement: Migrated code to new PUM boilerplate v2.
* Developer: Added automated build routines to eliminate build time errors making it to releases.

= v1.1.1 =
* Converted metabox fields to use new API for compatibility with Popup Maker v1.4.

= v1.1.0 =
* Rewritten to use the PM Boilerplate.
* Added POT file for translations.
* Added new option to set top detection sensitivity. This determines the distance from the top the popup begins triggering.
* Added new false positive detection. If a user immediately returns mouse back to the browser the popup won't trigger.
* Added false positive delay setting. This allows fine tuning of the delay once triggered before the popup shows.
* Added option for both hard and soft exit detection. This allows you to trigger the exit popup once no matter how the user intends to leave. This will help with mobile devices as well.
* Added option to show alert only. This is similar to hard exit except that it won't show a popup afterwards.
* Added manual cookie mode.

= v1.0.3 =
* Fixed bug in Hard Exit JS

= v1.0.2 =
* Added better exit detection checks.
* Assets now load only when needed.

= v1.0.1 =
* Version Change for Launch

= v1.0 =
* Initial Release
